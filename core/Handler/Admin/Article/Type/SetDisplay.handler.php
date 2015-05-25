<?php

namespace Handler\Admin\Article\Type;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;

/**
 * 显示
 */
class SetDisplay extends AbstractCommon {

    public function processRequest(Array & $context) {
        $this->cache->delete(array('aryArticleTypeDataView', 'footerArticleTypeNavigation'));
        echo($this->_setFieldStatus(explode(',', $_POST['id']),
            '`#@__@article_type`', 'is_display', 'type_id'));
    }

}
