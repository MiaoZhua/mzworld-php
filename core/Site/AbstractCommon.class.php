<?php

namespace Site;

if (!defined('IN_PX'))
    exit;

use Service\Article;
use Service\UrlHelper;
use PDO;

/**
 * 前台页面抽象聚合类
 * Class AbstractCommon
 * @package ZhCN
 */
abstract class AbstractCommon {

    //protected function __Bundle($setting = 'data/setting.cache.php') {}
//    protected function __Value($cfg, $setting) {}

//    protected function __Inject($db, $cache, $session, Article $serviceArticle, UrlHelper $urlHelper) {}

    /**
     * __InjectData会在__Value等注入之前执行但级别没有__construct高
     * 如果需要类初始化时候就拿到这些数据，应该使用__construct注入
     * __InjectData方法及__construct中$__InjectData同时出现，默认只会执行__construc中注入
     * @param array $data
     */
    public function __InjectData(Array & $data) {
        $this->_data = & $data;
        //die(var_dump($this->cfg));
    }

    protected $_data = array();

    /**
     * 读取类别内容及分页
     * @param $typeId
     * @param bool $usePagination 是否使用当前类别分页
     * @return bool
     */
    protected function _getPageTypeList($typeId, $usePagination = false) {
        if ($this->_chkArticleTypeDataView()) {
            if (is_null($this->currentTypeRs))
                $this->currentTypeRs = $this->db->select('a.*, b.*')
                    ->table('`#@__@article_type` a, `#@__@article_type_content` b')
                    ->where('a.`' . (is_numeric($typeId) ? 'type_id' : 'list_dir')
                        . '` = ? AND a.`type_id` = b.`type_id`')
                    ->bind(array($typeId))
                    ->find();
            if ($this->currentTypeRs) {
                $this->rootId = $this->currentTypeRs->root_id;
                $this->typeId = $this->currentTypeRs->type_id;
                $this->isPart = $this->currentTypeRs->is_part;
                $_GET['parentId'] = $this->currentTypeRs->parent_id;
                $this->typeLevel = $this->currentTypeRs->level;
                $this->idTree = $this->currentTypeRs->id_tree;
                $this->getArticleBreadcrumb = $this->_getArticleBreadcrumb();
                $this->pageSeoTitle = $this->currentTypeRs->seo_title;
                $this->pageSeoDescription = $this->currentTypeRs->seo_description;
                $this->pageSeoKeywords = $this->currentTypeRs->seo_keywords;
                $this->pageFooterLink = $this->_getPageLink($this->rs->type_id); //底部链接
                //静态页生成时会默认传入一个total，减少数据库访问
                if ($usePagination) {
                    $this->currentTypeTotal = $this->currentTypeTotal ?
                        $this->currentTypeTotal :
                        intval($this->db->table('`#@__@article`')
                            ->where('`type_id` = ? AND `is_display` = 1')
                            ->bind(array($this->typeId))
                            ->count());

                    $this->currentPageSize = $this->setting['aryChannelTypeMapping'][$this->__PACKAGE__][$this->currentTypeRs->channel_type][2];
                }

                if ($this->isPart == 1) {
                    $this->currentTypeRs->content = $this->resetAnchorText == 1 ?
                        $this->addAnchorText($this->currentTypeRs->content) :
                        $this->currentTypeRs->content;
                }

                return true;
            }
        }
        return false;
    }

