<?php

namespace Handler\Admin\Material\Avatar;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;
use Tools\Html;
use Tools\MsgHelper;

/**
 * 修改
 */
class Edit extends AbstractCommon {

    public function processRequest(Array & $context) {
        $this->_pushSetting();

        $_POST['material_avatar_id'] = intval($_POST['id']);
        $_POST['parts'] = intval($_POST['parts']);
        $_POST['level'] = intval($_POST['level']);
        $_POST['title'] = trim($_POST['title']);
        $_POST['master_id'] = $this->session->adminUser['id'];
        $_POST['add_date'] = time();

//        $this->db->debug();
        $_return = $this->db->table('`#@__@material_avatar`')
            ->row(array(
                '`title`' => '?',
                '`parts`' => '?',
                '`level`' => '?',
                '`src_front`' => '?',
                '`src_left`' => '?',
                '`src_right`' => '?',
                '`src_rear`' => '?',
                '`master_id`' => '?'
            ))
            ->where('`material_avatar_id` = ?')
            ->bind($_POST)
            ->update();

        $this->_createImg('src_front', false); //不生成水印图
        $this->_createImg('src_left', false); //不生成水印图
        $this->_createImg('src_right', false); //不生成水印图
        $this->_createImg('src_rear', false); //不生成水印图

        echo(MsgHelper::json($_return ? 'SUCCESS' : ($_return == 0 ? 'NO_CHANGES' : 'DB_ERROR')));
    }

}
