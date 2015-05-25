<?php

namespace Handler\Admin\Opus\OpList;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;

/**
 * 修改
 */
class SetFieldValue extends AbstractCommon {

    public function processRequest(Array & $context) {
        echo($this->_setFieldStatus(explode(',', $_POST['id']),
            '`#@__@opus`', $_POST['field'], 'opus_id',
            false, $_POST['fieldValue']));
    }

}
