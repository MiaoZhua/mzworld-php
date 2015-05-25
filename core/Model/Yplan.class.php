<?php

namespace Model;

if (!defined('IN_PX'))
    exit;

use Tools\Auxi;
use Tools\MsgHelper;
use Tools\Log4p as logger;

class Yplan {

    private function __Model() {}

    private function __Inject($db) {}

    public function findAll($start = 20, $end = null, $schedule_state = 0) {
        return $this->db->select('`schedule_id`, `schedule_title`, `start_date`, `end_date`')
            ->table('`#@__@schedule`')->where('`schedule_state` = ?')
            ->bind(array($schedule_state))->limit($start, $end)->order('start_date', 'ASC')->findAll();
    }


}