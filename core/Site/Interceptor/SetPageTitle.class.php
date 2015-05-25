<?php

namespace Site\Interceptor;

if (!defined('IN_PX'))
    exit;

use Phoenix\AbstractInterceptorAdapter;

/**
 * 拦截赋值page seo
 */
class SetPageTitle extends AbstractInterceptorAdapter {

    private function __Inject($session) {}

    private function __Bundle($seo = 'data/seo.cache.php') {}

    public function preHandle(Array & $context) {
        $context['pageSeoTitle'] = null;
        $context['pageSeoDescription'] = null;
        $context['pageSeoKeywords'] = null;

        $context['loginImg'] = '';
        if (!is_null($this->session->user['id'])) {
            if ($context['__HOMEPAGE__']) {
                header("Location: http://{$_SERVER['HTTP_HOST']}/account");
            }

            $context['avatar'] = $this->session->user['avatar'];
            $context['userId'] = $this->session->user['id'];
            $context['nickname'] = $this->session->user['nickname'];
            $context['userInfo'] = '欢迎您，<span> ' . $context['nickname']
                . '</span><a class="exit" id="logout" href="javascript:;">退出</a>';
            $context['loginImg'] = ' login-img';
        }

        return true;
    }

    public function postHandle(Array & $context) {
        $_key = trim($context['__PHP_SELF__'], '/');
        if (isset($this->seo[$_key])) {
            $_seo = $this->seo[$_key];
            $context['pageSeoTitle'] = $_seo['title'];
            $context['pageSeoDescription'] = $_seo['description'];
            $context['pageSeoKeywords'] = $_seo['keywords'];
        }

        if (!isset($context['pageSeoTitle'])) {
            $context['pageSeoTitle'] = $this->cfg['title'];
        } else if (!$context['__HOMEPAGE__']) {
            $context['pageSeoTitle'] .= ' - ' . $this->cfg['title'];
        }
        if ($context['__HOMEPAGE__'] && !isset($context['pageSeoDescription'])) {
            $context['pageSeoDescription'] = $this->cfg['description'];
        }
        if ($context['__HOMEPAGE__'] && !isset($context['pageSeoKeywords'])) {
            $context['pageSeoKeywords'] = $this->cfg['keywords'];
        }
        if (isset($context['pageSeoDescription']) && strlen($context['pageSeoDescription']) > 0) {
            $context['pageSeoDescription'] = '<meta name="description" content="' . $context['pageSeoDescription'] . '">' . "\n";
        }
        if (isset($context['pageSeoKeywords']) && strlen($context['pageSeoKeywords']) > 0) {
            $context['pageSeoKeywords'] = '<meta name="keywords" content="' . $context['pageSeoKeywords'] . '">' . "\n";
        }
//        $context['tplPath'] = $context['__ROOT__'] . 'templates/' . $context['__PACKAGE__'] . '/';
        return true;
    }

}
