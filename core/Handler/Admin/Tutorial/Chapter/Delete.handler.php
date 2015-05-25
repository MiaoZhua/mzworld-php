<?php

namespace Handler\Admin\Tutorial\Chapter;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;
use Tools\MsgHelper;
use Exception;

/**
 * 删除
 * TODO:删除后更新tutorial chapter数量
 */
class Delete extends AbstractCommon {

    public function processRequest(Array & $context) {
        try {
            $this->db->beginTransaction();

            echo($this->_publicDeleteFieldByPostItem($_POST['id'],
                array('`#@__@tutorial_chapter`', '`#@__@tutorial_chapter_info`'),
                'tutorial_chapter_id', true, array('picture', 'video_src', 'attach_src', 'card_front', 'card_back')));

            $this->db->commit();
        } catch (Exception $e) {

            $this->db->rollBack();
            echo(MsgHelper::json('DB_ERROR'));
        }
    }

}
