<?php

namespace Handler\Admin\Tutorial\Chapter;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;

/**
 * 修改
 */
class SetFieldValue extends AbstractCommon {

    public function processRequest(Array & $context) {
        echo($this->_setFieldStatus(explode(',', $_POST['id']),
            '`#@__@tutorial_chapter`', $_POST['field'], 'tutorial_chapter_id',
            false, $_POST['fieldValue']));
    }

}
