<?php

namespace Handler\Admin\Tutorial\Chapter;

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

            $_POST['tutorial_chapter_id'] = intval($_POST['id']);
            $_POST['tutorial_id'] = intval($_POST['tutorial_id']);
            $_POST['chapter_name'] = trim($_POST['chapter_name']);
            $_POST['master_id'] = $this->session->adminUser['id'];
            $_POST['add_date'] = time();

            $_POST['attach_size'] = 0;
            if ($_POST['attach_src-attachment'] != '') {
                $_attach = json_decode($_POST['attach_src-attachment'], true);
                $_POST['attach_size'] = $_attach['size'];
            }

//            $this->db->debug();
            $_return = $this->db->table('`#@__@tutorial_chapter`')
                ->row(array(
                    '`tutorial_id`' => '?',
                    '`chapter_name`' => '?',
                    '`picture`' => '?',
                    '`video_src`' => '?',
                    '`attach_src`' => '?',
                    '`card_front`' => '?',
                    '`card_back`' => '?',
                    '`attach_size`' => '?',
                    '`opus_example`' => '?',
                    '`master_id`' => '?',
                    '`release_date`' => '?'
                ))
                ->where('`tutorial_chapter_id` = ?')
                ->bind($_POST)
                ->update();

            $_return += $this->db->table('`#@__@tutorial_chapter_info`')
                ->row(array(
                    '`info`' => '?'
                ))
                ->where('`tutorial_chapter_id` = ?')
                ->bind($_POST)
                ->update();

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

            if (isset($_POST['picture'])) {
                $this->_createImg('picture', false); //不生成水印图
                $this->_createImg('card_front', false);
                $this->_createImg('card_back', false);
            }

            echo(MsgHelper::json($_return ? 'SUCCESS' : ($_return == 0 ? 'NO_CHANGES' : 'DB_ERROR')));
            $this->db->commit();
        } catch (Exception $e) {

            $this->db->rollBack();

            echo(MsgHelper::json('DB_ERROR'));
        }
    }

}
