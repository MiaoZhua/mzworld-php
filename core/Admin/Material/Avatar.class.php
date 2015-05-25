<?php

namespace Admin\Material;

if (!defined('IN_PX'))
    exit;

use Admin\AbstractCommon;

/**
 * 列表页
 */
class Avatar extends AbstractCommon {

    private function __Controller() {}

//    protected function __Inject($db) {}

    public function avatar() {
        return true;
    }



}
