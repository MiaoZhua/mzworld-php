<?php

namespace Model;

if (!defined('IN_PX'))
    exit;

use Tools\MsgHelper;
use Tools\Log4p as logger;

class Opus {

    private function __Model() {}

    private function __Inject($db, $session, OpusAttach $opusAttach, OpusTag $opusTag, OpusIssueto $opusIssueto) {}

    public function save(Array $opusPost) {
    	
        try {
            $this->db->beginTransaction();
            $opusPost['user_id'] = $this->session->user['id'];
//			echo $opusPost['user_id'];exit;
//            $_row = array();
            $_edit = false;
            $_time = time();
            $opusPost['release_date'] = $_time;
            if (isset($opusPost['opus_id']) && $opusPost['opus_id'] > 0) {
                if (!$this->db->table('`#@__@opus`')->where('`opus_id` = ? AND `user_id` = ?')
                    ->bind(array(
                        $opusPost['opus_id'], $this->session->user['id']
                    ))->exists()) {
                    return MsgHelper::aryJson('USER_ERROR', '非法操作');
                }
                $_edit = true;
                $_row = array(
                    '`type_id`' => '?',
                    '`title`' => '?',
                    '`thumb`' => '?',
                    '`sb2_src`' => '?',
                    '`sb2_size`' => '?',
                    '`release_date`' => '?',
                    '`tag`' => '?'
                );
                if (!isset($opusPost['sb2_src'])) {
                    unset($_row['`sb2_src`'], $_row['`sb2_size`']);
                }
                if (!isset($opusPost['thumb'])) {
                    unset($_row['`thumb`']);
                }
            } else {
              $opusPost['opus_id'] = $this->db->sequence64('global');
//            $user['title'] = $user['title'];
                $opusPost['add_date'] = $_time;
                //TODO
//                $opusPost['issue_to'] = 0;

                $_row = array(
                    '`opus_id`' => '?',
                    '`user_id`' => '?',
                    '`type_id`' => '?',
                    '`title`' => '?',
                    '`thumb`' => '?',
                    '`sb2_src`' => '?',
                    '`sb2_size`' => '?',
                    '`issue_to`' => '?',
                	'`relativeuid`' => '?',
                    '`tag`' => '?',
                    '`sort`' => '?',
                    '`release_date`' => '?',
                    '`add_date`' => '?'
                );
            }
            $_tag = array();
            if (isset($opusPost['tag']) && !empty($opusPost['tag'])) {
                $_tag = $this->opusTag->save(explode(' ', $opusPost['tag']), $opusPost['opus_id']);
            }
            $opusPost['tag'] = implode(' ', $_tag);
            
            
            //发布到
//        	$_issueto = array();
//            if (isset($opusPost['issueto']) && !empty($opusPost['issueto'])) {
//                $_issueto = $this->opusIssueto->save(explode(',', $opusPost['issueto']), $opusPost['opus_id']);
//            }
            

//            $this->db->debug();
            $opusPost['json'] = array();
            if (isset($opusPost['attach'])) {
                $opusPost['json'] = $this->opusAttach->save($opusPost['attach'],
                    $opusPost['opus_id'], $opusPost['attachId'],$opusPost['detail']);
            }
            $opusPost['json'] = json_encode($opusPost['json']);


            if ($_edit) {
                $this->db->table('`#@__@opus`')
                    ->row($_row)
                    ->where('`opus_id` = ?')
                    ->bind($opusPost)
                    ->update();

                $this->db->table('`#@__@opus_detail`')
                    ->row(array(
                        '`detail`' => '?',
                        '`json`' => '?'
                    ))
                    ->where('`opus_id` = ?')
                    ->bind($opusPost)
                    ->update();
            } else {
                $opusPost['sort'] = $this->db->table('`#@__@opus`')->where('`opus_id` > 0')->count() + 1;
//                $this->db->debug();
                $this->db->table('`#@__@opus`')
                    ->row($_row)
                    ->bind($opusPost)
                    ->save();

//                $this->db->debug();
                $this->db->table('`#@__@opus_detail`')
                    ->row(array(
                        '`opus_id`' => '?',
                        '`detail`' => '?',
                        '`json`' => '?'
                    ))
                    ->bind($opusPost)
                    ->save();

                $this->db->table('`#@__@user`')
                    ->row(array(
                        '`opus_count`' => '(SELECT COUNT(*) FROM `#@__@opus` WHERE `user_id` = ? AND `is_status` = 5)'
                    ))
                    ->where('`user_id` = ?')
                    ->bind(array($this->session->user['id'], $this->session->user['id']))
                    ->update();
            }

            $this->db->commit();
            return MsgHelper::aryJson('SUCCESS');
        } catch (Exception $e) {
            $this->db->rollBack();
            return MsgHelper::aryJson('DB_ERROR', '请检查您填入的数据');
        }
    }

    public function findAll($start = 5, $end = null, $order = 2, $fromUser = true, $topId = 0, $type = 0) {
//        $this->db->debug();
        $_order = array(
            'view_count', 'praise_count', 'add_date'
        );
        $_where = '';
        $_bind = array();
        if ($fromUser !== false) {
            $_where .= '`user_id` = ? AND ';
            if ($fromUser !== true) {
                $_bind[] = $fromUser;
            } else {
                $_bind[] = $this->session->user['id'];
            }
        }
        $_where .= '`type_id` = ? AND `is_status` = 5';
        $_bind[] = $type;
        if ($topId > 0) {
            $_where .= ' AND `opus_id` != ?';
            $_bind[] = $topId;
        }
        return $this->db->select('`opus_id`, `user_id`, `title`, `thumb`, `praise_count`')
            ->table('`#@__@opus`')->where($_where)
            ->bind($_bind)->limit($start, $end)
            ->order($_order[$order])->findAll();
    }

