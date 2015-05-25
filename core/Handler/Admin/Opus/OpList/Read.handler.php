<?php

namespace Handler\Admin\Opus\OpList;

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
            $_POST['sortName'] = 'a.opus_id';
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
            $_where .= ' AND (a.`title` LIKE :strSearchKeyword )';
            $_bindParam[':strSearchKeyword'] = '%' . trim($_POST['strSearchKeyword']) . '%';
        }
        if (isset($_POST['type_id']) && $_POST['type_id'] != '') {
            $_where .= ' AND a.`type_id` = :type_id';
            $_bindParam[':type_id'] = $_POST['type_id'];
        }

        $_where .= ' AND a.`is_status` = :is_status';
        $_bindParam[':is_status'] = isset($_POST['opus_is_status']) ? intval($_POST['opus_is_status']) : 5;

        $_table = '`#@__@opus` a LEFT JOIN `#@__@user` u ON a.`user_id` = u.`user_id`';
        $_total = $this->db->table($_table)->where($_where)->bind($_bindParam)->count();
//        $this->db->debug();
        $_rs = $this->db->select('a.*, u.`nickname`')
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
            foreach ($_rs as $m) {
                $_idValue = $m->opus_id;
                array_push($_rsp['rows'], array(
                    'id' => $_idValue,
                    'cell' => array(
                        $_idValue,
                        '<span' . Auxi::getDeepColor(intval($m->type_id)) . '>'
                        . $this->setting['aryOpusType'][intval($m->type_id)] . '</span>',
                        $m->title,
                        Helper::createSmallImg($context['__CDN__'], $context['__ASSETS__'], Auxi::thumb($m->thumb), $m->title, 'user'),
                        $m->sb2_src,
                        $m->view_count,
                        $m->download_count,
                        $m->praise_count,
                        $m->favorites_count,
                        $m->comment_count,
                        '<span' . Auxi::getDeepColor(intval($m->landing_status)) . '>'
                        . $this->setting['aryBool'][intval($m->landing_status)] . '</span>',
                        '<span' . Auxi::getDeepColor(intval($m->gallery_status)) . '>'
                        . $this->setting['aryBool'][intval($m->gallery_status)] . '</span>',
                        '<span' . Auxi::getDeepColor(intval($m->is_status)) . '>'
                        . $this->setting['aryStatus'][intval($m->is_status)] . '</span>',
                        $m->nickname,
                        Auxi::getTime($m->add_date),
                    )
                ));
            }
        }
        echo(MsgHelper::json('SUCCESS', '数据返回成功', $_rsp));
    }

}
