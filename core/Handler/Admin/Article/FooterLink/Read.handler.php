<?php

namespace Handler\Admin\Article\FooterLink;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;
use Tools\Auxi;
use Tools\MsgHelper;

/**
 * 读取
 */
class Read extends AbstractCommon {

    public function processRequest(Array & $context) {
        $this->_pushSetting();

        if (!$_POST['sortName'])
            $_POST['sortName'] = 'a.footer_link_id';
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
            $_where = ' AND a.`ilanguage` = :sltLanguage';
            $_bindParam[':sltLanguage'] = $_POST['sltLanguage'];
        }

        if (isset($_POST['strSearchKeyword']) && $_POST['strSearchKeyword'] != '') {
            $_where .= ' AND (a.`keywords` LIKE :strSearchKeyword)';
            $_bindParam[':strSearchKeyword'] = '%' . trim($_POST['strSearchKeyword']) . '%';
        }
        if (isset($_POST['type_id']) && $_POST['type_id'] != '') {
            $_where .= ' AND a.`type_id` = :type_id';
            $_bindParam[':type_id'] = intval($_POST['type_id']);
        }

        $_table = '`#@__@footer_link` a LEFT JOIN `#@__@article_type` b ON a.`type_id` = b.`type_id`';
        $_total = $this->db->table($_table)->where($_where)->bind($_bindParam)->count();
        //$this->db->debug();
        $_rs = $this->db->select('a.*, b.`type_name`')
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
                $_idValue = $m->footer_link_id;
                array_push($_rsp['rows'], array(
                    'id' => $_idValue,
                    'cell' => array(
                        $_idValue,
                        intval($m->type_id) == 0 ? '首页链接' : $m->type_name,
                        $m->keywords,
                        $m->link_url,
                        $this->setting['aryFooterLinkTarget'][intval($m->target)],
                        '<span' . Auxi::getDeepColor($m->is_status) . '>'
                        . $this->setting['aryAnchorStatus'][intval($m->is_status)] . '</span>',
                        $this->setting['aryFooterLinkType'][intval($m->link_type)]
                    )
                ));
            }
        }
        echo(MsgHelper::json('SUCCESS', '数据返回成功', $_rsp));
    }

}
