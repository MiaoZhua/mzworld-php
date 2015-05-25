<?php

namespace Handler\Admin\Setting\Role;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;
use Tools\MsgHelper;

/**
 * 添加
 *
 */
class Add extends AbstractCommon {

    public function processRequest(Array & $context) {

        $_POST['role_power_value'] = json_encode($_POST['set_power']);
        $_POST['master_id'] = $this->session->adminUser['id'];
        $_POST['add_date'] = time();
        $_POST['release_date'] = time();
        $_POST['ilanguage'] = intval($_POST['ilanguage']);

        //$this->db->debug();
        $_return = $this->db->table('`#@__@manager_role`')
            ->row(array(
                '`role_name`' => '?',
                '`role_desc`' => '?',
                '`role_power_value`' => '?',
                '`master_id`' => '?',
                '`add_date`' => '?',
                '`release_date`' => '?',
                '`ilanguage`' => '?'
            ))
            ->bind($_POST)
            ->save();

        echo(MsgHelper::json($_return ? 'SUCCESS' : 'DB_ERROR'));
    }

}
