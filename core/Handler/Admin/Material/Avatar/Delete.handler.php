<?php

namespace Handler\Admin\Material\Avatar;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;

/**
 * 删除
 */
class Delete extends AbstractCommon {

    public function processRequest(Array & $context) {
        echo($this->_publicDeleteFieldByPostItem($_POST['id'], '`#@__@material_avatar`', 'material_avatar_id',
            true, array('src_front', 'src_left', 'src_right', 'src_rear'), 'img'));
    }

}
