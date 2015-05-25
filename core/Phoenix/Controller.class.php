<?php

namespace Phoenix;

if (!defined('IN_PX'))
    exit;

use Tools\MsgHelper;
use Tools\Log4p as logger;

/**
 * Phoenix\Controller 所有前台页面访问的单一入口
 * 所有前台页面必须通过这个类进行访问
 * 解析相应的类并加载指定的模板文件
 * 类文件统一使用命名空间，并存放在 "/core/命名空间/xxx.class" 命名的路径中
 * 变量名“__xxx_xx__”为框架变量。页面类使用了 __InjectData 注入，才可以调用
 * 页面(view层)始终可以调用
 * 框架变量如果污染可能会导致框架运行不稳定
 * 任何注入带默认值的参数必须放在最后，因为php函数或方法只允许前面参数无默认值，后面参数有默认值
 * 否则会造成注入异常，例如：method($__RequestMapping = '..', $parameter)这是错误的
 * 应该写成：method($parameter, $__RequestMapping = '..')
 * 需要注入的类中 __construct 应该设为 public 级别
 * v3.2.3 _findController()方法中对根下的*泛匹配逻辑顺序略作调整(在未直接命中路由然后再查询泛匹配)
 * 		_pushUrlParameter() 修改一个foreach作用域 2013-10-22
 * v3.2.4 debug模式下监控到文件改动则直接清空controller,inject缓存并重新生成，拦截器拦截responsebody返回json
 * v3.2.5 页面返回值支持farward转向
 * v3.2.6 修正farward转向数据共享及保留最初url分析 __PHP_SELF__, __CI__, __CM__, __RM__ 保留为第一次入口 \Phoenix\Session 当值设为null时删除键
 * v3.2.7 修正3.2.6 的farward用户数据共享
 * v3.2.10 head当做get处理，响应一些负载均衡中的请求，修正
 * v3.2.11 增加languagesViewSingleDirectory，前台可以在单一目录下做i18n
 * header('Cache-control: private'); //解决后退页面过期或不存在的情况
 * header('Content-type: text/html; charset=utf-8');
 */

class Controller extends AbstractInterceptor {

    const VERSION = '3.2.11';

    private $_responseBody = false; //返回的json数据
    protected $_arySysPlugins = null;
    private $_aryHookApiUri = null;
    private $_currentBuffer = null;

    /**
     * 主函数
     * @param array $data
     * @param bool $isHookApi
     * @return null|string
     */
    public function run(Array & $data, $isHookApi = false) {
        $this->_currentBuffer = null;
        if ($isHookApi) {
//            $this->_data['__HOOK_API_FLAG__'] = true;
            if (is_null($this->_aryHookApiUri)) {
                $this->_aryHookApiUri = array();
            }
            array_push($this->_aryHookApiUri, $this->_data);
        }
        if ($this->_isForwardFlag) {//forward转向保留最初的url分析
            //注入转向后的url分析
            $this->_data['__PATHS__'] = $data['__PATHS__'];
            $this->_data['__PACKAGE__'] = $data['__PACKAGE__'];
        } else if (!empty($data)) {//除了传参取址，赋值的同时也必须引用
            $this->_data = & $data;
        }

        //赋值config信息
        parent::_getRouteConfig();

        $this->_importSysPlugin();
        $this->_execSysPlugin('init');

        //初始化配置
        $this->_parseRoutes();
        $this->_execSysPlugin('afterParseRoutes');
//        logger::debug($this->_data);
//        logger::debug($this->_currentBuffer);
        //执行页面相关类
        //cache的注入索引已在父类(\Phoenix\AbstractInterceptor)中固化
        $_cache = self::$_instances->inject('\Phoenix\Cache');
        ob_start();
        $this->_runController($_cache);
        $this->_currentBuffer = ob_get_clean();

        if (isset($this->_data['__CACHEABLE__'])) {
            $_cache->mode($this->_data['__CACHEABLE__'][2])
                ->expires($this->_data['__CACHEABLE__'][1])
                ->set(
                    $this->_data['__CACHEABLE__'][0]
                    . $this->_getCacheablePageName(),
                    $this->_currentBuffer
//                                , ob_get_contents()
                );
//                ob_end_flush();
        }

        if ($isHookApi) {//hook api标识
            if (count($this->_aryHookApiUri) > 0) {
                $this->_data = array_pop($this->_aryHookApiUri);
            }
            if (count($this->_aryHookApiUri) == 0) {
                unset($this->_aryHookApiUri);
                $this->_aryHookApiUri = null;
            }
            return $this->_currentBuffer;
        } else {
            echo $this->_currentBuffer;
        }

        $this->_outDebug();
    }

//	public function __destruct() { //经测试for循环中内存可以共享，所以不主动回收，由php自行管理
//		$this->_data = $this->_controllers = $this->_injectMapping = null;
//		unset($this->_injectMapping, $this->_controllers, $this->_data);
//	}

