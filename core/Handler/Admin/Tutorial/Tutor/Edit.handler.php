<?php

namespace Handler\Admin\Tutorial\Tutor;

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

        $_POST['tutorial_id'] = intval($_POST['id']);
        $_POST['stage_type'] = intval($_POST['stage_type']);
        $_POST['title'] = trim($_POST['title']);
        $_POST['synopsis'] = Html::getTextToHtml($_POST['synopsis'], 200);
        $_POST['master_id'] = $this->session->adminUser['id'];

//        $this->db->debug();
        $_return = $this->db->table('`#@__@tutorial`')
            ->row(array(
                '`stage_type`' => '?',
                '`title`' => '?',
                '`cover_src`' => '?',
                '`synopsis`' => '?',
                '`master_id`' => '?',
                '`release_date`' => '?'
            ))
            ->where('`tutorial_id` = ?')
            ->bind($_POST)
            ->update();

        $this->_createImg('cover_src', false); //不生成水印图

        echo(MsgHelper::json($_return ? 'SUCCESS' : ($_return == 0 ? 'NO_CHANGES' : 'DB_ERROR')));
    }

}
