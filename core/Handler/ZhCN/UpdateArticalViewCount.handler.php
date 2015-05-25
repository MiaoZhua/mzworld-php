<?php

namespace Handler\ZhCN;

if (!defined('IN_PX'))
    exit;

use Phoenix\IHttpHandler;

/**
 * 统计文章view_count
 */
class UpdateArticalViewCount implements IHttpHandler {

    private function __Handler() {}

    private function __Inject($db) {}

    public function processRequest(Array & $context) {
        //$this->db->debug();
        $this->db->nonCacheable()->table('`#@__@article`')->row(array(
            'view_count' => 'view_count + 1'
        ))->where('article_id = ?')->bind(array(
            $_POST['id']
        ))->update();
    }

}
