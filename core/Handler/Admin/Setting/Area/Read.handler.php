<?php

namespace Handler\Admin\Setting\Area;

if (!defined('IN_PX'))
    exit;

use Handler\Admin;

/**
 * 列表
 */
class Read extends Admin\AbstractCommon {

    public function processRequest(Array & $context) {
        $this->_pushSetting();

        if (!$_POST['sortName'])
            $_POST['sortName'] = 'a.id_tree';
        if (!$_POST['sortOrder'])
            $_POST['sortOrder'] = 'ASC';

        if (!$_POST['page'])
            $_POST['page'] = 1;
        if (!$_POST['rp'])
            $_POST['rp'] = 10;
        $_start = ($_POST['page'] - 1) * $_POST['rp'];

        $_where = '0 = 0';
        $_bindParam = array();

        if (isset($_POST['sltDateA']) && $_POST['sltDateA'] && $_POST['sltDateB']) {
            $_where .= ' AND (a.`add_date` BETWEEN :sltDateA AND :sltDateB)';
            $_bindParam[':sltDateA'] = $_POST['sltDateA'];
            $_bindParam[':sltDateB'] = $_POST['sltDateB'];
        }
        if (isset($_POST['strSearchKeyword']) && $_POST['strSearchKeyword'] != '') {
            $_where .= ' AND (a.`area_name` LIKE :strSearchKeyword)';
            $_bindParam[':strSearchKeyword'] = '%' . trim($_POST['strSearchKeyword']) . '%';
        }
        //logger::debug($this->setting['aryBool']);

        $_table = '`#@__@area` a INNER JOIN `#@__@manager_user` b ON a.`master_id` = b.`user_id`';
        //$_where .= '';
        $_total = $this->db->table($_table)->where($_where)->bind($_bindParam)->count();
//        $this->db->debug();
        $_rs = $this->db->select('a.*, b.`user_name`')
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
                $_idValue = $m->area_id;
                array_push($_rsp['rows'], array(
                    'id' => $_idValue,
                    'cell' => array(
                        $_idValue,
                        '<span' . \Tools\Auxi::getDeepColor($m->level) . '>' . $m->level . '</span>',
                        \Admin\Helper::getTreeIMG($m->level, $m->area_name, $context['__ASSETS__']),
                        ($m->level == 1 ? $this->setting['aryAreaType'][$m->area_type_id] : '-'),
                        ($m->level == 1 ? $m->first_letter : '-'),
                        $m->letter_index,
                        '<span' . \Tools\Auxi::getDeepColor($m->is_display)
                        . '>' . $this->setting['aryBool'][intval($m->is_display)] . '</span>',
                        $m->user_name,
                        \Tools\Auxi::getTime($m->add_date)
                    )
                ));
            }
        }
        echo(\Tools\MsgHelper::json('SUCCESS', '数据返回成功', $_rsp));
    }

}
