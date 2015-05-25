<?php

if (!defined('IN_PX'))
    exit;

class Phoenix {

    const VERSION = '1.0.11';

    /**
     * dispatcher
     * @param null $pathInfo
     */
    public static function dispatcher($pathInfo = null) {
        if (strcasecmp('HEAD', $_SERVER['REQUEST_METHOD']) == 0) {
            header('HTTP/1.1 200 OK');
            exit;
        }
        
        if (is_null($pathInfo)) {
            if (substr(PHP_SAPI, 0, 3) == 'cli') {
                $_GET = array_slice($_SERVER['argv'], 1);
            }
            self::getRequestURI();
            $pathInfo = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $pathInfo = urldecode($pathInfo);
        }

        // 注册AUTOLOAD方法
        spl_autoload_register(array('Phoenix', 'autoload'));

        set_exception_handler(array('Phoenix\FormatException', 'staticException'));

        self::work($pathInfo);
    }

    /**
     * 已经 spl_autoload_register 之后调用
     * @param $pathInfo
     * @param bool $isHookApi
     * @return null|\Phoenix\type|string
     */
    public static function work($pathInfo, $isHookApi = false) {
        $_data = array();
        if (PX_DEBUG && !$isHookApi) {
            $_data['__S_RUNTIME__'] = microtime(true);
            $_data['__S_MEMORY_USE__'] = memory_get_usage();
        }
        $pathInfo = trim($pathInfo, '/');

        $_data['__PATHS__'] = array();
        $_isHandler = false;
        if ($pathInfo != '') {
            $_extensions = pathinfo($pathInfo, PATHINFO_EXTENSION); //扩展名

            $_isHandler = stripos($pathInfo, 'handler/') === 0;

            if (false === $_isHandler) {
                $_data['__SUFFIX__'] = 'php';
                //清除路径上的前后缀
                $_data['__ROUTE_CONFIG__'] = require_once(CORE_PATH . 'route.config.php');
                $_data['__ROOT__'] = & $_data['__ROUTE_CONFIG__']['root'];
                if ($_data['__ROOT__'] != '/') {
                    $_root = trim($_data['__ROOT__'], '/') . '/';
                    if (strpos($pathInfo, $_root) === 0) {
                        $pathInfo = substr($pathInfo, 0, strlen($_root));
                    }
                }

                if (!empty($_extensions)) {//有后缀
                    $_data['__SUFFIX__'] = $_extensions;
                    $pathInfo = substr($pathInfo, 0, strrpos($pathInfo, '.'));
                }

                //首页忽略文档类型
                $_data['__MIME__'] = \Phoenix\Controller::mime($_data['__SUFFIX__']);
            } else {
                $_data['__SUFFIX__'] = 'json';

                if (strcasecmp($_extensions, $_data['__SUFFIX__']) === 0
                    || strcasecmp($_extensions, 'xml') === 0) {
                    $_data['__SUFFIX__'] = $_extensions;
                    $pathInfo = substr($pathInfo, 0, strrpos($pathInfo, '.'));
                }
            }
            $_data['__PATHS__'] = explode('/', $pathInfo);
            $_data['__PACKAGE__'] = array_shift($_data['__PATHS__']);
        }

        if ($_isHandler) {
            $_data['__CONTROLLER_INDEX__'] = 'handler';
            return \Phoenix\HttpHandler::process($_data, $isHookApi);
        } else {
            return \Phoenix\Controller::start($_data, $isHookApi);
        }
    }

    /**
     * 内部hook，默认的格式为json，此处直接输出json数组给内部调用者
     * @param type $pathInfo
     * @return type
     */
    public static function hookApi($pathInfo) {
        return json_decode(self::work($pathInfo, true), true);
    }

    /**
     * getRequestURI
     */
    public static function getRequestURI() {
        if (isset($_SERVER['HTTP_X_ORIGINAL_URL'])) {
            $_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_ORIGINAL_URL'];
        } else if (isset($_SERVER['HTTP_X_REWRITE_URL'])) {
            $_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_REWRITE_URL'];
            if (strpos($_SERVER['REQUEST_URI'], 'server.php') !== false) {
                $_uri = explode('server.php', $_SERVER['REQUEST_URI'], 2);
                $_SERVER['REQUEST_URI'] = $_uri[1];
                unset($_uri);
                $_uri = null;
            }
        } else if (empty($_SERVER['REQUEST_URI'])) {
            if (!isset($_SERVER['PATH_INFO']) && isset($_SERVER['ORIG_PATH_INFO'])) {
                $_SERVER['PATH_INFO'] = $_SERVER['ORIG_PATH_INFO'];
            }
            if (isset($_SERVER['PATH_INFO'])) {
                if ($_SERVER['PATH_INFO'] == $_SERVER['SCRIPT_NAME']) {
                    $_SERVER['REQUEST_URI'] = $_SERVER['PATH_INFO'];
                } else {
                    $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'] . $_SERVER['PATH_INFO'];
                }
            }
            if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
                $_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
            }
        }
    }

    /**
     * debug
     * @param $clazz
     */
    public static function detection($clazz) {
        self::$outController[$clazz] = 0;
        var_dump(self::$outController);

//        file_put_contents(LOG_PATH . 'debug.txt', '执行日期：' . strftime('%Y-%m-%d %H:%M:%S', time())
//                . "\n" . print_r($clazz, true) . "\n", FILE_APPEND | LOCK_EX);
    }

    /**
     * 不使用autoload的类名
     * @var array
     */
    public static $outController = array('PHPExcel');

    public static function autoload($clazz) {
        if (class_exists($clazz, false) || isset(self::$outController[$clazz])) {
            return false;
        }
        $_extensions = '.class';
        if (strpos($clazz, 'Handler\\') !== false) {
            $_extensions = '.handler';
        }
//        self::detection($clazz);

        require_once ROOT_PATH . 'core' . DIRECTORY_SEPARATOR
            . str_replace('\\', DIRECTORY_SEPARATOR, $clazz)
            . $_extensions . '.php';
    }

}
