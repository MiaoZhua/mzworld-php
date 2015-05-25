<?php

namespace Model;

if (!defined('IN_PX'))
    exit;

use Tools\Log4p as logger;

class TutorialStudyHistory {

    private function __Model() {}

    private function __Inject($db, $session) {}

    public function findAll2Array($tutorialId) {
        $_tmp = array();
        if (!is_null($this->session->user)) {
            $_rs = $this->db->select('`tutorial_chapter_id`')
                ->table('`#@__@tutorial_study_history`')
                ->where('`user_id` = ? AND `tutorial_id` = ?')
                ->bind(array($this->session->user['id'], $tutorialId))->findAll();
            if (count($_rs) > 0) {
                foreach ($_rs as $m) {
                    $_tmp[] = $m->tutorial_chapter_id;
                }
            }
        }
        return $_tmp;
    }

    public function findOne() {
//        $this->db->debug();
        return $this->db->select('t.`tutorial_id`, t.`title`, t.`cover_src`')
            ->table('`#@__@tutorial` t')
            ->inner('`#@__@tutorial_study_history` tsh', 't.`tutorial_id` = tsh.`tutorial_id`')
            ->where('`user_id` = ?')
            ->bind(array($this->session->user['id']))->order('tsh.add_date')->limit(1)->find();
    }

}
