<?php

namespace Handler\Admin\Material\Avatar;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;

/**
 * 更改
 */
class SetFieldStatus extends AbstractCommon {

    public function processRequest(Array & $context) {
        echo($this->_setFieldStatus(explode(',', $_POST['id']),
            '`#@__@material_avatar`', $_POST['field'], 'material_avatar_id'));
    }

}
