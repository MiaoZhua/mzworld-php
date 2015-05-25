<?php

namespace Handler\Admin\Article\Alist;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;

/**
 * 更改
 */
class SetFieldStatus extends AbstractCommon {

    public function processRequest(Array & $context) {
        echo($this->_setFieldStatus(explode(',', $_POST['id']),
            '`#@__@article`', $_POST['field'], 'article_id'));
    }

}