    /**
     * 运行模块类
     */
    private function _runController($cache) {
        //$_cache->gc();
        $_aspectClassList = $this->_monitoringAspectp($cache);
        /**
         * 使用memcache缓存情况下使用框架缓存及注入索引比单纯的反射性能至少提升20%，基本符合PHP反射带来的性能损耗
         * 硬盘缓存情况下由于机械硬盘的io限制，但也比单纯的反射性能略有提升
         * 框架默认使用注入索引
         */
        //是否开启注入索引
        $_isUseInjectMapping = true;
        if ($_isUseInjectMapping && count($this->_injectMapping) <= 1 &&
            false === ($this->_injectMapping = $cache->get($this->_injectMappingCacheId))) {
            //logger::debug(count($this->_injectMapping));
            $this->_injectMapping = $this->_cacheInjectMapping;
        }
        //用于修改比对的缓存文件
        $_corePath = CORE_PATH . $this->_data['__CORE_MAPPING_PATH__'];
        $_classList = null;
        if (false === $cache->exists($this->_controllersCacheId)) {
            $_classList = $this->_scan($cache, $_corePath, $_aspectClassList);
        }
        //如果开发模式下类有更改，自动更新缓存
        if (PX_DEBUG) {
            if (count($_classList) == 0 &&
                false === ($_classList = $cache->get($this->_classCacheId))) {
                $_classList = array();
            }
            $_classListChg = $this->_scanControllers($_corePath, $_classList);
            if (count($_classListChg) > 0) {
                $cache->gc();

                //重复以上步骤
                if ($_isUseInjectMapping)
                    $this->_injectMapping = $this->_cacheInjectMapping;

                $_classList = $this->_scan($cache, $_corePath, $this->_monitoringAspectp($cache));
            }
            $_classList = null;
            unset($_classList);
        }

        //缓存未命中进入独立剖析模式，频繁发生此情况应该进行缓存及程序自检
        $_hitControllerCacheFlag = true;
        if (is_null($this->_controllers) &&
            false === ($this->_controllers = $cache->get($this->_controllersCacheId))) {
            //$this->_httpStatus(503);
            logger::error('controllers cache misses.');
            $_hitControllerCacheFlag = false;
            /**
             * 在高并发缓存未命中的情况下根据包进行路由并临时剖析类提供服务(依赖cpu)
             * 提高框架的健壮性
             */
            $_tmpFolderOrFile = $_corePath . DIRECTORY_SEPARATOR
                . ucfirst($this->_data['__CONTROLLER_INDEX__']);

            if (is_file($_tmpFolderOrFile . '.class.php')) {
                self::$_instances->dissection($this->_data['__CORE_MAPPING_PATH__']
                    . '\\' . ucfirst($this->_data['__CONTROLLER_INDEX__']));
            } else {
                $this->_scanControllers($_tmpFolderOrFile);
            }
        }

        //未找到则判定为404，在命中缓存的情况下更新缓存
        if ((false === $this->_findController()) && $_hitControllerCacheFlag) {
            $cache->set($this->_controllersCacheId, $this->_controllers);
        }
        $this->_execSysPlugin('afterReadControllers');

//        logger::debug($this->_controllers);
        //die(var_dump($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]));
        //die(var_dump($this->_controllers));

        //logger::debug($this->_injectMapping);
        if ($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
            [$this->_data['__CONTROLLER_MAPPING__']][$this->_data['__ACCEPT_INDEX__']]
            [$this->_data['__METHOD__']]['__CONTROLLER_CLASS__'] != 404) {
            //装配参数
            $this->_pushUrlParameter();

            $this->_execSysPlugin('afterPushUrlParameter');

            //运行拦截器
            $this->_interceptorsWorker();
            //运行控制层
            //die(var_dump($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]));
            $this->_controllerLoader($cache);
            //如果设置了forward，此时已转向，如果第一个url未被拦截则执行第二个url
            //如果第一个已拦截，则不再运行拦截器，但是依旧执行第一个url拦截的后续方法
        } else {
            //Controller不存在时拦截器依旧运行
            $this->_interceptorsWorker();
        }
        //logger::debug($this->__RM__);
        if (count($this->_interceptorChain) > 0) {
            foreach ($this->_interceptorChain as $_handler) {
                if (false === $_handler->postHandle($this->_data)) {
                    $this->_interceptorRedirect();
                }
            }
        }
//        logger::debug($this->_controllers);
        //die(var_dump($this->_injectMapping['Chs_Index']['aspectMapping']));
        //die(var_dump($this->_data['__VIEW__']));
        //判断是否没有设定页面类
        if (is_null($this->_data['__REQUEST_MAPPING__'])) {
            $this->_data['__REQUEST_MAPPING__'] = trim($this->_data['__CONTROLLER_INDEX__']
                . $this->_data['__CONTROLLER_MAPPING__'], '/');
        }
        if (is_null($this->_data['__VIEW__'])) {
            $this->_data['__VIEW__'] = $this->_data['__REQUEST_MAPPING__'];
        }
        if (!isset($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
            [$this->_data['__CONTROLLER_MAPPING__']][$this->_data['__ACCEPT_INDEX__']]
            [$this->_data['__METHOD__']]['__ResponseBody'])) {
            $this->_data['__VIEW_ABSOLUTE_PATH__'] = $this->_data['__VIEW_ABSOLUTE_PATH__']
                . $this->_data['__VIEW__'] . $this->_data['__TAGLIB__'];
        }
//        die(var_dump($this->_data['__VIEW_ABSOLUTE_PATH__']));
//        die(var_dump($this->_data));
        //die(var_dump($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]));
        //logger::debug($this->_data);

        if (isset($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
                [$this->_data['__CONTROLLER_MAPPING__']][$this->_data['__ACCEPT_INDEX__']]
                [$this->_data['__METHOD__']]['__ResponseBody']) ||
            is_file($this->_data['__VIEW_ABSOLUTE_PATH__'])) {

            $this->_execSysPlugin('beforeViewLoader');

            // if (isset($this->_data['__CACHEABLE__']))
//                ob_start();
            if (isset($this->_data['__ACCEPT__'])) {
                header("Content-type: {$this->_data['__ACCEPT__']}; charset={$this->_data['__CHARSET__']}");
            }

            if (!isset($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
                [$this->_data['__CONTROLLER_MAPPING__']][$this->_data['__ACCEPT_INDEX__']]
                [$this->_data['__METHOD__']]['__ResponseBody'])) {
                include($this->_data['__VIEW_ABSOLUTE_PATH__']); //加载运行模板
                //视图加载完成的拦截器执行
                if (count($this->_interceptorChain) > 0) {
                    foreach ($this->_interceptorChain as $_handler) {
                        $_handler->afterCompletion($this->_data);
                    }
                }
            } else {
                echo $this->_responseBody;
            }
        } else {
            //抛出路径不存在错误，404
            if (PX_DEBUG) {
                MsgHelper::get('0x00000006', $this->_data['__VIEW_ABSOLUTE_PATH__']); //抛出路由错误
            } else {
                $this->_httpStatus(404); //其他一律转到404
            }
        }
        //logger::debug($this->_injectMapping);
        if ($_isUseInjectMapping && $this->_isInjectChange) {
            $cache->set($this->_injectMappingCacheId, $this->_injectMapping);
        }
        //die(var_dump($this->_data));
        //die(var_dump($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]));
    }

