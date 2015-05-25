<?php

namespace Service;

if (!defined('IN_PX'))
    exit;

use Service\UrlHelper;

/**
 * 文章表服务类
 * v1.2.8 增加了两个索引 typeIdMappingRootId, listDirMappingRoodId
 * 			分别为类别id和路径映射rootId
 */
class Article {

    const VERSION = '1.2.8';

    //服务层组件
    private function __Value($__PACKAGE__, $setting) {}

    private function __Service($value = 'article') {}

    private function __Inject($db, $cache, UrlHelper $urlHelper) {}

    private $_aryTypeIdMappingRootId = null;
    private $_aryListDirMappingRoodId = null;

    public function getArticleTypeDataCache() {
        $_cacheId = 'aryArticleTypeDataView';
        if (!($_tmp = $this->cache->get($_cacheId))) {
            $this->_aryTypeIdMappingRootId = array();
            $this->_aryListDirMappingRoodId = array();
            $_tmp = $this->_getAryArticleTypeDataView();
            if (!is_null($_tmp)) {
                $_tmp['typeIdMappingRootId'] = $this->_aryTypeIdMappingRootId;
                $_tmp['listDirMappingRoodId'] = $this->_aryListDirMappingRoodId;
            }
            $this->cache->set($_cacheId, $_tmp);
        }
        return $_tmp;
    }

    /**
     * 获取类别缓存用于生成html中的面包屑导航
     * @return type
     */
    private function _getAryArticleTypeDataView($typeId = 0, $typeLevel = 0, $deep = 5) {
        if ($typeLevel >= $deep)
            return null;
        $_rs = null;
        $_where = '0 = 0';
        $_args = array();
        $_aryType = array();
        $_temp = null;
        if ($typeId > 0) {
            $_where .= ' AND a.`parent_id` = ?';
            array_push($_args, $typeId);
        }
        array_push($_args, $typeLevel + 1);
        //$this->db->debug();
//		$_rs = $this->db->select('a.type_id, a.type_name, a.type_img, a.level, a.id_tree
//			, a.parent_id, a.root_id, a.channel_type, a.is_part, a.list_dir, a.target
//			, a.nav_type, b.seo_title, b.seo_keywords, b.seo_description, b.content')
//				->table('`#@__@article_type` a, `#@__@article_type_content` b')
//				->where($_where . ' AND a.level = ? AND a.is_display = 1 AND a.type_id = b.type_id')
//				->order('a.sort', 'ASC')
//				->bind($_args)
//				->findAll();
        $_rs = $this->db->option(array(
            'select' => 'a.`type_id`, a.`type_name`, a.`type_img`, a.`level`, a.`id_tree`,
				a.`parent_id`, a.`root_id`, a.`channel_type`, a.`is_part`, a.`list_dir`, a.`target`,
				a.`nav_type`, b.`seo_title`, b.`seo_keywords`, b.`seo_description`, b.`content`',
            'table' => '`#@__@article_type` a, `#@__@article_type_content` b',
            'where' => ($_where . ' AND a.`level` = ? AND a.`is_display` = 1 AND a.`type_id` = b.`type_id`'),
            'order' => 'a.`sort` ASC',
            'bind' => $_args
        ))->findAll();
        if (count($_rs) > 0) {
            $_i = 0;
            foreach ($_rs as $m) {
                $_temp = $this->_getAryArticleTypeDataView($m->type_id, $typeLevel + 1, $deep);
                if (!is_null($_temp)) {
                    $_aryType[$m->type_id] = $_temp;
                }

                $this->_aryTypeIdMappingRootId[$m->type_id] = $m->root_id;
                if ($m->list_dir != '')
                    $this->_aryListDirMappingRoodId[$m->list_dir] = $m->root_id;

                $_aryType[$m->type_id]['type_name'] = stripslashes($m->type_name);
                $_aryType[$m->type_id]['sort'] = $_i;
                $_aryType[$m->type_id]['type_img'] = $m->type_img;
                $_aryType[$m->type_id]['level'] = $m->level;
                $_aryType[$m->type_id]['id_tree'] = $m->id_tree;
                $_aryType[$m->type_id]['parent_id'] = $m->parent_id;
                $_aryType[$m->type_id]['root_id'] = $m->root_id;
                $_aryType[$m->type_id]['channel_type'] = $m->channel_type;
                $_aryType[$m->type_id]['is_part'] = $m->is_part;
                $_aryType[$m->type_id]['list_dir'] = $m->list_dir;
                $_aryType[$m->type_id]['target'] = $m->target;
                $_aryType[$m->type_id]['nav_type'] = $m->nav_type;
                $_aryType[$m->type_id]['seo_title'] = $m->seo_title;
                $_aryType[$m->type_id]['seo_keywords'] = $m->seo_keywords;
                $_aryType[$m->type_id]['seo_description'] = $m->seo_description;
                //$_aryType[$m->type_id]['content'] = $m->content;
                if ($m->is_part < 2)
                    $_i++;
            }
            return $_aryType;
        }
        return null;
    }

