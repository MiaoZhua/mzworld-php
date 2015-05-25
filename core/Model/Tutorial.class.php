<?php

namespace Model;

if (!defined('IN_PX'))
    exit;

use Tools\Log4p as logger;

class Tutorial {

    private function __Model() {}

    private function __Inject($db) {}

    public function findAll($start = 20, $end = null, $stageType = 0) {
        return $this->db->select('`tutorial_id`, `title`, `cover_src`, `chapter_count`, `synopsis`')
            ->table('`#@__@tutorial`')->where('`stage_type` = ? AND `is_display` = 1')
            ->bind(array($stageType))->limit($start, $end)->order('release_date', 'ASC')->findAll();
    }

    public function top() {
        return $this->db->select('`tutorial_id`, `title`, `cover_src`')
            ->table('`#@__@tutorial`')
            ->order('is_status')->limit(1)->find();
    }

}
