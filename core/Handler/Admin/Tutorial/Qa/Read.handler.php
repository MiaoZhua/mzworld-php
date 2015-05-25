<?php

namespace Handler\Admin\Tutorial\Qa;

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
            $_POST['sortName'] = 'a.tcq_id';
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
            $_where .= ' AND (a.`question` LIKE :strSearchKeyword)';
            $_bindParam[':strSearchKeyword'] = '%' . trim($_POST['strSearchKeyword']) . '%';
        }

        $_table = '`#@__@tutorial_chapter_qa` a, `#@__@tutorial_chapter` tc';
        $_where .= ' AND a.`tutorial_chapter_id` = tc.`tutorial_chapter_id`';

        $_total = $this->db->table($_table)->where($_where)->bind($_bindParam)->count();
        //$this->db->debug();
        $_rs = $this->db->select('a.*, tc.`chapter_name`')
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
                $_idValue = $m->tcq_id;
                array_push($_rsp['rows'], array(
                    'id' => $_idValue,
                    'cell' => array(
                        $_idValue,
                        $m->chapter_name,
                        $m->question,
                        $m->answer,
                        Auxi::getTime($m->release_date),
                    )
                ));
            }
        }
        echo(MsgHelper::json('SUCCESS', '数据返回成功', $_rsp));
    }

}
