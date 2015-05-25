<?php

namespace Service;

if (!defined('IN_PX'))
    exit;

use Tools\Auxi;

class UrlHelper {

    private function __Service() {}

    private function __Value($cfg, $setting, $__ROOT__, $__CDN__, $__PACKAGE__, $__LANGUAGE_CONFIG__) {}

    private function __Inject($session) {}

    private $_languageId = NULL;

    private function _getRoot() {
        //为了避免 httpHandler 中无法获取 __LANGUAGE_ID__
        if (is_null($this->_languageId))
            $this->_languageId = intval(array_search($this->__PACKAGE__,
                $this->__LANGUAGE_CONFIG__));
        return $this->__ROOT__ . ($this->cfg['rewrite'] > 0 ? '' : 'server.php/');
    }

    public function getSltUrl(& $phpself, & $id, $page = null) {
        return $this->__ROOT__
        . (strcmp($phpself, 'index') == 0 ? 'repairing' : $phpself)
        //. ($id ? '/' . $id : '') . (intval($page) > 0 ? '/' . $page : '');
        . ($id ? '/' . $id : '');
    }

    public function getSltAttr($aryPageSearchLetters, $letter = null, $unset = false) {
        $_tmp = array();
        if ($unset) {
            unset($aryPageSearchLetters[$letter]);
        } else {
            $aryPageSearchLetters[$letter] = '';
        }
        if (count($aryPageSearchLetters) > 0) {
            if (count($aryPageSearchLetters) > 1)
                ksort($aryPageSearchLetters);
            $_out = '';
            //将url分成前后两段用于url拼接
            foreach ($aryPageSearchLetters as $k => $v) {
                $_out .= $k . $v;
                if ($k == $letter) {
                    array_push($_tmp, $_out);
                    $_out = '';
                }
            }
            array_push($_tmp, $_out);
            $_out = null;
        }
        unset($aryPageSearchLetters);
        return $_tmp;
    }

    /**
     * 获取指定的模块页面url
     * @param type $model 指定的模块名称
     * @param type $query 是否带有参数
     * @return string 返回一个指定model的url链接
     */
    public function getUrl($model, $query = null) {
        return $this->_getRoot() . $model . (is_null($query) ? '' : '?' . $query);
    }

    public function getStaticLink(& $strCmp, $text,
                                  $linkAttribute = array(), $disabled = false, $slt = 'slt') {
        $_tmp = '';
        if ($linkAttribute && is_array($linkAttribute) && count($linkAttribute) > 0) {
            $_attr = '';
            if ($disabled) {
                $linkAttribute['href'] = 'javascript:;';
                $linkAttribute['class'] = 'disabled';
            } else {
                if (strpos($linkAttribute['href'], $strCmp) !== false) {
                    $linkAttribute['class'] = (isset($linkAttribute['class']) &&
                        $linkAttribute['class'] != '' ?
                            $linkAttribute['class'] . ' ' :
                            '') . $slt;
                }
                $linkAttribute['href'] = $this->_getRoot() . $linkAttribute['href'];
            }
            foreach ($linkAttribute as $_k => $_v) {
                if ($_v)
                    $_attr .= ' ' . $_k . '="' . $_v . '"';
            }
            $_tmp = '<a' . $_attr . '>' . $text . '</a>';
        }
        return $_tmp;
    }

    public function getPageUrl(& $obj, $query = null) {
        $_url = '';
        $_isSeoUrl = $obj->seo_url != '' ? true : false;
        if (intval($this->cfg['is_html_page']) > 0) {
            $_url = $this->__ROOT__ . $this->__PACKAGE__ . '/' . trim($obj->list_dir, '/') . '/'
                . ($_isSeoUrl ? $obj->seo_url : $obj->article_id)
                . '.html';
        } else {
            $_url = $this->_getRoot()
                . (intval($obj->ilanguage > 0) ? $this->__PACKAGE__ . '/' : '')
                . $this->setting['aryChannelTypeMapping'][$this->__PACKAGE__][$obj->channel_type][3]
                . '/' . ($_isSeoUrl ? $obj->seo_url : $obj->article_id)
                . (is_null($query) ? '' : '?' . $query);
        }
        return $_url;
    }

