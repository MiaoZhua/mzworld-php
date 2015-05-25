<?php

namespace Handler\Admin\Article\AnchorText;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;
use Tools\MsgHelper;

/**
 * 读取
 */
class Read extends AbstractCommon {

    public function processRequest(Array & $context) {
        $this->_pushSetting();

        if (!$_POST['sortName'])
            $_POST['sortName'] = 'anchor_text_sort';
        if (!$_POST['sortOrder'])
            $_POST['sortOrder'] = 'ASC';

        if (!$_POST['page'])
            $_POST['page'] = 1;
        if (!$_POST['rp'])
            $_POST['rp'] = 10;
        $_start = (($_POST['page'] - 1) * $_POST['rp']);

        $_where = '0 = 0';
        $_bindParam = array();
        if (isset($_POST['sltLanguage']) && $_POST['sltLanguage'] != '') {
            $_where = ' AND `ilanguage` = :sltLanguage';
            $_bindParam[':sltLanguage'] = $_POST['sltLanguage'];
        }

        if (isset($_POST['strSearchKeyword']) && $_POST['strSearchKeyword'] != '') {
            $_where .= ' AND (`text` LIKE :strSearchKeyword)';
            $_bindParam[':strSearchKeyword'] = '%' . trim($_POST['strSearchKeyword']) . '%';
        }

        $_table = '`#@__@anchor_text`';
        $_total = $this->db->table($_table)->where($_where)->bind($_bindParam)->count();
        //$this->db->debug();
        $_rs = $this->db->select('*')
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
                $_idValue = $m->anchor_text_id;
                array_push($_rsp['rows'], array(
                    'id' => $_idValue,
                    'cell' => array(
                        $_idValue,
                        $m->text,
                        $m->link_url,
                        $this->setting['aryAnchorStatus'][intval($m->is_status)],
                        $m->anchor_text_sort
                    )
                ));
            }
        }
        echo(MsgHelper::json('SUCCESS', '数据返回成功', $_rsp));
    }

}
