<?php

namespace Model;

if (!defined('IN_PX'))
    exit;

use Tools\Log4p as logger;

class TutorialChapter {

    private function __Model() {}

    private function __Inject($db, $session) {}

    public function findAll($tutorialId = 0) {
        return $this->db->select('`tutorial_chapter_id`, `chapter_name`, `picture`, `video_src`')
            ->table('`#@__@tutorial_chapter`')->where('`tutorial_id` = ? AND `is_display` = 1')
            ->bind(array($tutorialId))->order('`release_date`', 'ASC')->findAll();
    }

    public function studyHistory($tutorialId, $tutorialChapterId) {
        if (!$this->db->table('`#@__@tutorial_study_history`')
            ->where('`user_id` = ? AND `tutorial_id` = ? AND `tutorial_chapter_id` = ?')
            ->bind(array($this->session->user['id'], $tutorialId, $tutorialChapterId))->exists()) {
            //$this->db->debug();
            try {
                $this->db->beginTransaction();
                $this->db->table('`#@__@tutorial_study_history`')
                    ->row(array(
					'`tsh_id`'=>'?',
                        '`user_id`' => '?',
                        '`tutorial_id`' => '?',
                        '`tutorial_chapter_id`' => '?',
                        '`add_date`' => '?'
                    ))
                    ->bind(array('',$this->session->user['id'], $tutorialId, $tutorialChapterId, time()))
                    ->save();
                $this->db->commit();
                return 'SUCCESS';
            } catch (Exception $e) {
                $this->db->rollBack();
                return 'DB_ERROR';
            }
        }
        return "IS_EXISTS";
    }

    public function top() {
        return $this->db->select('`tutorial_chapter_id`, `chapter_name`, `picture`')
            ->table('`#@__@tutorial_chapter`')
            ->order('is_status')->limit(1)->find();
    }

    public function find($chapterId) {
        $this->db->table('`#@__@tutorial_chapter`')
            ->row(array(
                '`view_count`' => '`view_count` + 1'
            ))
            ->where('`tutorial_chapter_id` = ?')
            ->bind(array($chapterId))->update();

        $_rs = $this->db->select('tc.`tutorial_id`, tc.`chapter_name`, tc.`picture`, tc.`video_src`, tc.`attach_src`, tc.`attach_size`, tc.`card_front`, tc.`card_back`, tc.`opus_example`, tc.`release_date`, tci.`info`')
            ->table('`#@__@tutorial_chapter` tc')
            ->inner('`#@__@tutorial_chapter_info` tci', 'tc.`tutorial_chapter_id` = tci.`tutorial_chapter_id`')
            ->where('tc.`tutorial_chapter_id` = ? AND tc.`is_display` = 1')
            ->bind(array($chapterId))->find();
        return $_rs;
    }
 public function save_study_history($chapterId){
        $_rs = $this->db->select('tc.`tutorial_id`')
            ->table('`#@__@tutorial_chapter` tc')
            ->where('tc.`tutorial_chapter_id` = ? AND tc.`is_display` = 1')
            ->bind(array($chapterId))->find();
        return $this->studyHistory($_rs->tutorial_id, $chapterId);

    }
    public function findQA($chapterId) {
        return $this->db->select('`question`, `answer`')
            ->table('`#@__@tutorial_chapter_qa`')->where('`tutorial_chapter_id` = ?')
            ->bind(array($chapterId))->limit(20)->findAll();
    }

    private function _prevNext($tutorialId, $date, $prevOrNext) {
//        $this->db->debug();
        $_sort = $prevOrNext == '<' ? 'DESC' : 'ASC';
        return $this->db->cacheable()->field('`tutorial_chapter_id`')
            ->table('`#@__@tutorial_chapter`')
            ->where('`tutorial_id` = ? AND `release_date` ' . $prevOrNext . ' ? AND `is_display` = 1')
            ->bind(array($tutorialId, $date))
            ->order('release_date', $_sort)
            ->find();
    }

    public function prev($tutorialId, $date) {
        return $this->_prevNext($tutorialId, $date, '<');
    }

    public function next($tutorialId, $date) {
        return $this->_prevNext($tutorialId, $date, '>');
    }

}
