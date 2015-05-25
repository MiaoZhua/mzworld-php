<?php

namespace Handler\Admin\Article\AnchorText;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;

/**
 * 删除
 */
class Delete extends AbstractCommon {

    public function processRequest(Array & $context) {
        echo($this->_publicDeleteFieldByPostItem($_POST['id'], '`#@__@anchor_text`', 'anchor_text_id'));
    }

}
