<?php

namespace Phoenix;

if (!defined('IN_PX'))
    exit;

use Tools\MsgHelper;
use Tools\Log4p as logger;

/**
 * Handler类不走路由，不会解析路由进行分发，必须映射到具体的类
 * Handler只运行指定类，故速度比Controller要快的多
 * 可以使用拦截器，如果使用拦截器的话需要在对应包中interceptors.config.php注册
 */
class HttpHandler extends ProxyFactory {

    const VERSION = '3.2.4';

    private $_aryHookApiUri = null;
    private $_currentBuffer = null;

//    private function __construct() {
//        
//    }

    public function run(Array & $data, $isHookApi = false) {
        $this->_currentBuffer = null;
        if ($isHookApi) {
//            $this->_data['__HOOK_API_FLAG__'] = true;
            if (is_null($this->_aryHookApiUri)) {
                $this->_aryHookApiUri = array();
            }
            array_push($this->_aryHookApiUri, $this->_data);
        }
        if (!empty($data)) {//除了传参取址，赋值的同时也必须引用
            $this->_data = & $data;
        }
        //赋值config信息
        parent::_getRouteConfig();

        $this->_importSysPlugin();
        $this->_execSysPlugin('init');

        $this->_parseRoutes();

        $this->_execSysPlugin('afterParseRoutes');
        //取出模块对应的类
        if (is_file(CORE_PATH . 'Handler' . DIRECTORY_SEPARATOR
            . implode(DIRECTORY_SEPARATOR, $this->_data['__ARY_HANDLER_PATHS__'])
            . '.handler.php')) {
            $_cache = $this->inject('\Phoenix\Cache');

            $this->_monitoringAspectp($_cache);

            //是否开启注入索引
            //$_isUseInjectMapping = true;
            $_isUseInjectMapping = !PX_DEBUG; //调试期不开注入索引
            if ($_isUseInjectMapping &&
                count($this->_injectMapping) <= 1 &&
                false === ($this->_injectMapping = $_cache->get($this->_injectMappingCacheId))) {
                $this->_injectMapping = $this->_cacheInjectMapping;
            }

            ob_start();
            $this->_processModelClass($this->inject($this->_data['__HANDLER_CLASS_NAME__']));
            $this->_currentBuffer = ob_get_clean();

            if ($_isUseInjectMapping && $this->_isInjectChange) {
                $_cache->set($this->_injectMappingCacheId, $this->_injectMapping);
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
                echo($this->_currentBuffer);
            }
        }
        //die(var_dump($this->_data));
        //$this->_checkResourcesOccupation();
        //$this->_data = null;
        //unset($this->_data);
    }

    /**
     * 测试handler运行时间及内存使用，并写入调试日志
     */
    private function _checkResourcesOccupation() {
        $this->_data['__E_MEMORY_USE__'] = memory_get_usage();
        $this->_data['__E_RUNTIME__'] = microtime(true);
        $_output = $this->_data['__PHP_SELF__'] . ' 执行时间：'
            . ($this->_data['__E_RUNTIME__'] - $this->_data['__S_RUNTIME__'])
            . ' 内存使用：'
            . ($this->_convert($this->_data['__E_MEMORY_USE__'])
                . ' - ' . $this->_convert($this->_data['__S_MEMORY_USE__'])
                . ' = ' . $this->_convert($this->_data['__E_MEMORY_USE__'] - $this->_data['__S_MEMORY_USE__']));

        logger::info($_output);
    }

