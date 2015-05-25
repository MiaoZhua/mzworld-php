<?php

namespace Admin\System;

if (!defined('IN_PX'))
    exit;

use Admin\AbstractCommon;

/**
 * 统计
 */
class Statistics extends AbstractCommon {

    private function __Controller() {}

    //private function __RequestMapping($value = '/system') {}
    protected function __Inject($db, $session) {}

    //public function welcome($__RequestMapping = '/welcome') {
    public function welcome() {
        //die(var_dump($this->session->adminUser['id']));
        return true;
    }

    public function statistics() {
        return true;
    }

}
