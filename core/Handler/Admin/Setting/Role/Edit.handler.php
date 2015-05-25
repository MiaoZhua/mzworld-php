<?php

namespace Handler\Admin\Setting\Role;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;
use Tools\MsgHelper;

/**
 * 修改
 */
class Edit extends AbstractCommon {

    public function processRequest(Array & $context) {
        $_POST['role_power_value'] = json_encode($_POST['set_power']);
        $_POST['release_date'] = strtotime($_POST['release_date']);
        $_POST['ilanguage'] = intval($_POST['ilanguage']);
        $_POST['role_id'] = $_POST['id'];

        //$this->db->debug();
        $_return = $this->db->table('`#@__@manager_role`')
            ->row(array(
                '`role_name`' => '?',
                '`role_desc`' => '?',
                '`role_power_value`' => '?',
                '`release_date`' => '?',
                '`ilanguage`' => '?'
            ))
            ->where('`role_id` = ?')
            ->bind($_POST)
            ->update();

        echo(MsgHelper::json($_return ? 'SUCCESS' : ($_return == 0 ? 'NO_CHANGES' : 'DB_ERROR')));
    }

}
