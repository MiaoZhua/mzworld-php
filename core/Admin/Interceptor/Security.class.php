<?php

namespace Admin\Interceptor;

if (!defined('IN_PX'))
    exit;

use Phoenix\AbstractInterceptorAdapter;
use Tools\Log4p as logger;

/**
 * 后台权限
 */
class Security extends AbstractInterceptorAdapter {

    private function __Inject($db, $session) {}

    public function preHandle(Array & $context) {
        $context['currentFolder'] = $context['__CONTROLLER_INDEX__'];
        $context['currentPageName'] = ltrim($context['__CONTROLLER_MAPPING__'], '/');
        $context['currentAction'] = '';

        $context['pageControl'] = false;
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                //case '':
                case 'add':
                case 'edit':
                    $context['pageControl'] = true;
                    break;
            }
        }


        //logger::debug($context['currentFolder']);
        $_isHandler = isset($context['__HANDLER_CLASS_NAME__']);
        if ($_isHandler) {
            $context['currentFolder'] = strtolower($context['__ARY_HANDLER_PATHS__'][1]);
            $context['currentPageName'] = strtolower($context['__ARY_HANDLER_PATHS__'][2]);
            $_ahp = strtolower($context['__ARY_HANDLER_PATHS__'][3]);

            switch ($_ahp) {
                case 'add':
                case 'delete':
                case 'read':
                case 'edit':
                    $context['currentAction'] = ".{$_ahp}";
                    break;
                default: //除以上之外都必须拥有审核权限才能执行
                    $context['currentAction'] = '.approved';
                    break;
            }
        }
        //验证文件夹
        $context['security'] = null;
        if (isset($context['adminMap'][$context['currentFolder']])) {
            $context['security'] = $context['currentFolder'];
        }
        //验证文件
        $context['pageId'] = null;
        if (isset($context['adminMap'][$context['security']]['menu'][$context['currentPageName']])) {
            $context['pageId'] = $context['currentPageName'];
        } else if (!is_null($context['security'])) {
            foreach ($context['adminMap'][$context['security']]['menu'] as $_k => $_v) {
                if (strcasecmp($_k, $context['currentPageName']) == 0) {
                    $context['pageId'] = $_k;
                    break;
                }
            }
        }
        //die(var_dump($context['pageId']));
        if ($this->session->adminUser['id'] != 1 &&
            !is_null($context['security']) &&
            !is_null($context['pageId']) &&
            !in_array($context['security'] . '.' . $context['pageId'] . $context['currentAction'],
                $context['adminPower'], true)) {
            //如果无权限则直接跳到欢迎页
            //如果非handler，因为后台基于js调用环境，故打破封装性
            if (!$_isHandler)
                die("<script>(function(){window.top.location.href='"
                    . $context['__ROOT__'] . $context['__VC__']
                    . "/system/welcome';})()</script>");

            return false;
        }

        return true;
    }

}
