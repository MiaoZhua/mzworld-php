<?php

namespace Handler\Admin\Article\Alist;

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
            $_POST['sortName'] = 'a.article_id';
        if (!$_POST['sortOrder'])
            $_POST['sortOrder'] = 'DESC';

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

        if (isset($_POST['sltDateA']) && $_POST['sltDateA'] && $_POST['sltDateB']) {
            $_where .= ' AND (a.`release_date` BETWEEN :sltDateA AND :sltDateB)';
            $_bindParam[':sltDateA'] = $_POST['sltDateA'];
            $_bindParam[':sltDateB'] = $_POST['sltDateB'];
        }
        if (isset($_POST['strSearchKeyword']) && $_POST['strSearchKeyword'] != '') {
            $_where .= ' AND (a.`article_title` LIKE :strSearchKeyword)';
            $_bindParam[':strSearchKeyword'] = '%' . trim($_POST['strSearchKeyword']) . '%';
        }
        if (isset($_POST['type_id']) && intval($_POST['type_id']) != 0) {
            $_where .= ' AND a.`type_id` = :type_id';
            $_bindParam[':type_id'] = $_POST['type_id'];
        }

        $_where .= ' AND a.`is_display` = :is_display AND b.`is_part` = :is_part';
        $_bindParam[':is_display'] = isset($_POST['is_display']) ? intval($_POST['is_display']) : 0;
        $_bindParam[':is_part'] = isset($_POST['is_part']) ? intval($_POST['is_part']) : 0;

        $_table = '`#@__@article` a, `#@__@article_type` b, `#@__@article_type` c';
        $_where .= ' AND a.`type_id` = b.`type_id` AND b.`root_id` = c.`type_id`';
        $_total = $this->db->table($_table)->where($_where)->bind($_bindParam)->count();
        //$this->db->debug();
        $_rs = $this->db->select('a.*, b.`type_name`')
            ->table($_table)
            ->where($_where)
            ->order('a.is_status DESC, ' . $_POST['sortName'], $_POST['sortOrder'])
            ->limit($_start, $_POST['rp'])
            ->bind($_bindParam)
            ->findAll();

        $_rsp = array(
            'totalResults' => $_total,
            'rows' => array()
        );
        if ($_total) {
            foreach ($_rs as $m) {
                $_idValue = $m->article_id;
                array_push($_rsp['rows'], array(
                    'id' => $_idValue,
                    'cell' => array(
                        $_idValue,
                        $m->type_name,
                        $m->article_title,
                        Helper::createSmallImg($context['__CDN__'], $context['__ASSETS__'], $m->article_img, $m->type_name),
                        '<span' . Auxi::getDeepColor($m->is_status) . '>'
                        . $this->setting['aryArticleStatus'][intval($m->is_status)] . '</span>',
                        // '<span' . Auxi::getDeepColor($m->is_home_display) . '>' . $this->setting['aryBool'][intval($m->is_home_display)] . '</span>',
                        $m->view_count,
                        Auxi::getTime($m->add_date)
                    )
                ));
            }
        }
        echo(MsgHelper::json('SUCCESS', '数据返回成功', $_rsp));
    }

}
