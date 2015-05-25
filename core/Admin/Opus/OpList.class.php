<?php

namespace Admin\Opus;

if (!defined('IN_PX'))
    exit;

use Admin\AbstractCommon;

/**
 * 列表页
 */
class OpList extends AbstractCommon {

    private function __Controller() {}

//    protected function __Inject($db) {}

    public function opList() {
        return true;
    }


}