    /**
     * 扫描
     * @param type $cache
     * @param type $corePath
     * @param type $aspectClassList
     * @return array|type
     */
    private function _scan($cache, $corePath, $aspectClassList) {
        $_classList = $this->_scanControllers($corePath);
        if (is_null($aspectClassList) && isset($this->_data['__ROUTE_CONFIG__']['aspectp'])) {
            $aspectClassList = & $this->_getAopFiletime();
        }

        if (count($aspectClassList) > 0) {
            $_classList = array_merge($_classList, $aspectClassList);
        }

        $cache->set($this->_classCacheId, $_classList);
        $cache->set($this->_controllersCacheId, $this->_controllers);
        return $_classList;
    }

    /**
     * 运行拦截器
     */
    private function _interceptorsWorker() {
        //如果拦截器配置文件存在
        //执行页面类运行前拦截器
        if (false === $this->_isExecInterceptor &&
            is_file($this->_data['__INTERCEPTORS_CONFIG_PATH__'])) {
            $this->_data['__INTERCEPTORS__'] = require_once $this->_data['__INTERCEPTORS_CONFIG_PATH__'];
            $_interceptor = null;
            if (isset($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
                [$this->_data['__CONTROLLER_MAPPING__']][$this->_data['__ACCEPT_INDEX__']]
                [$this->_data['__METHOD__']]['__INTERCEPTOR__'])) {
                $_interceptor = isset($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
                    [$this->_data['__CONTROLLER_MAPPING__']][$this->_data['__ACCEPT_INDEX__']]
                    [$this->_data['__METHOD__']]['__INTERCEPTOR__']);
            }
            if (!parent::_worker($_interceptor)) {
                $this->_interceptorRedirect();
            }
        }
    }

    /**
     * 拦截器转向
     */
    private function _interceptorRedirect() {
        //被拦截后返回转入指定的模块并传入一个用于返回当前页面的url值
        //如果是纯数字，如 404 500 503等
        $_isResponseBody = isset($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
            [$this->_data['__CONTROLLER_MAPPING__']][$this->_data['__ACCEPT_INDEX__']]
            [$this->_data['__METHOD__']]['__ResponseBody']);
        if (is_numeric($this->_data['__REAL_REDIRECT_CONTROLLER__'])) {
            if ($_isResponseBody) {
                die(MsgHelper::json($this->_data['__REAL_REDIRECT_CONTROLLER__']));
            } else {
                $this->_httpStatus($this->_data['__REAL_REDIRECT_CONTROLLER__']);
            }
        } else {
            if ($_isResponseBody) {
                die(MsgHelper::json('INTERCEPTOR'));
            } else {
                //此处url涉及到url传参
                //消除url关键字耦合
                $_returnParamKey = $this->_data['__INTERCEPTORS__']['returnParamKey'];
                $_url = isset($_GET[$_returnParamKey]) ?
                    $_GET[$_returnParamKey] :
                    'http://' . $_SERVER['HTTP_HOST']
                    . $_SERVER['REQUEST_URI'];

                $_url = '?' . $_returnParamKey . '=' . urlencode($_url);

                header("Location: http://{$_SERVER['HTTP_HOST']}/"
                    . ltrim($this->_data['__REAL_REDIRECT_CONTROLLER__'], '/')
                    . $_url . $this->_data['__INTERCEPTORS__']['anchor']);
                exit;
            }
        }
    }

