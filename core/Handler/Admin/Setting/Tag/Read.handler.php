<?php

namespace Handler\Admin\Setting\Tag;

if (!defined('IN_PX'))
    exit;

use Handler\Admin;

/**
 *
 */
class Read extends Admin\AbstractCommon {

    public function processRequest(Array & $context) {
        $this->_pushSetting();

        if (!$_POST['sortName'])
            $_POST['sortName'] = 'total';
        if (!$_POST['sortOrder'])
            $_POST['sortOrder'] = 'DESC';

        if (!$_POST['page'])
            $_POST['page'] = 1;
        if (!$_POST['rp'])
            $_POST['rp'] = 10;
        $_start = (($_POST['page'] - 1) * $_POST['rp']);

        $_where = '0 = 0';
        $_bindParam = array();

        if (isset($_POST['strSearchKeyword']) && $_POST['strSearchKeyword'] != '') {
            $_where .= ' AND (`tags_text` LIKE :strSearchKeyword)';
            $_bindParam[':strSearchKeyword'] = '%' . trim($_POST['strSearchKeyword']) . '%';
        }
        if (isset($_POST['tags_display']) && $_POST['tags_display'] != '') {
            $_where .= ' AND `is_display` = :is_display';
            $_bindParam[':is_display'] = intval($_POST['tags_display']);
        }

        $_table = '`#@__@tags`';
        $_total = $this->db->table($_table)->where($_where)->bind($_bindParam)->count();
        //$this->db->debug();
        $_rs = $this->db->select()
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
                $_idValue = $m->tags_id;
                array_push($_rsp['rows'], array(
                    'id' => $_idValue,
                    'cell' => array(
                        $_idValue,
                        $m->tags_text,
                        $m->total,
                        '<span' . \Tools\Auxi::getDeepColor($m->type_id) . '>'
                        . $this->setting['aryTagsType'][intval($m->type_id)] . '</span>',
                        '<span' . \Tools\Auxi::getDeepColor($m->is_display) . '>'
                        . $this->setting['aryDisplay'][intval($m->is_display)] . '</span>'
                    )
                ));
            }
        }
        echo(\Tools\MsgHelper::json('SUCCESS', '数据返回成功', $_rsp));
    }

}
