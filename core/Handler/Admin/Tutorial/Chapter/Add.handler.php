<?php

namespace Handler\Admin\Tutorial\Chapter;

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
            $_POST['tutorial_id'] = intval($_POST['tutorial_id']);
            $_POST['chapter_name'] = trim($_POST['chapter_name']);
            $_POST['master_id'] = $this->session->adminUser['id'];
            $_POST['add_date'] = time();

            if ($_POST['attach_src-attachment']) {
                $_attach = json_decode($_POST['attach_src-attachment'], true);
                $_POST['attach_size'] = $_attach['size'];
            }

            $_identity = $this->db->table('`#@__@tutorial_chapter`')
                ->row(array(
                    '`tutorial_id`' => '?',
                    '`chapter_name`' => '?',
                    '`picture`' => '?',
                    '`video_src`' => '?',
                    '`attach_src`' => '?',
                    '`attach_size`' => '?',
                    '`card_front`' => '?',
                    '`card_back`' => '?',
                    '`opus_example`' => '?',
                    '`master_id`' => '?',
                    '`release_date`' => '?',
                    '`add_date`' => '?'
                ))
                ->bind($_POST)
                ->save();

            $this->db->table('`#@__@tutorial_chapter_info`')
                ->row(array(
                    '`tutorial_chapter_id`' => '?',
                    '`info`' => '?'
                ))
                ->bind(array(
                    $_identity,
                    $_POST['info']
                ))
                ->save();

            $this->db->table('`#@__@tutorial`')
                ->row(array(
                    '`chapter_count`' => '(SELECT COUNT(*) FROM `#@__@tutorial_chapter` WHERE `tutorial_id` = ?)'
                ))
                ->where('`tutorial_id` = ?')
                ->bind(array(
                    $_POST['tutorial_id'],
                    $_POST['tutorial_id']
                ))
                ->update();

            $this->_createImg('picture', false); //不生成水印图
            $this->_createImg('card_front', false);
            $this->_createImg('card_back', false);

            echo(MsgHelper::json($_identity ? 'SUCCESS' : 'DB_ERROR'));

            $this->db->commit();
        } catch (Exception $e) {

            $this->db->rollBack();

            echo(MsgHelper::json('DB_ERROR'));
        }

    }

}