    /**
     * 预加载的欲清除链接的锚文本数组
     * @return array <type> string
     */
    public function getAryAnchorText() {
        $_temp = array();
        //可在链式调用的方法中安全的返回值
        $rs = $this->db->chains()->select('`text`, `link_url`')
            ->table('`#@__@anchor_text`')
            ->where('`is_status` = 1')
            ->order('LENGTH(`text`) ASC, `anchor_text_sort`', 'ASC')
            ->findAll();
        if (count($rs) > 0) {
            foreach ($rs as $m) {
                array_push($_temp, array($m->text, $m->link_url));
                //$_temp[$m->text] = $m->link_url;
            }
        }
        return $_temp;
    }

    /**
     * 打散重排，自动插入锚文本
     * @param type $body
     * @param bool|type $isReorganize
     * @param int|type $separator
     * @param bool|type $insertKey
     * @param null $aryAnchorText
     * @return type
     */
    public function reorganize(& $body, $isReorganize = false, $separator = 0,
                               $insertKey = false, $aryAnchorText = null) {
        if (get_magic_quotes_gpc())
            $body = htmlspecialchars_decode(stripslashes($body));
        $_arySeparator = array('，', '。');
        if ($isReorganize || $insertKey) {
            $body = str_replace(',', '，', $body);
            $_aryTempBody = explode($_arySeparator[$separator], $body);
            if ($isReorganize) {
                shuffle($_aryTempBody);
            }
            if ($insertKey) {//获取关键字
                $_tempKeywords = array();
                if ($aryAnchorText == null) {
                    $aryAnchorText = $this->getAryAnchorText();
                }
                foreach ($aryAnchorText as $_kv) {
                    if (strpos($body, $_kv[0]) === false)//未出现关键字的话压入数组
                        array_push($_tempKeywords, $_kv[0]);
                }
                shuffle($_tempKeywords);

                $_countKey = count($_tempKeywords);

                if ($_countKey > 0) {
                    $_countBody = count($_aryTempBody);
                    $_k = 1; //插入阈值
                    if ($_countBody > $_countKey) {
                        $_k = floor(($_countBody - 8) / $_countKey);
                    }
                    $_j = 0;
                    for ($_i = 0; $_i < $_countBody; $_i++) {
                        if ($_i > 0 && $_i % $_k == 0) {
                            $_aryTempBody[$_i] = $_tempKeywords[$_j] . $_aryTempBody[$_i];
                            $_j++;
                        }
                    }
                }
            }
            $body = implode($_arySeparator[$separator], $_aryTempBody);
            $body = $isReorganize ? nl2br($body) : $body;
        }
        return $body;
    }

    /**
     * 插入锚文本
     * @param type $text
     * @param type $aryAnchorText
     * @return type
     */
    public function addAnchorText(& $text, & $aryAnchorText = null) {
        if ($text != '') {
            if ($aryAnchorText == null)
                $aryAnchorText = $this->getAryAnchorText();
            if (count($aryAnchorText) > 0) {
                if (!is_null($this->_data['is_reorganize']) || !is_null($this->_data['is_ai_insert'])) {
                    $text = $this->reorganize($text,
                        intval($this->_data['is_reorganize']) > 0 ? true : false,
                        intval($this->_data['rdo_separator']),
                        intval($this->_data['is_ai_insert']) > 0 ? true : false,
                        $aryAnchorText);
                }

                $_keyword = null;
                $_linkUrl = null;
                foreach ($aryAnchorText as $_kv) {
                    $_keyword = $_kv[0];
                    $_linkUrl = $_kv[1];
                    if (get_magic_quotes_gpc()) {
                        $text = htmlspecialchars_decode(stripslashes($text));
                    }
                    $_tmpKey = preg_quote($_keyword, '/');
                    $_tmpLinkUrl = preg_quote($_linkUrl, '/');
                    $_pattern = '/<a[^>]*' . $_tmpLinkUrl . '[\/"]?\s[^>]*>' . $_tmpKey . '<\/a>/i'; //已有链接的关键字匹配
                    if (!preg_match($_pattern, $text, $_matches)) {//未匹配
                        $text = preg_replace('/(?<![=">])' . $_tmpKey . '/isU',
                            '<a href="' . $_linkUrl . '" title="' . $_keyword . '">' . $_keyword . '</a>',
                            $text, 1);
                    }
                }
            }
        }
        return $text;
    }

}
