<?php

namespace Handler\Admin\Material\Avatar;

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
            $_POST['sortName'] = 'a.material_avatar_id';
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
        if (isset($_POST['parts']) && $_POST['parts'] != '') {
            $_where .= ' AND a.`parts` = :parts';
            $_bindParam[':parts'] = $_POST['parts'];
        }

        $_where .= ' AND a.`is_display` = :is_display';
        $_bindParam[':is_display'] = isset($_POST['ma_is_display']) ? intval($_POST['ma_is_display']) : 0;

        $_table = '`#@__@material_avatar` a';
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
            foreach ($_rs as $m) {
                $_idValue = $m->material_avatar_id;
                array_push($_rsp['rows'], array(
                    'id' => $_idValue,
                    'cell' => array(
                        $_idValue,
                        $m->title,
                        '<span' . Auxi::getDeepColor(intval($m->parts)) . '>'
                        . $this->setting['aryParts'][intval($m->parts)] . '</span>',
                        $m->level,
                        Helper::createSmallImg($context['__CDN__'], $context['__ASSETS__'], $m->src_front, $this->setting['aryMaterial'][0]),
                        Helper::createSmallImg($context['__CDN__'], $context['__ASSETS__'], $m->src_rear, $this->setting['aryMaterial'][1]),
                        Helper::createSmallImg($context['__CDN__'], $context['__ASSETS__'], $m->src_left, $this->setting['aryMaterial'][2]),
                        Helper::createSmallImg($context['__CDN__'], $context['__ASSETS__'], $m->src_right, $this->setting['aryMaterial'][3]),
                        '<span' . Auxi::getDeepColor(intval($m->is_display)) . '>'
                        . $this->setting['aryBool'][intval($m->is_display)] . '</span>',
                        Auxi::getTime($m->add_date),
                    )
                ));
            }
        }
        echo(MsgHelper::json('SUCCESS', '数据返回成功', $_rsp));
    }

}
