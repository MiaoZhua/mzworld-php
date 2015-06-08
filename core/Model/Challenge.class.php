<?php

namespace Model;

if (!defined('IN_PX'))
    exit;

use Tools\MsgHelper;
use Tools\Log4p as logger;

class Challenge {

    private function __Model() {}

    private function __Inject($db, $session) {}

    public function find($challengeId) {
            
//        $this->db->debug();
        $_bind = array($challengeId);
//        $_where = 'o.`challenge_id` = ? AND ';
        
//        $_where .= 'o.`is_status` = 5';
        $_where = 'o.`challenge_id` = ? ';
        
        return $this->db->select('o.`challenge_id`, o.`user_id`, u.`nickname`, o.`challenge_name`, o.`challenge_profile`, o.`challenge_description`, o.`pic_1`')
            ->table('gksel_challenge_list o')
            ->left('`#@__@user` u', 'o.`user_id` = u.`user_id`')
            ->where($_where)
            ->bind($_bind)->find();
    }
    //获取召集的描述列表
    public function findalldescription($challengeId) {
        $_bind = array($challengeId);
        $_where = '`challenge_id` = ? ';
        
        return $this->db->select('`title`, `description`')
            ->table('gksel_challenge_description')
            ->where($_where)
            ->bind($_bind)
            ->order('`sort`', 'ASC')
            ->findAll();
    }
    //获取召集的附件列表
    public function findallattach($challengeId) {
        $_bind = array($challengeId);
        $_where = '`challenge_id` = ? ';
        
        return $this->db->select('`name`, `path`, `size`, `houzui`')
            ->table('gksel_challenge_attach')
            ->where($_where)
            ->bind($_bind)
            ->order('`sort`', 'ASC')
            ->findAll();
    }
    
    //获取登录的情况下首页我的召集
    public function findAccountlistchallenge() {
        return $this->db->select('o.`challenge_id`, o.`user_id`, u.`nickname`, o.`challenge_name`, o.`challenge_profile`, o.`challenge_description`, o.`pic_1`')
            ->table('gksel_challenge_list o')
            ->left('`#@__@user` u', 'o.`user_id` = u.`user_id`')
            ->order('o.`challenge_id`', 'DESC')
            ->findAll();
    }
    
    //获取没有登录的情况下首页前4个召集
    public function findunloginIndexlistchallenge() {
        return $this->db->select('o.`challenge_id`, o.`user_id`, u.`nickname`, o.`challenge_name`, o.`challenge_profile`, o.`challenge_description`, o.`pic_1`')
            ->table('gksel_challenge_list o')
            ->left('`#@__@user` u', 'o.`user_id` = u.`user_id`')
            ->order('o.`challenge_id`', 'DESC')
            ->limit(0, 4)
            ->findAll();
    }

    //获取画廊的所有的召集
    public function findGallerylistchallenge() {
        return $this->db->select('o.`challenge_id`, o.`user_id`, u.`nickname`, o.`challenge_name`, o.`challenge_profile`, o.`challenge_description`, o.`pic_1`')
            ->table('gksel_challenge_list o')
            ->left('`#@__@user` u', 'o.`user_id` = u.`user_id`')
            ->order('o.`challenge_id`', 'DESC')
            ->findAll();
    }


}
