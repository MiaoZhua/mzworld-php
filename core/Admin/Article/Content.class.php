<?php

namespace Admin\Article;

if (!defined('IN_PX'))
    exit;

use Admin\AbstractCommon;

/**
 * 内容页
 */
class Content extends AbstractCommon {

    private function __Controller() {}

    //private function __RequestMapping($value = '/article') {}
    protected function __Inject($db) {}

    public function alistContent() {
        if ($this->_boolCanReadData()) {
            $this->rs = $this->db->select('a.*, b.*')
                ->table('`#@__@article` a, `#@__@article_content` b')
                ->where('a.`article_id` = ? AND a.`article_id` = b.`article_id`')
                ->bind(array($_GET['id']))
                ->find();
            $this->articleTags = $this->_getArticleTags($_GET['id']);
            $this->articleTypeTags = $this->_getArticleTypeTags();
        }
        if (!isset($_GET['parentId']))
            $_GET['parentId'] = '';
        if (!isset($_GET['id']))
            $_GET['id'] = '';
        $this->sltIDTree = $this->_selectIDTree(array('table' => '`#@__@article_type`',
            'where' => '`channel_type` < 9 AND `is_display` = 1'),
            array('value' => 'type_id', 'text' => 'type_name',
                'selected' => $this->rs ? $this->rs->type_id : $_GET['parentId'],
                'isShowArticleList' => true),
            array('disabled' => $this->pageControl));
        return true;
    }

    public function typeContent() {
        if ($this->_boolCanReadData()) {
            //$this->db->debug();
            $this->rs = $this->db->select('a.*, b.*')
                ->table('`#@__@article_type` a, `#@__@article_type_content` b')
                ->where('a.`type_id` = ? AND a.`type_id` = b.`type_id`')
                ->bind(array($_GET['id']))
                ->find();
        }
        if (!isset($_GET['parentId']))
            $_GET['parentId'] = '';
        if (!isset($_GET['parentChannelType']))
            $_GET['parentChannelType'] = 0;
        if (!isset($_GET['parentIsPart']))
            $_GET['parentIsPart'] = 0;
        if (!isset($_GET['parentNavType']))
            $_GET['parentNavType'] = 0;
        if (!isset($_GET['id']))
            $_GET['id'] = '';
        $this->sltIDTree = $this->_selectIDTree(array('table' => '`#@__@article_type`',
            'where' => '`is_display` = 1'),
            array('value' => 'type_id', 'text' => 'type_name',
                'selected' => $this->rs ? $this->rs->parent_id : $_GET['parentId']),
            array('disabled' => $this->pageControl));
        $this->getSort = $this->_getSort();
        return true;
    }

    public function adContent() {
        if ($this->_boolCanReadData()) {
            $this->rs = $this->db->select()
                ->table('`#@__@ad`')
                ->where('`ad_id` = ?')
                ->bind(array($_GET['id']))
                ->find();
        }
        if (!isset($_GET['parentId']))
            $_GET['parentId'] = '';
        if (!isset($_GET['id']))
            $_GET['id'] = '';
        $this->getSort = $this->_getSort('ad', 'ad_sort');
        return true;
    }

    public function anchorTextContent() {
        if ($this->_boolCanReadData()) {
            $this->rs = $this->db->select()
                ->table('`#@__@anchor_text`')
                ->where('`anchor_text_id` = ?')
                ->bind(array($_GET['id']))
                ->find();
        }
        if (!isset($_GET['id']))
            $_GET['id'] = '';
        return true;
    }

    public function footerLinkContent() {
        if ($this->_boolCanReadData()) {
            $this->rs = $this->db->select()
                ->table('`#@__@footer_link`')
                ->where('`footer_link_id` = ?')
                ->bind(array($_GET['id']))
                ->find();
        }
        if (!isset($_GET['parentId']))
            $_GET['parentId'] = '';
        if (!isset($_GET['id']))
            $_GET['id'] = '';
        $this->sltIDTree = $this->_selectIDTree(array('table' => '`#@__@article_type`',
            'where' => '`is_display` = 1'),
            array('value' => 'type_id', 'text' => 'type_name',
                'selected' => $this->rs ? $this->rs->type_id : $_GET['parentId']),
            array('disabled' => $this->pageControl),
            array('首页链接' => '0'));

        return true;
    }

}
