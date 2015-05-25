<?php

namespace Admin\Article;

if (!defined('IN_PX'))
    exit;

use Admin\AbstractCommon;

/**
 * 列表页
 */
class AList extends AbstractCommon {

    private function __Controller() {}

    private function __RequestMapping($value = '/article') {}

    protected function __Inject($db) {}

    public function alist() {
        $this->sltIDTree = $this->_selectIDTree(array('table' => '`#@__@article_type`',
            'where' => '`channel_type` < 9 AND `is_display` = 1'),
            array('value' => 'type_id', 'text' => 'type_name', 'isShowArticleList' => true),
            array('name' => 'type_id', 'style' => '180px'),
            array('显示全部' => '0'));
        //die(var_dump(ucwords($this->model)));
        return true;
    }

    public function footerLink() {
        $this->sltIDTree = $this->_selectIDTree(array('table' => '`#@__@article_type`',
            'where' => '`is_display` = 1'),
            array('value' => 'type_id', 'text' => 'type_name'),
            array('name' => 'type_id', 'style' => 'width:180px;'),
            array('显示全部' => '', '首页链接' => '0'));
        //die(var_dump(ucwords($this->model)));
        return true;
    }

}
