<?php

namespace Handler\Admin\Setting\Tag;

if (!defined('IN_PX'))
    exit;

use Handler\Admin;

/**
 * 添加
 *
 */
class Add extends Admin\AbstractCommon {

    public function processRequest(Array & $context) {
        $this->_pushSetting();

        //$this->db->debug();
        $_POST['tags_text'] = trim($_POST['tags_text']);

        $_identity = $this->db->table('`#@__@tags`')
                ->row(array(
                    '`tags_text`' => '?'
                ))
                ->bind($_POST)
                ->save();

        echo(\Tools\MsgHelper::json($_identity ? 'SUCCESS' : 'DB_ERROR'));
    }

}