    /**
     * 读取文章页内容
     * @param $id
     * @return bool
     */
    protected function _getPageContentShow($id) {
        //$this->db->debug();
        if ($this->_chkArticleTypeDataView() && is_null($this->pageContentRs))
            $this->pageContentRs = $this->db->select('a.*, b.*, c.`level`, c.`id_tree`, c.`parent_id`,
				c.`root_id`, c.`is_part`, c.`channel_type`, c.`nav_type`')
                ->table('`#@__@article` a, `#@__@article_content` b, `#@__@article_type` c')
                ->where('a.`' . (is_numeric($id) ? 'article_id' : 'seo_url')
                    . '` = ? AND a.`is_display` = 1 AND a.`article_id` = b.`article_id`
								AND a.`type_id` = c.`type_id` AND c.`is_display` = 1')
                ->bind(array($id))
                ->find();
        if ($this->pageContentRs) {
            $this->currentArticleId = $this->pageContentRs->article_id;
            $this->rootId = $this->pageContentRs->root_id;
            $this->typeId = $this->pageContentRs->type_id;
            $this->releaseDate = \Tools\Auxi::getShortTime($this->pageContentRs->release_date);
            $this->isPart = $this->pageContentRs->is_part;
            $_GET['parentId'] = $this->pageContentRs->parent_id;
            $this->typeLevel = $this->pageContentRs->level;
            $this->idTree = $this->pageContentRs->id_tree;
            $this->viewCount = $this->pageContentRs->view_count + 1;
            $this->channelType = $this->pageContentRs->channel_type;
            $this->pageSeoTitle = $this->pageContentRs->seo_title;
            $this->pageSeoDescription = $this->pageContentRs->seo_description;
            $this->pageSeoKeywords = $this->pageContentRs->seo_keywords;

            $this->getArticleBreadcrumb = $this->_getArticleBreadcrumb();
            $this->getAricleTags = $this->_getAricleTags($id);
            $this->getUpDownArticle = $this->_getUpDownArticle();

            $this->pageContentRs->content = $this->resetAnchorText == 1 ?
                $this->addAnchorText($this->pageContentRs->content) :
                $this->pageContentRs->content;
            return true;
        }
        return false;
    }

    protected function _chkArticleTypeDataView() {
        if (!$this->aryArticleTypeDataView) {
            $this->aryArticleTypeDataView = $this->serviceArticle->getArticleTypeDataCache();
        }
        return !!$this->aryArticleTypeDataView;
    }

    /**
     * 加载指定页面的底部链接
     * @param int $typeId
     * @return string
     */
    protected function _getPageLink($typeId = 0) {
        $_r = '';
        //$this->db->debug();
        $rs = $this->db->cacheable()->select()
            ->table('`#@__@footer_link`')
            ->where('(`type_id` = ? OR `link_type` = 1) AND `is_status` = 1')
            ->bind(array($typeId))
            ->order('footer_link_id', 'ASC')
            ->findAll();
        //die(var_dump($rs));
        if (count($rs) > 0) {
            $_r .= '<div class="friend_link">友情链接：';
            foreach ($rs as $m) {
                //$_temp = intval($m->link_type);
                //不是全站的链接和全站链接但是不在当前类别的
                $_r .= '<a href="' . $m->link_url . '" title="' . $m->link_url . '"'
                    . (intval($m->target) == 0 ? ' target="_blank"' : '')
                    . '>' . $m->keywords . '</a> ';
            }
            $_r .= '</div>';
        }
        return $_r;
    }

    protected function addAnchorText(& $text) {
        return $this->serviceArticle->addAnchorText($text);
    }

    /**
     * 获取文章页的面包屑导航
     * @return string|void
     */
    protected function _getArticleBreadcrumb() {
        if (!$this->idTree)
            return;

        $_aryIdTree = explode('.', trim($this->idTree, '.'));
        $_out = '当前位置：<a href="' . $this->__ROOT__ . '">'
            . $this->cfg['site_name'] . '</a>';

        $_aryArticleTypeDataView = $this->aryArticleTypeDataView;
        foreach ($_aryIdTree as $_id) {
            $_id = intval($_id);
            $_aryArticleTypeDataView = $_aryArticleTypeDataView[$_id];

            $_out .= ' <span class="arrow">&gt;</span> <a href="'
                . $this->urlHelper->getTypeUrl($this->aryArticleTypeDataView,
                    $_aryArticleTypeDataView['id_tree']) . '">'
                . $_aryArticleTypeDataView['type_name'] . '</a>';
        }
        return $_out;
    }

    protected function _getUpDownArticle() {
        $_out = '<div class="article_up_down clearfix"><div class="left">';
        $_upRs = $this->db->select('a.`article_id`, a.`article_title`, b.`channel_type`, c.`list_dir`')
            ->table('`#@__@article` a, `#@__@article_type` b, `#@__@article_type` c')
            ->where('a.`release_date` < ? AND a.`type_id` = ? AND a.`is_display` = 1'
                . ' AND a.`type_id` = b.`type_id` AND b.`root_id` = c.`type_id`')
            ->bind(array($this->pageContentRs->release_date, $this->typeId))
            ->order('release_date', 'DESC')
            ->find();
        if ($_upRs) {
            $_out .= '<a href="' . $this->urlHelper->getPageUrl($_upRs)
                . '"><span class="arrow">&lt;</span>' . $_upRs->article_title . '</a>';
        } else {
            $_out .= '<span class="arrow">&lt;</span>暂无上一篇';
        }
        $_out .= '</div><div class="right">';

        $_downRs = $this->db->select('a.`article_id`, a.`article_title`, b.`channel_type`, c.`list_dir`')
            ->table('`#@__@article` a, `#@__@article_type` b, `#@__@article_type` c')
            ->where('a.`release_date` > ? AND a.`type_id` = ? AND a.`is_display` = 1'
                . ' AND a.`type_id` = b.`type_id` AND b.`root_id` = c.`type_id`')
            ->bind(array($this->pageContentRs->release_date, $this->typeId))
            ->order('release_date', 'ASC')
            ->find();
        if ($_downRs) {
            $_out .= '<a href="' . $this->urlHelper->getPageUrl($_downRs)
                . '">' . $_downRs->article_title . '<span class="arrow">&gt;</span></a>';
        } else {
            $_out .= '暂无下一篇<span class="arrow">&gt;</span>';
        }
        $_out .= '</div></div>';
        return $_out;
    }

    protected function _getAricleTags($id) {
        $_r = '';
        $_tags = $this->db->mode(PDO::FETCH_COLUMN)->select('b.tags_text')
            ->table('`#@__@tags_list` a, `#@__@tags` b')
            ->where('a.`article_id` = ? AND a.`tags_id` = b.`tags_id`')
            ->bind(array($id))
            ->order('b.tags_id', 'ASC')
            ->findAll();
        if (count($_tags) > 0) {
            $_r .= '<div class="tags">Tag：';
            $_bool = false;
            foreach ($_tags as $_tag) {
                if ($_bool)
                    $_r .= '，';
                $_r .= '<a href="'
                    . $this->urlHelper->getTagsUrl($_tag)
                    . '">' . $_tag . '</a>';
                $_bool = true;
            }
            $_r .= '</div>';
        }
        return $_r;
    }

    /**
     * 广告
     * @param int $typeId
     * @return array
     */
    protected function _getSiteAd($typeId = 0) {
        $_ad = 'aryAdRotator' . $typeId;

        $_tmp = array();
        if (!($_tmp = $this->cache->expires(300)->get($_ad))) {
            $_time = time();
            //$this->db->debug();
            $_tmp = $this->db->select('`ad_title`, `ad_img`, `ad_url`, `target`')
                ->table('`#@__@ad`')
                ->where('`type_id` = ? AND `is_display` = 1 AND `start_date` < ? AND `end_date` > ?')
                ->bind(array($typeId, $_time, $_time))
                ->order('`ad_sort`', 'ASC')
                ->findAll();
            $this->cache->expires(300)->set($_ad, $_tmp);
        }
        return $_tmp;
    }

    public function & __get($name) {
        $_r = null;
        if (isset($this->_data[$name])) {
            $_r = & $this->_data[$name];
        }
        return $_r;
    }

    public function __set($name, $value) {
        return $this->_data[$name] = $value;
    }

}