    /**
     * getTypeUrl的当前页缓存
     */
    public $aryTypeUrlCurrentCache = array();

    /**
     *
     * @param type $aryArticleTypeDataView
     * @param type $aryIdTree
     * @param type $query
     * @return string
     */
    public function getTypeUrl(& $aryArticleTypeDataView, $aryIdTree, $query = null) {
        $_key = '';
        if (is_array($aryIdTree)) {
            $_key = implode('.', $aryIdTree);
        } else {
            $_key = trim($aryIdTree, '.');
            $aryIdTree = explode('.', $_key);
        }
        if (isset($this->aryTypeUrlCurrentCache[$_key])) {//存在当前页缓存中
            return $this->aryTypeUrlCurrentCache[$_key];
        }

        $_url = '';
        $_rootId = intval(current($aryIdTree));
        //列表目录
        $_rootListDir = $aryArticleTypeDataView[$_rootId]['list_dir'];
        $_parentPart = null; //父路径类型
        $_selfId = $_rootId; //自身id

        $_selfValue = $aryArticleTypeDataView;
        $_count = count($aryIdTree);
        if ($_count == 1) {
            $_selfValue = $aryArticleTypeDataView[$_rootId];
        } else {
            for ($_i = 0; $_i < $_count; $_i++) {
                $_selfValue = $_selfValue[intval($aryIdTree[$_i])];
                if ($_i == $_count - 2) {
                    $_parentPart = $_selfValue['is_part'];
                }
            }
            $_selfId = intval(end($aryIdTree));
        }
        $_selfPart = $_selfValue['is_part']; //自身页面属性
        $_selfLevel = $_selfValue['level'];
        $_i = 0;
        if ($_selfPart == 2) {
            $_url = $_selfValue['list_dir'];
        } else {
            if (intval($this->cfg['is_html_page']) > 0) {
                $_url = $this->__ROOT__ . trim($this->__PACKAGE__ . '/' . $_rootListDir, '/') . '/';
                $_selfListDir = $_selfValue['list_dir'];
                if ($_selfLevel > 1) {//非一级栏目
                    $_i = $_selfValue['sort'];
                    if ($_i == 0 && $_parentPart == 1) {//如果自身为index但父目录是单页频道页，则应该显示list_id
                        ++$_i;
                    }

                    //判断子目录并提取真实显示的id
                    $_tmpChildTypeIdListDir = Auxi::getChildTypeIdListDir($_selfValue, $_selfId);
                    $_selfId = $_tmpChildTypeIdListDir[0];
                    $_selfListDir = $_tmpChildTypeIdListDir[1];
                    unset($_tmpChildTypeIdListDir);

                    if ($_i == 0 && $_selfLevel > 2 && !Auxi::isDataViewIndexId(
                            $aryArticleTypeDataView[$_rootId], $_selfId, $_selfLevel)) //2级以后都是以list_id显示
                        ++$_i;
                }

                if ($_i > 0)
                    $_url .= Auxi::getArticleListName($_i, $_selfId, $_selfListDir);
            } else {
                $_url = $this->_getRoot()
                    . ($this->_languageId > 0 ? $this->__PACKAGE__ . '/' : '')
                    . Auxi::getDynamicListName($this->setting['aryChannelTypeMapping'],
                        $this->__PACKAGE__,
                        $_selfValue, $_selfId)
                    . (is_null($query) ? '' : '?' . $query);
            }
        }
        $this->aryTypeUrlCurrentCache[$_key] = $_url;
        return $_url;
    }

