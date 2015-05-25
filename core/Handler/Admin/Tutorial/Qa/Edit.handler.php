<?php

namespace Handler\Admin\Tutorial\Qa;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;
use Tools\Html;
use Tools\MsgHelper;
use Exception;

/**
 * 修改
 */
class Edit extends AbstractCommon {

    public function processRequest(Array & $context) {
        try {
            $this->db->beginTransaction();
            $this->_pushSetting();

            $_POST['tcq_id'] = intval($_POST['id']);
            $_POST['tutorial_chapter_id'] = intval($_POST['tutorial_chapter_id']);
            $_POST['question'] = trim($_POST['question']);
            $_POST['add_date'] = time();

//            $this->db->debug();
            $_return = $this->db->table('`#@__@tutorial_chapter_qa`')
                ->row(array(
                    '`tutorial_chapter_id`' => '?',
                    '`question`' => '?',
                    '`answer`' => '?',
                    '`release_date`' => '?'
                ))
                ->where('`tcq_id` = ?')
                ->bind($_POST)
                ->update();

            echo(MsgHelper::json($_return ? 'SUCCESS' : ($_return == 0 ? 'NO_CHANGES' : 'DB_ERROR')));
            $this->db->commit();
        } catch (Exception $e) {

            $this->db->rollBack();

            echo(MsgHelper::json('DB_ERROR'));
        }
    }

}
