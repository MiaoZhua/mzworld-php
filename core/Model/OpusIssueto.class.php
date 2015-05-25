<?php

namespace Model;

if (!defined('IN_PX'))
    exit;

use Tools\Log4p as logger;

/**
 * Opus附表
 * Class OpusIssueto
 * @package Model
 */
class OpusIssueto {

    private function __Model() {}

    private function __Inject($db) {}

    /**
     * @param array $tag 标签数组
     * @param $opusId
     * @return array
     */
    public function save(Array $issueto, $opusId) {
        $_issueto = array();
        $this->db->table('`#@__@opus_issueto`')->where('`opus_id` = ?')->bind(array($opusId))->delete();
        foreach ($issueto as $_t) {
                //新增
//          $this->db->debug();
           $_issuetoId = $this->db->table('`#@__@opus_issueto`')
                    ->row(array(
                        '`opus_id`' => '?',
                    	'`issueto`' => '?',
                        '`add_date`' => '?'
                    ))
                    ->bind(array(
                        $opusId, $_t, time()
                    ))
                    ->save();
        }
        return $_issueto;
    }

}
