<?php

namespace Handler\Admin\Setting\Tag;

if (!defined('IN_PX'))
    exit;

use Handler\Admin;

/**
 * 修改
 */
class SetDisplay extends Admin\AbstractCommon {

    public function processRequest(Array & $context) {
        echo($this->_setFieldStatus(explode(',', $_POST['id']),
                '`#@__@tags`', '`is_display`', '`tags_id`'));
    }

}
