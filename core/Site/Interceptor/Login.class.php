<?php

namespace Site\Interceptor;

if (!defined('IN_PX'))
    exit;

use Phoenix\AbstractInterceptorAdapter;

class Login extends AbstractInterceptorAdapter {

    private function __Inject($session) {}

    public function preHandle(Array & $context) {
        if (is_null($this->session->user)) {
            return false;
        }

        return true;
    }

}
