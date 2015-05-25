<?php

namespace Handler\Admin\Users\UserList;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;
use Admin\Helper;
use Tools\Auxi;
use Tools\MsgHelper;

/**
 * 读取
 */
class Read extends AbstractCommon {

    public function processRequest(Array & $context) {
        $this->_pushSetting();

        if (!$_POST['sortName'])
            $_POST['sortName'] = 'a.user_id';
        if (!$_POST['sortOrder'])
            $_POST['sortOrder'] = 'ASC';

        if (!$_POST['page'])
            $_POST['page'] = 1;
        if (!$_POST['rp'])
            $_POST['rp'] = 10;
        $_start = (($_POST['page'] - 1) * $_POST['rp']);

        $_where = '0 = 0';
        $_bindParam = array();

        if (isset($_POST['strSearchKeyword']) && $_POST['strSearchKeyword'] != '') {
            $_where .= ' AND (a.`nickname` LIKE :strSearchKeyword )';
            $_bindParam[':strSearchKeyword'] = '%' . trim($_POST['strSearchKeyword']) . '%';
        }

        $_where .= ' AND a.`is_status` = :is_status';
        $_bindParam[':is_status'] = isset($_POST['user_is_status']) ? intval($_POST['user_is_status']) : 0;

        $_table = '`#@__@user` a';
        $_total = $this->db->table($_table)->where($_where)->bind($_bindParam)->count();
//        $this->db->debug();
        $_rs = $this->db->select('a.*')
            ->table($_table)
            ->where($_where)
            ->order($_POST['sortName'], $_POST['sortOrder'])
            ->limit($_start, $_POST['rp'])
            ->bind($_bindParam)
            ->findAll();

        $_rsp = array(
            'totalResults' => $_total,
            'rows' => array()
        );
        if ($_total) {
            $_time = time();
            foreach ($_rs as $m) {
                $_idValue = $m->user_id;
                array_push($_rsp['rows'], array(
                    'id' => $_idValue,
                    'cell' => array(
                        $_idValue,
                        $m->nickname,
//                        '<span' . Auxi::getDeepColor(intval($m->role_id)) . '>'
//                        . $this->setting['aryRole'][intval($m->role_id)] . '</span>',
                        $m->level,
                        $m->name,
                        $m->email,
                        Auxi::age($m->birthday, $_time),
//                        Helper::createSmallImg($context['__CDN__'], $context['__ASSETS__'], Auxi::thumb($m->thumb), $m->title, 'user'),
                        '<span' . Auxi::getDeepColor(intval($m->sex)) . '>'
                        . $this->setting['arySex'][intval($m->sex)] . '</span>',
                        $m->school_id,
                        '<span' . Auxi::getDeepColor(intval($m->identity_type)) . '>'
                        . $this->setting['aryIdentity'][intval($m->identity_type)] . '</span>',
                        $m->favorite_count,
                        $m->praise_count,
                        '<span' . Auxi::getDeepColor(intval($m->is_status)) . '>'
                        . $this->setting['aryStatus'][intval($m->is_status)] . '</span>',
                        Auxi::getTime($m->add_date),
                    )
                ));
            }
        }
        echo(MsgHelper::json('SUCCESS', '数据返回成功', $_rsp));
    }

}
