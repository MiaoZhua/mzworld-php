<?php

namespace Handler\Admin\Article\Type;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;
use Tools\MsgHelper;
use Exception;

/**
 * 删除
 */
class Delete extends AbstractCommon {

    public function processRequest(Array & $context) {
        try {
            $this->db->beginTransaction();

            $this->cache->delete(array('aryArticleTypeDataView', 'footerArticleTypeNavigation'));
            echo($this->_publicDeleteFieldByPostItem($_POST['id'],
                array('`#@__@article_type`', '`#@__@article_type_content`'),
                'type_id', true, 'type_img', 'img'));

            $this->db->commit();
        } catch (Exception $e) {

            $this->db->rollBack();
            echo(MsgHelper::json('DB_ERROR'));
        }
    }

}
