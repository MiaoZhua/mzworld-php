<?php

namespace Handler\Admin\Tutorial\Tutor;

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
        $this->_pushSetting();

        //$this->db->debug();
        $_POST['stage_type'] = intval($_POST['stage_type']);
        $_POST['title'] = trim($_POST['title']);
        $_POST['synopsis'] = Html::getTextToHtml($_POST['synopsis'], 200);
        $_POST['master_id'] = $this->session->adminUser['id'];
        $_POST['add_date'] = time();


        $_identity = $this->db->table('`#@__@tutorial`')
            ->row(array(
                '`stage_type`' => '?',
                '`title`' => '?',
                '`cover_src`' => '?',
                '`synopsis`' => '?',
                '`master_id`' => '?',
                '`release_date`' => '?',
                '`add_date`' => '?'
            ))
            ->bind($_POST)
            ->save();

        $this->_createImg('cover_src', false); //不生成水印图

        echo(MsgHelper::json($_identity ? 'SUCCESS' : 'DB_ERROR'));
    }

}
