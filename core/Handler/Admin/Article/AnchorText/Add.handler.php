<?php

namespace Handler\Admin\Article\AnchorText;

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
        $this->_pushSetting();
        $this->_processingParameters();

        $_POST['text'] = trim($_POST['text']);
        $_POST['is_status'] = intval($_POST['is_status']);

        $_identity = $this->db->table('`#@__@anchor_text`')
            ->row(array(
                '`text`' => '?',
                '`link_url`' => '?',
                '`is_status`' => '?',
                '`ilanguage`' => '?'
            ))
            ->bind($_POST)
            ->save();

        $this->db->table('`#@__@anchor_text`')
            ->row(array(
                '`anchor_text_sort`' => '?'
            ))
            ->where('`anchor_text_id` = ?')
            ->bind(array(
                $_identity,
                $_identity
            ))
            ->update();

        echo(MsgHelper::json($_identity ? 'SUCCESS' : 'DB_ERROR'));
    }

}