    /**
     * 初始化当前页面的路由信息
     */
    private function _parseRoutes() {
        if (!isset($this->_data['__PACKAGE__'])) {
            $this->_data['__PACKAGE__'] = null;
        }

        $_hitFlag = false;
        $_i = 0;
        $this->_data['__LANGUAGE_ID__'] = 0;
        if (!is_null($this->_data['__PACKAGE__'])) {
            foreach ($this->_data['__ROUTE_CONFIG__']['languages'] as $_k => $_v) {
                if (strcasecmp($this->_data['__PACKAGE__'], $_k) == 0) {
                    $this->_data['__LANGUAGE_ID__'] = $_i;
                    $this->_data['__PACKAGE__'] = $_k;
                    if (isset($this->_data['__ROUTE_CONFIG__']['languages'][$_v])) {
                        $this->_data['__CORE_MAPPING_PATH__'] = $_v;
                    } else {
                        $this->_data['__CORE_MAPPING_PATH__'] = $_k;
                    }
                    $_hitFlag = true;
                    break;
                }
                $_i++;
            }
        }
        //未匹配到语言，取默认第一项
        if (!$_hitFlag) {
            if (!is_null($this->_data['__PACKAGE__'])) {
                array_unshift($this->_data['__PATHS__'], $this->_data['__PACKAGE__']);
            }
            reset($this->_data['__ROUTE_CONFIG__']['languages']);
            $this->_data['__CORE_MAPPING_PATH__'] = key($this->_data['__ROUTE_CONFIG__']['languages']);
            $this->_data['__PACKAGE__'] = $this->_data['__CORE_MAPPING_PATH__'];
        }

        //无任何参数，判定为首页
        if (count($this->_data['__PATHS__']) == 0) {
            $this->_data['__PATHS__'][0] = 'index';
        }
        $this->_data['__HOMEPAGE__'] = false;
        if (strcasecmp('index', $this->_data['__PATHS__'][0]) == 0) {
            /**
             * 为页面增加首页属性值
             */
            $this->_data['__HOMEPAGE__'] = true;
        }

        //页面物理路径，除模板包之外直接取包名对应页面地址(隐藏真实路径)
        $this->_data['__VIEW_ABSOLUTE_PATH__'] = ROOT_PATH
            . $this->_data['__ROUTE_CONFIG__']['assetsDirectory'] . DIRECTORY_SEPARATOR;
        //视图恒定则更改视图相关配置，不再以语言版本包为准
        $_lowerCI = strtolower($this->_data['__PATHS__'][0]);
        $this->_data['__PHP_SELF__'] = '';
        if (isset($this->_data['__ROUTE_CONFIG__']['viewConstant'][$_lowerCI])) {
            $this->_data['__PACKAGE__'] = $this->_data['__CORE_MAPPING_PATH__'] = $this
                ->_data['__ROUTE_CONFIG__']['viewConstant'][$_lowerCI];
            /**
             * 如果路由只有恒定目录，如（http://.../admin）则不排除，以响应路由做跳转
             */
            if (count($this->_data['__PATHS__']) > 1) {
                array_shift($this->_data['__PATHS__']);
            }
            //ViewConstant 视图恒定 用于判断__CI__是否命中为恒定目录 route.config配置
            $this->_data['__VC__'] = $_lowerCI;
            $this->_data['__PHP_SELF__'] = $_lowerCI . '/';
        } else if (!empty($this->_data['__ROUTE_CONFIG__']['languagesViewSingleDirectory'])) {
            $this->_data['__PACKAGE__'] = $this->_data['__CORE_MAPPING_PATH__'] = $this
                ->_data['__ROUTE_CONFIG__']['languagesViewSingleDirectory'];
        }
        $this->_data['__VIEW_ABSOLUTE_PATH__'] .= $this->_data['__PACKAGE__'] . DIRECTORY_SEPARATOR;
//        die(var_dump($this->_data));
        //用于包含文件的视图绝对路径
        $this->_data['__REQUIRE_ABSOLUTE_DIR__'] = $this->_data['__VIEW_ABSOLUTE_PATH__'];

        $this->_data['__ROOT__'] = rtrim($this->_data['__ROOT__'], '/') . '/';
        //==视图相对路径
        $this->_data['__ASSETS_PATH__'] = $this->_data['__ROOT__']
            . $this->_data['__ROUTE_CONFIG__']['assetsDirectory'] . '/';
        //静态 upload资源显示路径
        if (empty($this->_data['__ROUTE_CONFIG__']['cdnDomain'])) {//cdn
            $this->_data['__CDN__'] = $this->_data['__ROOT__']
                . $this->_data['__UPLOAD__'] . '/';

            $this->_data['__ASSETS_STATIC_PATH__'] = $this->_data['__ASSETS_PATH__']
                . $this->_data['__ROUTE_CONFIG__']['staticDirectory'] . '/';
        } else {
            $this->_data['__CDN__'] = $this->_data['__ROUTE_CONFIG__']['cdnDomain'] . '/';

            $this->_data['__ASSETS_STATIC_PATH__'] = $this->_data['__ROUTE_CONFIG__']['cdnDomain'] . '/'
                . $this->_data['__ROUTE_CONFIG__']['staticDirectory'] . '/';
        }
        $this->_data['__ASSETS_PATH__'] .= $this->_data['__PACKAGE__'] . '/';
        //==

        $this->_data['__CONTROLLER_INDEX__'] = array_shift($this->_data['__PATHS__']);
        $this->_data['__CONTROLLER_MAPPING__'] = '/' . implode('/', $this->_data['__PATHS__']);

        //当前完整的含参数请求地址
        $this->_data['__VIEW__'] = null;
        if (false === $this->_isForwardFlag) {
            $this->_data['__REQUEST_MAPPING__'] = null;
            $this->_data['__PHP_SELF__'] .= $this->_data['__CONTROLLER_INDEX__']
                . $this->_data['__CONTROLLER_MAPPING__'];
            $this->_data['__RC__'] = & $this->_data['__ROUTE_CONFIG__'];
            $this->_data['__CI__'] = & $this->_data['__CONTROLLER_INDEX__'];
            $this->_data['__CM__'] = & $this->_data['__CONTROLLER_MAPPING__'];
            //解析类时带入的请求地址，一般用于分页，可以不含分页符 当开启“*”泛匹配时无作用，需要方法中手动设定
            $this->_data['__RM__'] = & $this->_data['__REQUEST_MAPPING__'];
            $this->_data['__ASSETS__'] = & $this->_data['__ASSETS_PATH__'];
            $this->_data['__STATIC__'] = & $this->_data['__ASSETS_STATIC_PATH__'];
            $this->_data['__RAD__'] = & $this->_data['__REQUIRE_ABSOLUTE_DIR__'];
        } else {
            $this->_isForwardFlag = false;
        }

        //将cacheable目录限制在当前package中
        $this->_cacheablePack .= $this->_data['__PACKAGE__'] . '/';

        //类名中不能含有 "-"
        $this->_data['__CORE_MAPPING_PATH__'] = ucfirst(str_replace('-', '', $this->_data['__CORE_MAPPING_PATH__']));

        //获取拦截器配置文件
        $this->_data['__INTERCEPTORS_CONFIG_PATH__'] = CORE_PATH
            . $this->_data['__CORE_MAPPING_PATH__'] . DIRECTORY_SEPARATOR . 'interceptors.config.php';

        $this->_getPageMethod();

//        die(var_dump($this->_data));
    }

