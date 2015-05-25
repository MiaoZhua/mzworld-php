<?php

namespace Admin\Tutorial;

if (!defined('IN_PX'))
    exit;

use Admin\AbstractCommon;

/**
 * 内容页
 */
class Content extends AbstractCommon {

    private function __Controller() {}

    protected function __Inject($db) {}

    public function tutorContent() {
        if ($this->_boolCanReadData()) {
            $this->rs = $this->db->select()
                ->table('`#@__@tutorial`')
                ->where('`tutorial_id` = ?')
                ->bind(array($_GET['id']))
                ->find();
        }
        if (!isset($_GET['parentId']))
            $_GET['parentId'] = '';
        if (!isset($_GET['id']))
            $_GET['id'] = '';
        
        return true;
    }

    public function chapterContent() {
        if ($this->_boolCanReadData()) {
//            $this->db->debug();
            $this->rs = $this->db->select('tc.*, tci.`info`')
                ->table('`#@__@tutorial_chapter` tc')
                ->inner('`#@__@tutorial_chapter_info` tci', 'tc.`tutorial_chapter_id` = tci.`tutorial_chapter_id`')
                ->where('tc.`tutorial_chapter_id` = ?')
                ->bind(array($_GET['id']))
                ->find();
        }
        if (!isset($_GET['parentId']))
            $_GET['parentId'] = '';
        if (!isset($_GET['id']))
            $_GET['id'] = '';

        $_tutorialRs = $this->db->select('`tutorial_id`, `title`')
            ->table('`#@__@tutorial`')->where('`is_display` = 1')
            ->order('`release_date`')->findAll();
        $_aryTutorial = array(
            0 => '选择微课单元'
        );
        if (count($_tutorialRs) > 0) {
            foreach ($_tutorialRs as $_mc) {
                $_aryTutorial[$_mc->tutorial_id] = $_mc->title;
            }
        } else {
            $_aryTutorial[0] = '暂无微课单元选择';
        }
        $this->aryTutorial = $_aryTutorial;
        unset($_aryTutorial);
        $_aryTutorial = null;

        return true;
    }

    public function qaContent() {
        if ($this->_boolCanReadData()) {
//            $this->db->debug();
            $this->rs = $this->db->select()
                ->table('`#@__@tutorial_chapter_qa`')
                ->where('`tcq_id` = ?')
                ->bind(array($_GET['id']))
                ->find();
        }
        if (!isset($_GET['parentId']))
            $_GET['parentId'] = '';
        if (!isset($_GET['id']))
            $_GET['id'] = '';

        $_tutorialChapterRs = $this->db->select('`tutorial_chapter_id`, `chapter_name`')
            ->table('`#@__@tutorial_chapter`')->where('`is_display` = 1')
            ->order('`release_date`')->findAll();
        $_aryTutorialChapter = array(
            0 => '选择微课章节'
        );
        if (count($_tutorialChapterRs) > 0) {
            foreach ($_tutorialChapterRs as $_mc) {
                $_aryTutorialChapter[$_mc->tutorial_chapter_id] = $_mc->chapter_name;
            }
        } else {
            $_aryTutorialChapter[0] = '暂无微课单元选择';
        }
        $this->aryTutorialChapter = $_aryTutorialChapter;
        unset($_aryTutorialChapter);
        $_aryTutorialChapter = null;

        return true;
    }

}
