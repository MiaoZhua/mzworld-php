<?php

namespace Model;

if (!defined('IN_PX'))
    exit;

use Service\UPFile;
use Tools\Log4p as logger;

/**
 * Opus附表
 * Class OpusAttach
 * @package Model
 */
class MaterialAvatar {

    private function __Model() {}

    private function __Inject($db) {}

    public function findAll($parts = null) {
//        $this->db->debug();
        return $this->db->select('`material_avatar_id`, `parts`, `src_front`, `src_left`, `src_right`, `src_rear`')
            ->table('`#@__@material_avatar`')
//            ->where('`parts` = ? AND `is_display` = 1')
//            ->bind(array($parts))
            ->where('`is_display` = 1')
            ->order('`add_date`', 'ASC')->findAll();
    }

    public function find($materialAvatarId) {
//        $this->db->debug();
        return $this->db->select('`material_avatar_id`, `parts`, `src_front`, `src_left`, `src_right`, `src_rear`')
            ->table('`#@__@material_avatar`')
            ->where('`material_avatar_id` = ? AND `is_display` = 1')
            ->bind(array($materialAvatarId))->find();
    }

}
