<?php

namespace Admin\Tutorial;

if (!defined('IN_PX'))
    exit;

use Admin\AbstractCommon;

/**
 * 列表页
 */
class Tutor extends AbstractCommon {

    private function __Controller() {}

//    protected function __Inject($db) {}

    public function tutor() {
        return true;
    }

    public function chapter() {
        return true;
    }


}
