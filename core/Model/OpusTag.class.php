<?php

namespace Model;

if (!defined('IN_PX'))
    exit;

use Tools\Log4p as logger;

/**
 * Opus附表
 * Class OpusTag
 * @package Model
 */
class OpusTag {

    private function __Model() {}

    private function __Inject($db) {}

    /**
     * @param array $tag 标签数组
     * @param $opusId
     * @return array
     */
    public function save(Array $tag, $opusId) {
        $_tag = array();
        $this->db->table('`#@__@opus_tag_list`')->where('`opus_id` = ?')->bind(array($opusId))->delete();
        foreach ($tag as $_t) {
            if (($_tagId = $this->db->field('`tag_id`')
                ->table('`#@__@opus_tag`')->where('`tag_text` = ?')->bind(array($_t))->find())) {
                //更新数量
                $this->db->table('`#@__@opus_tag`')
                    ->row(array(
                        '`total`' => '(SELECT COUNT(*) FROM `#@__@opus_tag_list` WHERE `opus_id` = ?) + 1'
                    ))
                    ->where('`tag_id` = ?')
                    ->bind(array(
                        $opusId, $_tagId
                    ))
                    ->update();

            } else {
                //新增
//                $this->db->debug();
                $_tagId = $this->db->table('`#@__@opus_tag`')
                    ->row(array(
                        '`tag_text`' => '?',
                        '`add_date`' => '?'
                    ))
                    ->bind(array(
                        $_t, time()
                    ))
                    ->save();
            }
            if ($_tagId > 0) {
                $this->db->table('`#@__@opus_tag_list`')
                    ->row(array(
                        '`opus_id`' => '?',
                        '`tag_id`' => '?'
                    ))
                    ->bind(array(
                        $opusId, $_tagId
                    ))
                    ->save();
                $_tag[] = $_t;
            }
        }
        return $_tag;
    }

}
