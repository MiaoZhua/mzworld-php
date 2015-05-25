<?php

namespace Handler\Admin\Material\Avatar;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;
use Tools\Html;
use Tools\MsgHelper;

/**
 * 添加
 *
 */
class Add extends AbstractCommon {

    public function processRequest(Array & $context) {
        try {
            $this->db->beginTransaction();
            $this->_pushSetting();

            //$this->db->debug();
            $_POST['parts'] = intval($_POST['parts']);
            $_POST['level'] = intval($_POST['level']);
            $_POST['title'] = trim($_POST['title']);
            $_POST['master_id'] = $this->session->adminUser['id'];
            $_POST['add_date'] = time();
//            $this->db->debug();
            $_POST['material_avatar_id'] = $this->db->sequence64('global');


            $this->db->table('`#@__@material_avatar`')
                ->row(array(
                    '`material_avatar_id`' => '?',
                    '`title`' => '?',
                    '`parts`' => '?',
                    '`level`' => '?',
                    '`src_front`' => '?',
                    '`src_left`' => '?',
                    '`src_right`' => '?',
                    '`src_rear`' => '?',
                    '`master_id`' => '?',
                    '`add_date`' => '?'
                ))
                ->bind($_POST)
                ->save();

            $this->_createImg('src_front', false); //不生成水印图
            $this->_createImg('src_left', false); //不生成水印图
            $this->_createImg('src_right', false); //不生成水印图
            $this->_createImg('src_rear', false); //不生成水印图

            echo(MsgHelper::json($_POST['material_avatar_id'] ? 'SUCCESS' : 'DB_ERROR'));
            $this->db->commit();
        } catch (Exception $e) {

            $this->db->rollBack();

            echo(MsgHelper::json('DB_ERROR'));
        }

    }
}