    /**
     * count
     * @param int $type
     * @return mixed
     */
    public function count($type = 0) {
        return $this->db->table('`#@__@opus`')->where('`type_id` = ? AND `is_status` = 5')
            ->bind(array($type))
            ->count();
    }

    public function find($opusId, $edit = false) {
        $this->db->table('`#@__@opus`')
            ->row(array(
                '`view_count`' => '`view_count` + 1'
            ))->where('`opus_id` = ?')->bind(array($opusId))->update();
//        $this->db->debug();
        $_bind = array($opusId);
        $_where = 'o.`opus_id` = ? AND ';
        if ($edit) {
            $_bind[] = $this->session->user['id'];
            $_where .= 'o.`user_id` = ?';
        } else {
            $_where .= 'o.`is_status` = 5';
        }
        return $this->db->select('o.`opus_id`, o.`user_id`, o.`title`, o.`thumb`, o.`sb2_src`, o.`issue_to`, o.`tag`, o.`praise_count`, o.`is_status`, o.`release_date`, u.`nickname`, od.`detail`, od.`json`')
            ->table('`#@__@opus` o')
            ->inner('`#@__@user` u', 'o.`user_id` = u.`user_id`')
            ->left('`#@__@opus_detail` od', 'o.`opus_id` = od.`opus_id`')
            ->where($_where)
            ->bind($_bind)->find();
    }

    public function in(Array $ids) {
        return $this->db->select('`opus_id`, `title`, `thumb`')
            ->table('`#@__@opus`')->where('`opus_id` IN (?) AND `is_status` = 5')
            ->bind(array($ids))
            ->findAll();
    }

    public function remove($opusId) {
        $_rs = $this->db->table('`#@__@opus`')
            ->row(array(
                '`is_status`' => '?'
            ))
            ->where('`opus_id` = ? AND `user_id` = ?')
            ->bind(array(3, $opusId, $this->session->user['id']))
            ->update();

        $this->db->table('`#@__@user`')
            ->row(array(
                '`opus_count`' => '(SELECT COUNT(*) FROM `#@__@opus` WHERE `user_id` = ? AND `is_status` = 5)'
            ))
            ->where('`user_id` = ?')
            ->bind(array($this->session->user['id'], $this->session->user['id']))
            ->update();

        return $_rs;
    }

    public function praise($opusId) {
        try {
            $this->db->beginTransaction();

            if (!$this->praiseExists($opusId)) {

                $this->db->table('`#@__@user_praise`')
                    ->row(array(
                        '`user_id`' => '?',
                        '`opus_id`' => '?',
                        '`add_date`' => '?'
                    ))
                    ->bind(array($this->session->user['id'], $opusId, time()))
                    ->save();

                $this->db->table('`#@__@opus`')
                    ->row(array(
                        '`praise_count`' => '(SELECT COUNT(*) FROM `#@__@user_praise` WHERE `opus_id` = ?)'
                    ))
                    ->where('`opus_id` = ?')
                    ->bind(array($opusId, $opusId))
                    ->update();

                $_user = $this->db->field('`user_id`')->table('`#@__@opus`')
                    ->where('`opus_id` = ?')
                    ->bind(array($opusId))->find();

                $this->db->table('`#@__@user`')
                    ->row(array(
                        '`praise_count`' => '(SELECT SUM(`praise_count`) FROM `#@__@opus` WHERE `user_id` = ?)'
                    ))
                    ->where('`user_id` = ?')
                    ->bind(array($_user, $_user))
                    ->update();

                $this->db->commit();
                return true;
            }
            return false;
        } catch (Exception $e) {

            $this->db->rollBack();
            return false;
        }
        return false;
    }

    public function praiseExists($opusId) {
        return $this->db->table('`#@__@user_praise`')
            ->where('`user_id` = ? AND `opus_id` = ?')
            ->bind(array($this->session->user['id'], $opusId))->exists();
    }

    /**
     * 读取点赞人的昵称及id
     * @param $opusId
     * @return mixed
     */
    public function readPraiseUser($opusId) {
        return $this->db->select('u.`user_id`, u.`nickname`')
            ->table('`#@__@user_praise` up')
            ->inner('`#@__@user` u', 'up.`user_id` = u.`user_id`')
            ->where('`opus_id` = ?')
            ->bind(array($opusId))->findAll();
    }

    public function praiseRemove($opusId) {
        try {
            $this->db->beginTransaction();

            if ($this->db->table('`#@__@user_praise`')
                ->where('`user_id` = ? AND `opus_id` = ?')
                ->bind(array($this->session->user['id'], $opusId))
                ->delete()) {

                $this->db->table('`#@__@opus`')
                    ->row(array(
                        '`praise_count`' => '(SELECT COUNT(*) FROM `#@__@user_praise` WHERE `opus_id` = ?)'
                    ))
                    ->where('`opus_id` = ?')
                    ->bind(array($opusId, $opusId))
                    ->update();

                $_user = $this->db->field('`user_id`')->table('`#@__@opus`')
                    ->where('`opus_id` = ?')
                    ->bind(array($opusId))->find();

                $this->db->table('`#@__@user`')
                    ->row(array(
                        '`praise_count`' => '(SELECT SUM(`praise_count`) FROM `#@__@opus` WHERE `user_id` = ?)'
                    ))
                    ->where('`user_id` = ?')
                    ->bind(array($_user, $_user))
                    ->update();

                $this->db->commit();
                return true;
            }

        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
        return false;
    }

}
