<?php

namespace Handler\Admin\Article\FooterLink;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;

/**
 * 修改
 */
class SetDisplay extends AbstractCommon {

    public function processRequest(Array & $context) {
        echo($this->_setFieldStatus(explode(',', $_POST['id']),
            '`#@__@footer_link`', 'is_status', 'footer_link_id'));
    }

}