    public function getSelfUrl() {
        return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

    public function getReturnUrl($url, $ruledOut = null) {
        $_returnUrl = $url ? urldecode($url) : $this->getSelfUrl();
        //返回值存在排除项的时候 回到首页
        if ($ruledOut && stripos($_returnUrl, $ruledOut) !== false) {
            $_returnUrl = $this->__ROOT__;
        }
        return urlencode($_returnUrl);
    }

    public function getUserViewUrl($userId) {
        if (!is_null($this->session->user) && $userId == $this->session->user['id'])
            return ' href="javascript:;"';
        return ' href="' . $this->__ROOT__ . 'u/' . $userId . '" target="_blank"';
    }

    public function getTagsUrl($tag) {
        return $this->_getRoot() . 'tags/' . urlencode($tag);
    }

    public function getSearchUrl($q) {
        return $this->_getRoot() . 'search/' . urlencode($q);
    }

    public function compareSelect($id, $level, $idTree, $className) {
        $_aryIdTree = explode('.', trim($idTree, '.'));
        return $id == intval($_aryIdTree[$level - 1]) ? ' class="' . $className . '"' : '';
    }

    public function getUserImg($img, $status, & $userId) {
        return $this->getUploadImg(($status == 2 ? $img : null), 's',
            array('lazy' => false, 'vml' => false), 'user/' . $userId);
    }

    public function getUploadImg($img, $mode = 's',
                                 $imgAttribute = array('lazy' => false), $path = 'pics') {
        $_attr = '';
        $_src = $this->__CDN__ . '/' . (
            $img ? trim($path, '/') . '/' . $mode . '/' . $img : 'no_img.gif');
        if ($imgAttribute['lazy']) {
            $_attr .= ' class="lazy"';
            $_attr .= ' src="' . $this->__CDN__ . '/gray.gif"';
            $_attr .= ' data-original="' . $_src . '"';
        } else if ($imgAttribute['src']) {
            return $_src;
        } else {
            $_attr .= ' src="' . $_src . '"';
        }
        unset($imgAttribute['lazy']);
        if (count($imgAttribute) > 0) {
            foreach ($imgAttribute as $_k => $_v) {
                if ($_v)
                    $_attr .= ' ' . $_k . '="' . $_v . '"';
            }
        }
        return '<img' . $_attr . '>';
    }

    public function getUploadImgByIdTree(& $idTree,
                                         & $aryArticleTypeDataView, $mode = 'l', $path = 'pics') {
        $_aryIdTree = explode('.', trim($idTree, '.'));
        foreach ($_aryIdTree as $_id) {
            $aryArticleTypeDataView = $aryArticleTypeDataView[(int) $_id];
        }
        return $aryArticleTypeDataView['type_img'] ?
            '<img src="' . $this->__CDN__
            . trim($path, '/') . '/' . $mode . '/'
            . $aryArticleTypeDataView['type_img'] . '">' :
            '';
    }

    public function getTemplateImg($imgAttribute = array('lazy' => false), $linkAttribute = array()) {
        $_attr = '';
        $_img = null;
        if ($imgAttribute && is_array($imgAttribute) && $imgAttribute['src']) {
            $_src = $this->__ASSETS__ . 'images/' . $imgAttribute['src'];
            if ($imgAttribute['lazy']) {
                $_attr .= ' class="lazy"';
                $_attr .= ' src="' . $this->__CDN__ . '/gray.gif"';
                $_attr .= ' data-original="' . $_src . '"';
            } else {
                $_attr .= ' src="' . $_src . '"';
            }
            unset($imgAttribute['src']);
            unset($imgAttribute['lazy']);
            if (count($imgAttribute) > 0) {
                foreach ($imgAttribute as $_k => $_v) {
                    if ($_v)
                        $_attr .= ' ' . $_k . '="' . $_v . '"';
                }
            }
            $_img = '<img' . $_attr . ' />';
            if ($linkAttribute && is_array($linkAttribute) && count($linkAttribute) > 0) {
                $_attr = '';
                foreach ($linkAttribute as $_k => $_v) {
                    if ($_v)
                        $_attr .= ' ' . $_k . '="' . $_v . '"';
                }
                $_img = '<a' . $_attr . '>' . $_img . '</a>';
            }
        }

        return $_img;
    }

}
