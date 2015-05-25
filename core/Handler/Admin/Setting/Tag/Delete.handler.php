<?php

namespace Handler\Admin\Setting\Tag;

if (!defined('IN_PX'))
    exit;

use Handler\Admin;

/**
 * 删除
 */
class Delete extends Admin\AbstractCommon {

    public function processRequest(Array & $context) {
        echo($this->_publicDeleteFieldByPostItem($_POST['id'], '`#@__@tags`', '`tags_id`'));
    }

}