    /**
     * 控制层组件
     * 路由控制
     */
    private function _findController() {
        //$_controllerIndexCount = count($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]);
        $_flag = false;
        //logger::debug($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]);
        //logger::debug($this->_controllers);

        $this->_data['__ACCEPT_INDEX__'] = 0;

        if (isset($this->_controllers[$this->_data['__CONTROLLER_INDEX__']])) {
            //controller中只有一个方法，直接取第一个
            //logger::debug($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]);
            //默认取第一项在未设定路由但是页面存在的情况下会出问题，此段代码只留作参考
            if (isset($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
                [$this->_data['__CONTROLLER_MAPPING__']])) {
                $_flag = true;
            } else { //如果未直接匹配mapping，例如含其他参数的链接
                //var_dump($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]);
                //* $_tmpMapping = null;
                //* $_strlen = null;
                foreach ($this->_controllers[$this->_data['__CONTROLLER_INDEX__']] as $_cm => $_v) {
                    if ($_cm != '/' && isset($_v[0]['__REGX__'])) {
                        $_regx = '/^' . $_v[0]['__REGX__'] . '$/U';
                        //url大小写不敏感 updated:2014-01-09
                        //未走路由的映射始终大小写敏感，关键在于映射磁盘文件
                        //windows服务器大小写不敏感不存在此问题
                        if (false === $this->_data['__ROUTE_CONFIG__']['caseSensitive']) {
                            $_regx .= 'i';
                        }
                        if (preg_match($_regx, $this->_data['__CONTROLLER_MAPPING__'])
                            //* && (!$_flag || ($_flag && $_v['__STRLEN__'] > $_strlen)) //更长更匹配
                            //* 由于controller已经进行过排序，这里匹配的就是更长的优先匹配 //*注释部分属于更长更匹配循环全部url映射
                            //* 这里执行依赖于 \Phoenix\ProxyFactory 355-379行排序部分
                        ) {
                            //* $_strlen = $_v['__STRLEN__'];
                            //* $_tmpMapping = $_cm;
                            $this->_data['__CONTROLLER_MAPPING__'] = $_cm;
                            $_flag = true;
                            break;
                        }
                    }
                }
            }
        }
        if (false === $_flag && isset($this->_controllers['*'])) {
            foreach ($this->_controllers['*'] as $_cm => $_v) {
//				logger::debug($this->_data['__CONTROLLER_INDEX__'] . $this->_data['__CONTROLLER_MAPPING__']);
//				logger::debug($_v['__REGX__']);
                if ($_cm != '/' &&
                    isset($_v[0]['__REGX__']) &&
                    preg_match('/^' . $_v[0]['__REGX__'] . '$/iU', '/' . $this->_data['__CONTROLLER_INDEX__']
                        . rtrim($this->_data['__CONTROLLER_MAPPING__'], '/'))
                ) {
                    array_unshift($this->_data['__PATHS__'], $this->_data['__CONTROLLER_INDEX__']);
                    $this->_data['__CONTROLLER_INDEX__'] = '*';
                    $this->_data['__CONTROLLER_MAPPING__'] = $_cm;
                    $_flag = true;
                    break;
                }
            }
        }

        //die(var_dump($_flag));
        //die(var_dump($this->_data['__CONTROLLER_MAPPING__']));

        $_re = false;
        if (false === $_flag) {
            $_re = $this->_findPageWithoutController();
        } else { //路由命中
            $_re = true;
            $_consumeFlag = true; //消费类型命中 Content-Type
            $_produceFlag = true; //生产类型命中 Accept
            $_methodFlag = false; //method命中
            if (count($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
                [$this->_data['__CONTROLLER_MAPPING__']]) > 1
                || isset($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
                    [$this->_data['__CONTROLLER_MAPPING__']][$this->_data['__ACCEPT_INDEX__']]
                    [$this->_data['__METHOD__']]['__Consumes'])) {
                $_consumeFlag = false;
                $_produceFlag = false;
                //是否设置了content-type
                $_contentType = 'text/html';
                if (isset($_SERVER['CONTENT_TYPE'])) {
                    $_contentType = $_SERVER['CONTENT_TYPE'];
                    if (($_cut = strpos($_contentType, ';')) !== false) {
                        $_contentType = substr($_contentType, 0, $_cut);
                    }
                }
                $_sortAccept = $this->_sortAccept();

                foreach ($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
                         [$this->_data['__CONTROLLER_MAPPING__']] as $_key => $_v) {
                    if (isset($_v[$this->_data['__METHOD__']])) {
                        $_methodFlag = true;
                        if ($_key > 0) {
                            $this->_updateMethod($_key);
                        }
                    } else {
                        continue;
                    }

                    if (!isset($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
                        [$this->_data['__CONTROLLER_MAPPING__']][$_key][$this->_data['__METHOD__']]['__Consumes'])) {
                        if (!isset($_SERVER['CONTENT_TYPE'])) {
                            $_consumeFlag = true;
                            if (($_produceFlag = $this->_analysisAccept($_key, $_sortAccept))) {
                                $this->_data['__ACCEPT_INDEX__'] = $_key;
                                break;
                            }
                        }
                        continue;
                    }

                    $_consumes = $this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
                    [$this->_data['__CONTROLLER_MAPPING__']][$_key][$this->_data['__METHOD__']]['__Consumes'];
                    if (is_array($_consumes)) {
                        foreach ($_consumes as $_cs) {
                            if (strcmp('*/*', $_cs) == 0
                                || strpos($_contentType, str_replace('*', '', $_cs)) !== false
                                || strpos($_contentType, substr($_cs, 0, strrpos($_cs, '/')) . '/*') !== false
                            ) {
                                $_consumeFlag = true;
                                if (($_produceFlag = $this->_analysisAccept($_key, $_sortAccept))) {
                                    $this->_data['__ACCEPT_INDEX__'] = $_key;
                                    break 2;
                                }
                            }
                        }
                    } else if (strpos($_contentType, '*/*') !== false
                        || strpos($_contentType, str_replace('*', '', $_consumes)) !== false
                        || strpos($_contentType, substr($_consumes, 0, strrpos($_consumes, '/')) . '/*') !== false
                    ) {
                        $_consumeFlag = true;
                        if (($_produceFlag = $this->_analysisAccept($_key, $_sortAccept))) {
                            $this->_data['__ACCEPT_INDEX__'] = $_key;
                            break;
                        }
                    }
                }
                unset($_sortAccept);
                $_sortAccept = null;
            } else if (isset($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
                [$this->_data['__CONTROLLER_MAPPING__']][$this->_data['__ACCEPT_INDEX__']]
                [$this->_data['__METHOD__']])) {
                $this->_updateMethod($this->_data['__ACCEPT_INDEX__']);
                $_methodFlag = true;
            }

            if (false === $_methodFlag) {
                $this->_httpStatus(405);
            } else if (false === $_consumeFlag) {
                $this->_httpStatus(415);
            } else if (false === $_produceFlag) {
                $this->_httpStatus(406);
            }
        }

        return $_re;
    }

