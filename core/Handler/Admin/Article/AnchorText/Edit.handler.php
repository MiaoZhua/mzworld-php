<?php

namespace Handler\Admin\Article\AnchorText;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;
use Tools\MsgHelper;

/**
 * 修改
 */
class Edit extends AbstractCommon {

    public function processRequest(Array & $context) {
        $this->_pushSetting();
        $this->_processingParameters();

        $_POST['text'] = trim($_POST['text']);
        $_POST['is_status'] = intval($_POST['is_status']);
        $_POST['anchor_text_sort'] = intval($_POST['anchor_text_sort']);
        $_POST['anchor_text_id'] = $_POST['id'];

        //$this->db->debug();
        $_return = $this->db->table('`#@__@anchor_text`')
            ->row(array(
                '`text`' => '?',
                '`link_url`' => '?',
                '`is_status`' => '?',
                '`anchor_text_sort`' => '?',
                '`ilanguage`' => '?'
            ))
            ->where('`anchor_text_id` = ?')
            ->bind($_POST)
            ->update();

        echo(MsgHelper::json($_return ? 'SUCCESS' : ($_return == 0 ? 'NO_CHANGES' : 'DB_ERROR')));
    }

}