    /**
     * 加载页面类 M层
     * @param \Phoenix\IHttpHandler $handler 如果加入aop则不能限制handler的类型
     * 			也有可能为(Phoenix_ProxyHandler)
     */
    //private function _processModelClass(\Phoenix\IHttpHandler & $handler) {
    private function _processModelClass($handler) {
        //$handler->boolSubjectInterceptor();
        $_handlerInstances = null;
        //\Phoenix\IHttpHandler中才有 processRequest，可以判断是否为代理类
        $_isProxy = method_exists($handler, 'processRequest') ? false : true;
        if ($_isProxy) {
            $_handlerInstances = $handler->currentInstances();
        } else {
            $_handlerInstances = $handler;
        }

        //抽出包里面的路由配置
        $this->_data['__INTERCEPTORS_CONFIG_PATH__'] = CORE_PATH
            . $this->_data['__ARY_HANDLER_PATHS__'][0] . DIRECTORY_SEPARATOR . 'interceptors.config.php';
        if (is_file($this->_data['__INTERCEPTORS_CONFIG_PATH__'])) {
            $this->_data['__INTERCEPTORS__'] = require_once($this->_data['__INTERCEPTORS_CONFIG_PATH__']);
            if (isset($this->_injectMapping[$this->_data['__HANDLER_CLASS_NAME__']]['interceptor']) &&
                !parent::_worker($this->_injectMapping[$this->_data['__HANDLER_CLASS_NAME__']]['interceptor'])) {
                //handler被拦截一律返回被拦截json状态
                die(MsgHelper::json('INTERCEPTOR'));
            }
        }

        if ($_isProxy) {
            $_currentProperties = array($this->_data);
            self::$_instances->invoke($this->_data['__HANDLER_CLASS_NAME__'],
                'processRequest',
                $_currentProperties); //包裹成一个参数传入
            $this->_data = & $handler->getProxyData();
        } else {
            $_handlerInstances->processRequest($this->_data);
        }
        //$handler->processRequest($this->_data);
        if (count($this->_interceptorChain) > 0) {
            foreach ($this->_interceptorChain as $_handler) {
                $_handler->afterCompletion($this->_data);
            }
        }
    }

    /**
     * 加载配置
     */
    private function _parseRoutes() {
        //handler不走路由，只保留具体类的地址，其他参数使用get，post获取
        $this->_data['__CONTROLLER_MAPPING__'] = array_shift($this->_data['__PATHS__']);
        $this->_data['__ARY_HANDLER_PATHS__'] = explode('.', $this->_data['__CONTROLLER_MAPPING__']);

        //执行页面真实的分发，用于拦截器的执行
        //$this->_data['__CONTROLLER_INDEX__'] = 'handler';
        $this->_data['__CONTROLLER_MAPPING__'] = '/' . $this->_data['__CONTROLLER_MAPPING__'];
//        if (false !== $this->_isForwardFlag) {
//            $this->_data['__PHP_SELF__'] = $this->_data['__CONTROLLER_INDEX__']
//                    . rtrim($this->_data['__CONTROLLER_MAPPING__'], '/');
//        } else {
//            $this->_isForwardFlag = false;
//        }
        if (false !== $this->_isForwardFlag) {
            $this->_isForwardFlag = false;
        }
        $this->_data['__CORE_MAPPING_PATH__'] = strtolower($this->_data['__ARY_HANDLER_PATHS__'][0]);

        if (isset($this->_data['__ROUTE_CONFIG__']['viewConstant'][$this->_data['__CORE_MAPPING_PATH__']])) {
            $this->_data['__PACKAGE__'] = $this->_data['__CORE_MAPPING_PATH__'] = $this
                ->_data['__ROUTE_CONFIG__']['viewConstant'][$this->_data['__CORE_MAPPING_PATH__']];
        } else if (!empty($this->_data['__ROUTE_CONFIG__']['languagesViewSingleDirectory'])) {
            $this->_data['__PACKAGE__'] = $this->_data['__CORE_MAPPING_PATH__'] = $this
                ->_data['__ROUTE_CONFIG__']['languagesViewSingleDirectory'];
        }

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

        $this->_data['__ASSETS__'] = & $this->_data['__ASSETS_PATH__'];

        $this->_injectMappingCacheId .= 'handler';

        $this->_data['__HANDLER_CLASS_NAME__'] = '\Handler\\' . implode('\\', $this->_data['__ARY_HANDLER_PATHS__']);
    }

    public static function process(Array & $data = array('__CONTROLLER_INDEX__' => 'handler',
        '__PATHS__' => array()), $isHookApi = false) {
        if (is_null(self::$_instances)) {
            self::$_instances = new self();
        }
        return self::$_instances->run($data, $isHookApi);
    }

}