    /**
     * 分析可接受的文档类型，并输出文档与设定相符的文档，未命中返回406状态
     * @param $acceptIndex
     * @param $sortAccept
     * @return bool
     */
    private function _analysisAccept($acceptIndex, $sortAccept) {
        $_producesFlag = false;
        if (isset($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
            [$this->_data['__CONTROLLER_MAPPING__']][$acceptIndex]
            [$this->_data['__METHOD__']]['__Produces'])) {
            $_produces = $this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
            [$this->_data['__CONTROLLER_MAPPING__']][$acceptIndex]
            [$this->_data['__METHOD__']]['__Produces'];
            if (is_array($_produces)) {
                foreach ($sortAccept as $_k => $_v) {
                    foreach ($_produces as $_ps) {
                        if ($_k == '*/*') {
                            $this->_data['__ACCEPT__'] = $_ps;
                            $_producesFlag = true;
                            break 2;
                        } else {
                            $_k = str_replace('*', '', $_k);
                            $_tmpPs = str_replace('*', '', $_ps);
                            if (strcasecmp($_k, $_tmpPs) == 0
                                || strpos($_k, $_tmpPs) !== false // $_k application/json, $_ap application/*
                                || strpos($_tmpPs, $_k) !== false //$_ap application/json, $_k application/*
                            ) {
                                $this->_data['__ACCEPT__'] = $_ps;
                                $_producesFlag = true;
                                break 2;
                            }
                        }
                    }
                }
            } else if (strpos($_SERVER['HTTP_ACCEPT'], '*/*') !== false
                //$_produces : applictaion/*
                || strpos($_SERVER['HTTP_ACCEPT'], str_replace('*', '', $_produces)) !== false
                //$http_accept application/* $produces application/json
                || strpos($_SERVER['HTTP_ACCEPT'], substr($_produces, 0, strrpos($_produces, '/')) . '/*') !== false
            ) {
                //文本类型的生产无所谓权重，只要存在即命中
                $this->_data['__ACCEPT__'] = $_produces;
                $_producesFlag = true;
            }
        } else {
            $this->_data['__ACCEPT__'] = 'text/html';
            $_producesFlag = true;
        }
        return $_producesFlag;
    }

    /**
     * 将可接受文档类型按照权重排序
     * @return bool
     */
    private function _sortAccept() {
        //"text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"
        $_aryServerAccept = explode(',', $_SERVER['HTTP_ACCEPT']);
        $_sortAccept = array();
        foreach ($_aryServerAccept as $_sa) {
            if (strpos($_sa, ';') !== false) {
                $_tmp = explode(';', $_sa);
                $_sortAccept[$_tmp[0]] = str_replace('q=', '', $_tmp[1]) * 10;
            } else {
                $_sortAccept[$_sa] = 10;
            }
        }
        unset($_aryServerAccept);
        $_aryServerAccept = null;

        arsort($_sortAccept);
        return $_sortAccept;
    }

    /**
     * 将 http method 转发抹平
     * @param $acceptIndex
     */
    private function _updateMethod($acceptIndex) {
        //修改内存中转发的访问方法 POST => GET
        if (isset($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
                [$this->_data['__CONTROLLER_MAPPING__']][$acceptIndex]
                [$this->_data['__METHOD__']])
            && !is_array($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
            [$this->_data['__CONTROLLER_MAPPING__']][$acceptIndex]
            [$this->_data['__METHOD__']])) {
            $_method =
                $this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
                [$this->_data['__CONTROLLER_MAPPING__']][$acceptIndex]
                [$this->_data['__METHOD__']];

            $this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
            [$this->_data['__CONTROLLER_MAPPING__']][$acceptIndex]
            [$this->_data['__METHOD__']]
                = $this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
            [$this->_data['__CONTROLLER_MAPPING__']][$acceptIndex]
            [$_method];
        }
    }

    /**
     * 不通过控制层组件找寻页面
     * @return boolean
     */
    private function _findPageWithoutController() {
        $_tmpViewPath = $this->_data['__VIEW_ABSOLUTE_PATH__']
            . $this->_data['__CONTROLLER_INDEX__'];
        $_count = count($this->_data['__PATHS__']) > 0;
        if ($_count) {
            $_tmpViewPath .= DIRECTORY_SEPARATOR
                . implode(DIRECTORY_SEPARATOR, $this->_data['__PATHS__']);
        }
        if (!is_file($_tmpViewPath . $this->_data['__TAGLIB__']) && $_count) {
            $this->_data['__CONTROLLER_MAPPING__'] = null;
            $_paths = $this->_data['__PATHS__'];
            $_tmpViewPath = $this->_data['__VIEW_ABSOLUTE_PATH__']
                . $this->_data['__CONTROLLER_INDEX__'];
            foreach ($this->_data['__PATHS__'] as $_p) {
                array_pop($_paths);
                $_tmpViewPath .= DIRECTORY_SEPARATOR
                    . implode(DIRECTORY_SEPARATOR, $this->_data['__PATHS__']);
                if (is_file($_tmpViewPath . $this->_data['__TAGLIB__'])) { //逆向迭代找到最终存在的页面
                    //路由中参数已没有意义
                    $this->_data['__CONTROLLER_MAPPING__'] = implode('/', $this->_data['__PATHS__']);
                    break;
                }
            }
        }
        if (is_null($this->_data['__CONTROLLER_MAPPING__'])) {
            //controller及页面均无抛出异常
            if (PX_DEBUG) {
                MsgHelper::get('0x00000006', $this->_data['__PHP_SELF__']); //抛出路由错误
            } else {
                $this->_httpStatus(404); //其他一律转到404
            }
        } else {
            $this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
            [$this->_data['__CONTROLLER_MAPPING__']][$this->_data['__ACCEPT_INDEX__']]
            [$this->_data['__METHOD__']]['__CONTROLLER_CLASS__'] = 404;
        }
        return false;
    }

