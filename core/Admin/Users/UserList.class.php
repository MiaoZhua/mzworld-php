<?php

namespace Admin\Users;

if (!defined('IN_PX'))
    exit;

use Admin\AbstractCommon;

/**
 * 列表页
 */
class UserList extends AbstractCommon {

    private function __Controller() {}

//    protected function __Inject($db) {}

    public function userList() {
        return true;
    }


}
