<?php

namespace Handler\Admin\Tutorial\Chapter;

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
            $_POST['sortName'] = 'a.tutorial_chapter_id';
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
            $_where .= ' AND (a.`title` LIKE :strSearchKeyword)';
            $_bindParam[':strSearchKeyword'] = '%' . trim($_POST['strSearchKeyword']) . '%';
        }
        if (isset($_POST['stage_type']) && $_POST['stage_type'] != '') {
            $_where .= ' AND a.`stage_type` = :stage_type';
            $_bindParam[':stage_type'] = $_POST['stage_type'];
        }

        $_where .= ' AND a.`is_display` = :is_display';
        $_bindParam[':is_display'] = isset($_POST['tc_is_display']) ? intval($_POST['tc_is_display']) : 0;

        $_table = '`#@__@tutorial_chapter` a, `#@__@tutorial` mc';
        $_where .= ' AND a.`tutorial_id` = mc.`tutorial_id`';

        $_total = $this->db->table($_table)->where($_where)->bind($_bindParam)->count();
        //$this->db->debug();
        $_rs = $this->db->select('a.*, mc.`title`')
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
                $_idValue = $m->tutorial_chapter_id;
                array_push($_rsp['rows'], array(
                    'id' => $_idValue,
                    'cell' => array(
                        $_idValue,
                        $m->title,
                        $m->chapter_name,
                        Helper::createSmallImg($context['__CDN__'], $context['__ASSETS__'], $m->picture, $m->chapter_name),
                        Helper::createSmallImg($context['__CDN__'], $context['__ASSETS__'], $m->card_front, $m->chapter_name),
                        $m->video_src,
                        '<span' . Auxi::getDeepColor($m->is_status) . '>'
                        . $this->setting['aryArticleStatus'][intval($m->is_status)] . '</span>',
                        '<span' . Auxi::getDeepColor(intval($m->is_display)) . '>'
                        . $this->setting['aryBool'][intval($m->is_display)] . '</span>',
                        Auxi::getTime($m->release_date),
                    )
                ));
            }
        }
        echo(MsgHelper::json('SUCCESS', '数据返回成功', $_rsp));
    }

}
