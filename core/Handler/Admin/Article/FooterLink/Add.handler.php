<?php

namespace Handler\Admin\Article\FooterLink;

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

        //$this->db->debug();
        $_POST['type_id'] = intval($_POST['type_id']);
        $_POST['keywords'] = trim($_POST['keywords']);
        $_POST['target'] = intval($_POST['target']);
        $_POST['is_status'] = intval($_POST['is_status']);
        $_POST['link_type'] = intval($_POST['link_type']);

        $_identity = $this->db->table('`#@__@footer_link`')
            ->row(array(
                '`type_id`' => '?',
                '`keywords`' => '?',
                '`target`' => '?',
                '`link_url`' => '?',
                '`is_status`' => '?',
                '`link_type`' => '?',
                '`ilanguage`' => '?'
            ))
            ->bind($_POST)
            ->save();

        echo(MsgHelper::json($_identity ? 'SUCCESS' : 'DB_ERROR'));
    }

}
