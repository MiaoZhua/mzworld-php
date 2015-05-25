<?php

namespace Handler\Admin\Setting\User;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;
use Tools\MsgHelper;

/**
 * 修改
 */
class Edit extends AbstractCommon {

    public function processRequest(Array & $context) {
        //$this->db->debug();
        if (intval($_POST['id']) == 1)
            $_POST['role_id'] = 1; //超级管理员角色
        $_POST['role_id'] = intval($_POST['role_id']);
        $_POST['release_date'] = strtotime($_POST['release_date']);
        $_POST['ilanguage'] = intval($_POST['ilanguage']);
        $_POST['user_id'] = $_POST['id'];

        $_return = $this->db->table('`#@__@manager_user`')
            ->row(array(
                '`role_id`' => '?',
                '`user_name`' => '?',
                '`real_name`' => '?',
                '`email`' => '?',
                '`release_date`' => '?',
                '`ilanguage`' => '?'
            ))
            ->where('`user_id` = ?')
            ->bind($_POST)
            ->update();

        if (!empty($_POST['user_pwd'])) {
            $_return += $this->db->table('`#@__@manager_user`')
                ->row(array(
                    '`user_pwd`' => '?'
                ))
                ->where('`user_id` = ?')
                ->bind(array(
                    md5(trim($_POST['user_pwd'])),
                    $_POST['user_id']
                ))
                ->update();
        }

        echo(MsgHelper::json($_return ? 'SUCCESS' : 'DB_ERROR'));
    }

}
