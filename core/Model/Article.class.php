<?php

namespace Model;

if (!defined('IN_PX'))
    exit;

use Tools\Log4p as logger;

class Article {

    private function __Model() {}

    private function __Inject($db) {}

    public function findAll($start = 5, $end = null, $typeId = 1) {
        return $this->db->cacheable()->select('`article_id`, `article_title`, `article_img`, `synopsis`, `release_date`')
            ->table('`#@__@article`')->where('`type_id` = ? AND `is_display` = 1')
            ->bind(array($typeId))->limit($start, $end)->order('is_status DESC, release_date')->findAll();
    }

    public function count() {
        return $this->db->table('`#@__@article`')->where('`is_display` = 1')->count();
    }

    public function find($id) {
        $this->db->cacheable()->table('`#@__@article`')
            ->row(array(
                '`view_count`' => '`view_count` + 1'
            ))->where('`article_id` = ?')->bind(array($id))->update();
        return $this->db->select('a.`article_title`, a.`article_img`, a.`seo_title`, a.`seo_description`, a.`seo_keywords`, a.`release_date`, ac.`content`')
            ->table('`#@__@article` a')
            ->inner('`#@__@article_content` ac', 'a.`article_id` = ac.`article_id`')
            ->where('a.`article_id` = ?')->bind(array($id))->find();
    }

}
