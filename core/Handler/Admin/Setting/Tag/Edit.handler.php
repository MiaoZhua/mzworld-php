<?php

namespace Handler\Admin\Setting\Tag;

if (!defined('IN_PX'))
    exit;

use Handler\Admin;

/**
 * 修改
 */
class Edit extends Admin\AbstractCommon {

    public function processRequest(Array & $context) {
        $this->_pushSetting();

        $_POST['tags_id'] = trim($_POST['id']);
        $_POST['tags_text'] = trim($_POST['tags_text']);
        //$this->db->debug();
        $_return = $this->db->table('`#@__@tags`')
                ->row(array(
                    '`tags_text`' => '?'
                ))
                ->where('`tags_id` = ?')
                ->bind($_POST)
                ->update();

        echo(\Tools\MsgHelper::json($_return ? 'SUCCESS' : ($_return == 0 ? 'NO_CHANGES' : 'DB_ERROR')));
    }

}