    /**
     * 装配url参数
     */
    private function _pushUrlParameter() {
        //压入url参数 存入_data中
        //方法中$__RequestMapping设定了传值，则需要用名称对应的变量取值
        //如 exampleMethod($id, $__RequestMapping = '/{id}')第一个参数$id对应{id}
        //这个传值在页面中可以$this->id直接调用。对方法是局部，对当前页面是全局
        //(从参数中调用并不会从_data中删除，供当前页面环境中调用)
        $_mapping = $this->_controllers[$this->_data['__CONTROLLER_INDEX__']][$this->_data['__CONTROLLER_MAPPING__']][$this->_data['__ACCEPT_INDEX__']];
        if (isset($_mapping['__PARAMS__']) || isset($_mapping['__PRIORITYS__'])) {
            //删除url中不属于占位符的参数
            $_paths = $this->_data['__PATHS__'];
            if (isset($_mapping['__CONSTANTS__'])) {//如果有常量存在
                foreach ($_mapping['__CONSTANTS__'] as $_constant) {
                    if (false !== ($_key = array_search($_constant, $_paths))) {
                        unset($_paths[$_key]);
                    }
                }
            }
            //正则参数优先匹配 __PRIORITYS__
            if (count($_paths) > 0 && isset($_mapping['__PRIORITYS__']) &&
                count($_mapping['__PRIORITYS__']) > 0) {
//			logger::debug($_paths);
//			logger::debug($_mapping['__PRIORITYS__']);
                foreach ($_paths as $_k => $_urlParam) {
                    foreach ($_mapping['__PRIORITYS__'] as $_priority => $_regx) {
                        if (strpos($_priority, '{') === false) {
                            if (preg_match('/^' . $_regx . '$/', $_urlParam)) {
                                $this->_data[$_priority] = $_urlParam;
                                unset($_paths[$_k], $_mapping['__PRIORITYS__'][$_priority]);
                                break;
                            }
                        } else {
                            if (preg_match('/^' . $_regx . '$/', $_urlParam, $_match) &&
                                count($_match) > 1) {
                                $_tmp = explode('{', $_priority);
                                unset($_match[0], $_tmp[0]);
                                foreach ($_match as $_key => $_v) {
                                    if ($_v != '')
                                        $this->_data[$_tmp[$_key]] = $_v;
                                }
                                unset($_paths[$_k], $_mapping['__PRIORITYS__'][$_priority]);
                                break;
                            }
                        }
                    }
                }
            }
            //匹配非正则变量 __PARAMS__
            if (count($_paths) > 0 &&
                count($_mapping['__PARAMS__']) > 0) {
                $_paths = array_slice($_paths, 0);
                foreach ($_paths as $_k => $_urlParam) {
                    if (isset($_mapping['__PARAMS__'][$_k])) {
                        $this->_data[$_mapping['__PARAMS__'][$_k]] = $_urlParam;
                    }
                }
            }
            $_paths = $_mapping = null;
            unset($_paths, $_mapping);
        }
    }

    /**
     * 运行页面类
     */
    private function _controllerLoader(& $cache) {
        $_clazz = $this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
        [$this->_data['__CONTROLLER_MAPPING__']][$this->_data['__ACCEPT_INDEX__']]
        [$this->_data['__METHOD__']]['__CONTROLLER_CLASS__'];
        //die(var_dump($_clazz));
        if (!is_null($_clazz)) {
            $this->_data['__CURRENT_PROPERTIES__'] = $this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
            [$this->_data['__CONTROLLER_MAPPING__']][$this->_data['__ACCEPT_INDEX__']]
            [$this->_data['__METHOD__']];
//        logger::debug($this->_data['__CURRENT_PROPERTIES__']);
            if (isset($this->_data['__CURRENT_PROPERTIES__']['__CACHEABLE__'])) {
                $this->_data['__CACHEABLE__'] = $this->_data['__CURRENT_PROPERTIES__']['__CACHEABLE__'];
                //连接一个cacheable目录
                $this->_data['__CACHEABLE__'][0] = $this->_cacheablePack . $this->_data['__CACHEABLE__'][0];

                if (!!($this->_currentBuffer = $cache->mode($this->_data['__CACHEABLE__'][2])
                    ->expires($this->_data['__CACHEABLE__'][1])
                    ->get(
                        $this->_data['__CACHEABLE__'][0]
                        . $this->_getCacheablePageName()
                    ))) {
                    return;
//                    echo $_pageCache;
//
//                    $this->_outDebug();
//
//                    exit;
                }
            }

            $_process = $this->_data['__CURRENT_PROPERTIES__']['__PROCESS__'];
            if (is_null($this->_data['__REQUEST_MAPPING__'])) {
                $this->_data['__REQUEST_MAPPING__'] = $this->_data['__CURRENT_PROPERTIES__']['__REQUEST_MAPPING__'];
            }
            $this->_data['__VIEW__'] = $this->_data['__CURRENT_PROPERTIES__']['__REQUEST_MAPPING__'];
            //die(var_dump($this->_data));
//            logger::debug($this->_data['__CURRENT_PROPERTIES__']);
            unset($this->_data['__CURRENT_PROPERTIES__']['__CONTROLLER_CLASS__'],
                $this->_data['__CURRENT_PROPERTIES__']['__PROCESS__'],
                $this->_data['__CURRENT_PROPERTIES__']['__REQUEST_MAPPING__'],
                $this->_data['__CURRENT_PROPERTIES__']['__CACHEABLE__'],
                $this->_data['__CURRENT_PROPERTIES__']['__INTERCEPTOR__']
            );
            if (count($this->_data['__CURRENT_PROPERTIES__']) > 0) {
                foreach ($this->_data['__CURRENT_PROPERTIES__'] as $_k => $_v) {
                    if (isset($this->_data[$_k])) {
                        $this->_data['__CURRENT_PROPERTIES__'][$_k] = $this->_data[$_k];
                    }
                }
            }
            //die(var_dump($this->_controllers[$this->_data['__CONTROLLER_INDEX__']][$this->_data['__CONTROLLER_MAPPING__']][$this->_data['__ACCEPT_INDEX__']]));
            //运行完毕
            //die(var_dump($this->_data['__VIEW__']));
            //重排参数索引 update:20140801
            $_currentProperties = array_values($this->_data['__CURRENT_PROPERTIES__']);
            $_completeData = self::$_instances->invoke($_clazz, $_process,
                $_currentProperties);
            if (isset($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
                [$this->_data['__CONTROLLER_MAPPING__']][$this->_data['__ACCEPT_INDEX__']]
                [$this->_data['__METHOD__']]['__ResponseBody'])) {//Rest优先
                //如果设定了 __ResponseBody ：返回json数据，不再执行后面所有动作
                $this->_responseBody = json_encode($_completeData);
            } else if (is_numeric($_completeData)) {
                $this->_httpStatus($_completeData);
            } else if (is_string($_completeData)) {//如果是字符串则直接返回到页面
                $this->_setViewOrRedirect($_completeData);
            } else {
                //die(var_dump($this->_data));
                //die(var_dump(isset($this->_injectMapping[$_clazz])));
                //如果返回数组
                if (is_array($_completeData)) {
                    if (isset($_completeData['view']) &&
                        is_string($_completeData['view'])) {
                        $this->_setViewOrRedirect($_completeData['view']);
                        unset($_completeData['view']);
                    }
                    /**
                     * 如果设置的为标准格式
                     * return array('view' => 'string', 'model' => array('key' => 'value'...));
                     * 或者为包含view的数组都可以正常解析
                     * 推荐返回视图及数据的时候使用标准格式，及含只有view model的数组，更语义化
                     */
                    if (isset($_completeData['model'])) {
                        $_completeData = $_completeData['model'];
                    }
                    //如果本类未注入框架数据则将返回的数组绑定至框架中统一返回给视图
                    //避免返回的数据已经注入过框架数据
                    //视图中始终能获取到框架变量
                    if (!isset($_completeData['__ROUTE_CONFIG__'])) {
                        $this->_data = array_merge($this->_data, $_completeData);
                    } else {
                        $this->_data = $_completeData;
                    }
                }
                //die(var_dump($_completeData));
            }
            $_completeData = null;
            unset($_completeData);
            //die(var_dump($this->_data['__PHP_SELF__']));
            //$this->_data['__PHP_SELF__'] = trim($this->_data['__PHP_SELF__'], '/');
        }
    }

