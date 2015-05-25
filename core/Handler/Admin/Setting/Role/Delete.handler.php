<?php

namespace Handler\Admin\Setting\Role;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;
use Tools\Auxi;
use Tools\MsgHelper;

/**
 * 删除
 */
class Delete extends AbstractCommon {

    public function processRequest(Array & $context) {
        $_id = Auxi::databaseNeedId($_POST['id'], 1);
        if ($_id == 1) {
            echo(MsgHelper::json('NEED'));
        } else {
            echo($this->_publicDeleteFieldByPostItem($_id, '`#@__@manager_role`', 'role_id'));

        }
    }

}
