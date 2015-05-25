<?php

namespace Handler\Admin\Tutorial\Tutor;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;

/**
 * 修改
 */
class SetFieldValue extends AbstractCommon {

    public function processRequest(Array & $context) {
        echo($this->_setFieldStatus(explode(',', $_POST['id']),
            '`#@__@tutorial`', $_POST['field'], 'tutorial_id',
            false, $_POST['fieldValue']));
    }

}