    /**
     * redirect跳转
     * @param type $view
     */
    private function _setViewOrRedirect($view) {
        if (strpos($view, ':') === false) {
            $this->_data['__VIEW__'] = $view;
        } else {
            if (strpos($view, '301:') !== false) {
                header('HTTP/1.1 301 Moved Permanently');
                header("Location: http://{$_SERVER['HTTP_HOST']}" . str_replace('301:', '', $view));
            } else if (strpos($view, 'redirect:') !== false) {
                header("Location: http://{$_SERVER['HTTP_HOST']}" . str_replace('redirect:', '', $view));
            } else if (strpos($view, 'forward:') !== false) {
                $this->_isForwardFlag = true;
                \Phoenix::work(str_replace('forward:', '', $view));
            }
            exit;
        }
    }

    /**
     * 获取restful方法
     */
    private function _getPageMethod() {
        if (!isset($this->_data['__METHOD__']))
            $this->_data['__METHOD__'] = $_SERVER['REQUEST_METHOD'];
        if (strcasecmp('POST', $this->_data['__METHOD__']) == 0) {
            if (isset($_POST['_method'])) {
                switch (strtolower($_POST['_method'])) {
                    case 'put' :
                        $this->_data['__METHOD__'] = 'PUT';
                        break;
                    case 'delete' :
                        $this->_data['__METHOD__'] = 'DELETE';
                        break;
                }
            }
        }
    }

    /**
     * 扫描控件
     * @param type $_path
     * @return type
     */
    private function _scanControllers($_path, & $_classList = null) {
        $_list = array();
        foreach (glob($_path . '/*') as $_item) {
            if (is_dir($_item)) {
                $_list = array_merge($_list, $this->_scanControllers($_item, $_classList));
            } else if (strpos($_item, '.class.php') !== false) {
                $_clazz = str_replace(array(CORE_PATH, '.class.php', '/', DIRECTORY_SEPARATOR),
                    array('', '', '\\', '\\'), $_item);
                //logger::debug($_clazz);
                $_ft = filemtime($_item);
                if (class_exists($_clazz) &&
                    (is_null($_classList) || !isset($_classList[$_clazz]) || $_ft != $_classList[$_clazz])) {

                    self::$_instances->dissection($_clazz); //分析类并拿到映射
                    $_list[$_clazz] = $_ft;
                }
            }
        }
        return $_list;
    }

    /**
     * 输出调试信息
     */
    private function _outDebug() {
        if (PX_DEBUG && !isset($this->_controllers[$this->_data['__CONTROLLER_INDEX__']]
                [$this->_data['__CONTROLLER_MAPPING__']][$this->_data['__ACCEPT_INDEX__']]
                [$this->_data['__METHOD__']]['__ResponseBody'])) {
            $this->_data['__E_MEMORY_USE__'] = memory_get_usage();
            $this->_data['__E_RUNTIME__'] = microtime(true);
            $_output = '<p style="' . (PX_DEBUG_DISPLAY ? '' : 'position:absolute;z-index:-1;top:-9999px;left:-9999px;')
                . 'text-align:center;font-size:12px;color:red;">执行时间：'
                . ($this->_data['__E_RUNTIME__'] - $this->_data['__S_RUNTIME__'])
                . '秒 查询数据库'
                . (isset($this->_data['db']) ? $this->_data['db']->total() : '0')
                . '次 内存使用：'
                . ($this->_convert($this->_data['__E_MEMORY_USE__'])
                    . ' - ' . $this->_convert($this->_data['__S_MEMORY_USE__'])
                    . ' = ' . $this->_convert($this->_data['__E_MEMORY_USE__'] - $this->_data['__S_MEMORY_USE__']))
                . ' 当前模式：developer</p>';

            echo $_output;
        }
    }

    /**
     * 获取页面缓存的命名后缀
     * @return type
     */
    private function _getCacheablePageName() {
        return count($this->_data['__PATHS__']) > 0 ?
            '_' . implode('', $this->_data['__PATHS__']) :
            '';
    }

    /**
     * 在模板生成中析构函数执行顺序不能达到要求
     * 改成直接插入数组
     * @param array $data
     * @return type
     */
    public static function start(Array & $data = array('__PACKAGE__' => '',
        '__PATHS__' => array()), $isHookApi = false) {
        if (is_null(static::$_instances)) {
            static::$_instances = new ProxyFactory();
        }
        return static::$_instances->run($data, $isHookApi);
    }

}
