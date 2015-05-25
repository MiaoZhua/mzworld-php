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
class OpusAttach {

    private function __Model() {}

    private function __Inject($db) {}

    public function save(Array $attach, $opusId, $attachId,&$opusPost_detail) {
        $this->annexFolder = ROOT_PATH . "uploads" . DIRECTORY_SEPARATOR;
        $_time = time();
        $_opusAttachJson = array();
        $_oldAttachId = array();
        if ($attachId != '') {
            $_oldAttachId = explode(',', $attachId);//原附件
        }

        $_holderAttach = array();//作品修改时依然保留的附件
//          $this->db->debug();
        if (count($attach) > 0) {
            foreach ($attach as $_k => $_oah) {
                $_ah = json_decode($_oah, true);
                if (isset($_ah['opus_attach_id']) && intval($_ah['opus_attach_id']) > 0) {
                    $_holderAttach[] = $_ah['opus_attach_id'];
                    $_opusAttachJson[$_k] = $_ah;
                    continue;
                }
                if (isset($_ah['name'])) {
                    $_opusAttachJson[$_k] = $_ah;
                    $_ah['opus_id'] = $opusId;
                    $_ah['attach_src'] = $_ah['path'] . '/' . $_ah['name'];
                    $_ah['add_date'] = $_time;
                    if (strcmp('file', $_ah['type']) == 0) {
                        $_ah['width'] = 0;
                        $_ah['height'] = 0;
                    }
					
					
					 if(isset($_ah['attach_user_name'])){
                        $_ah['attach_user_name']= $_ah['attach_user_name'] . $_ah['name'];//组合文件名
                        if($_ah['name']!=$_ah['attach_user_name']){
                            //改变detail中的值
                            $opusPost_detail=str_replace($_ah['name'],$_ah['attach_user_name'],$opusPost_detail);
                            //拷贝文件
                            copy($this->annexFolder .  $_ah['path'] . DIRECTORY_SEPARATOR . $_ah['name'], $this->annexFolder .  $_ah['path'] . DIRECTORY_SEPARATOR . $_ah['attach_user_name']);
                            //清除原有文件
                            unlink($this->annexFolder .  $_ah['path'] . DIRECTORY_SEPARATOR . $_ah['name']);
                        }
                        $_ah['name']= $_ah['attach_user_name'];//将用户命名的文件和时间组合在一起，生成文件名
                        $_ah['attach_src']= $_ah['path'] . DIRECTORY_SEPARATOR . $_ah['name'];
                        $_opusAttachJson[$_k] = $_ah;
                    }

//                    $this->db->debug();
                    $_id = $this->db->table('`#@__@opus_attach`')
                        ->row(array(
                            '`opus_id`' => '?',
                            '`type`' => '?',
                            '`attach_src`' => '?',
                            '`width`' => '?',
                            '`height`' => '?',
                            '`size`' => '?',
                            '`add_date`' => '?'
                        ))
                        ->bind($_ah)
                        ->save();

                    if ($_id > 0) {
                        $_opusAttachJson[$_k]['src'] = $_ah['cdn'] . $_ah['path'] . '/' . $_ah['name'];
                        $_opusAttachJson[$_k]['opus_attach_id'] = $_id;

                    } else {
                        usset($_opusAttachJson[$_k]);
                    }
                } else {
                    $_opusAttachJson[$_k] = $_oah;
                }
            }
        }

        if (count($_oldAttachId) > 0) {
            $_diff = array_diff($_oldAttachId, $_holderAttach);
            if (count($_diff) > 0) {
                foreach ($_diff as $_opusAttachId) {
                    $this->db->table('`#@__@opus_attach`')
                        ->where('`opus_attach_id` = ?')
                        ->bind(array($_opusAttachId))
                        ->delete();
                }
            }
        }

        return $_opusAttachJson;
    }

}

