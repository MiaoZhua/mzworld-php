<?php

namespace Admin\Interceptor;

if (!defined('IN_PX'))
    exit;

use Phoenix\AbstractInterceptorAdapter;
use Tools\Log4p as logger;

/**
 * 后台登录拦截器
 */
class Login extends AbstractInterceptorAdapter {

    private function __Bundle($adminMap = 'data/adminMap.cache.php') {}

    private function __Inject($db, $session) {}

    public function preHandle(Array & $context) {
//        logger::debug($this->session->adminUser);
        if (!is_null($this->session->adminUser)) {//后台用户
            $context['adminMap'] = & $this->adminMap;

            //$this->db->debug();
            $context['adminPower'] = json_decode($this->db->field('b.`role_power_value`')
                ->table('`#@__@manager_user` a, `#@__@manager_role` b')
                ->where('a.`user_id` = ? AND a.`role_id` = b.`role_id`')
                ->bind(array($this->session->adminUser['id']))
                ->find());
            return true;
        } else {
            //因为后台基于js调用环境，故打破封装性
            die('<script>(function(){window.top.location.href=\''
                . $context['__ROOT__'] . $context['__VC__']
                . '/system/login?url=\' + encodeURIComponent(window.top.location.href);})()</script>');
            return false;
        }
    }

}
