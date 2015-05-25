<?php

namespace Handler\Admin\Tutorial\Qa;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;
use Tools\MsgHelper;
use Exception;

/**
 * 添加
 * TODO: 两张卡片，正反两张，素材库能传图片，可自增
 */
class Add extends AbstractCommon {

    public function processRequest(Array & $context) {
        try {
            $this->db->beginTransaction();

            $this->_pushSetting();

            //$this->db->debug();
            $_POST['tutorial_chapter_id'] = intval($_POST['tutorial_chapter_id']);
            $_POST['question'] = trim($_POST['question']);
            $_POST['add_date'] = time();

            $_identity = $this->db->table('`#@__@tutorial_chapter_qa`')
                ->row(array(
                    '`tutorial_chapter_id`' => '?',
                    '`question`' => '?',
                    '`answer`' => '?',
                    '`release_date`' => '?',
                    '`add_date`' => '?'
                ))
                ->bind($_POST)
                ->save();

            echo(MsgHelper::json($_identity ? 'SUCCESS' : 'DB_ERROR'));

            $this->db->commit();
        } catch (Exception $e) {

            $this->db->rollBack();

            echo(MsgHelper::json('DB_ERROR'));
        }

    }

}
