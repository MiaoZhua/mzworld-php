<?php

namespace Handler\Admin;

if (!defined('IN_PX'))
    exit;

use Phoenix\IHttpHandler;
use Tools\MsgHelper;
use Tools\Html;
use Service\UPFile;
use PDO;
use Tools\Log4p as logger;

/**
 * handler处理类
 *
 */
abstract class AbstractCommon implements IHttpHandler {

    protected function __Handler() {}

    protected function __Value($cfg, $setting) {}

    protected function __Inject($db, $cache, $session, UPFile $upFile) {}

    /**
     * 后台处理需要的setting数据
     * @return type
     * @internal param array $context
     */
    protected function _pushSetting() {
        if (isset($_POST['sltDateA'])) {
            $_POST['sltDateA'] = strtotime($_POST['sltDateA']);
        }
        if (isset($_POST['sltDateB'])) {
            $_POST['sltDateB'] = strtotime($_POST['sltDateB']);
        }
        if (isset($_POST['ilanguage'])) {
            $_POST['ilanguage'] = intval($_POST['ilanguage']);
        }
        if (isset($_POST['release_date'])) {
            $_POST['release_date'] = strtotime($_POST['release_date']);
        }
        return true;
    }

    /**
     * 压入的参数处理
     * 基本上大多数add edit都会用到的数据
     * @internal param array $context
     * @return bool
     */
    protected function _processingParameters() {
        if (isset($_POST['seo_title']) && $_POST['seo_title'] != '')
            $_POST['seo_title'] = Html::getTextToHtml($_POST['seo_title'], 50);
        else
            $_POST['seo_title'] = (isset($_POST['article_title']) ? $_POST['article_title'] :
                (isset($_POST['type_name']) ? $_POST['type_name'] : ''));

        if (isset($_POST['article_tags']) && $_POST['article_tags'] != '')
            $_POST['seo_keywords'] = Html::getLenStr($_POST['article_tags'], 50);

        if (isset($_POST['synopsis']) && $_POST['synopsis'] != '')
            $_POST['synopsis'] = Html::getTextToHtml($_POST['synopsis'], 200);
        else if (isset($_POST['content']))
            $_POST['synopsis'] = Html::getLenStr(Html::htmlToText($_POST['content']), 200);
        else
            $_POST['synopsis'] = '';

        if (isset($_POST['seo_description']) && $_POST['seo_description'] == '')
            $_POST['seo_description'] = Html::clearBreak(Html::getLenStr(Html::htmlToText($_POST['content']), 100));

        if (isset($_POST['link_url']) && $_POST['link_url'] != '')
            $_POST['link_url'] = 'http://' . str_replace('http://', '', $_POST['link_url']);
        return true;
    }

    /**
     * 文章 产品类别生成的idtree
     * @param string $dt
     * @param string $idName
     * @return bool
     * @internal param array $context
     */
    protected function _getIdTree($dt = 'article_type', $idName = 'type_id') {
        $_POST['parent_id'] = intval($_POST[$idName]);
        if ($_POST['parent_id']) {
            $_parentRs = $this->db->select('`parent_id`, `level`, `id_tree`')
                ->table("`#@__@{$dt}`")->where("`{$idName}` = ?")
                ->bind(array($_POST['parent_id']))->find();
            if ($_parentRs) {
                $_POST['level'] = intval($_parentRs->level);
                $_POST['id_tree'] = $_parentRs->id_tree;
                $_POST['root_id'] = $_POST['level'] == 1 ? intval($_POST['parent_id']) :
                    $this->_getRootId($_parentRs->parent_id, $dt, $idName);
            }
            $_parentRs = null;
            unset($_parentRs);
        } else {
            $_POST['level'] = 0;
            $_POST['id_tree'] = '.';
            $_POST['root_id'] = $_POST['id'];
        }
        return true;
    }

    protected function _getRootId($parentId, $dt = 'article_type', $idName = 'type_id') {
        $_rs = $this->db->select("`{$idName}`, `parent_id`, `level`")
            ->table("`#@__@{$dt}`")->where("`{$idName}` = ?")
            ->bind(array($parentId))->find();
        if ($_rs)
            return intval($_rs->level) == 1 ?
                intval($_rs->$idName) :
                $this->_getRootId($_rs->parent_id, $dt, $idName);
    }

    /**
     * 通用列表删除函数 ★★★★★
     * @param $id
     * @param $dt 表名
     * @param $field 字段名
     * @param bool $delUpFile 是否删除上传文件
     * @param array $delFieldORDt 包含文件的字段或者多图情况下的表名
     * @return string
     */
    protected function _publicDeleteFieldByPostItem($id, $dt, $field, $delUpFile = false,
                                                    Array $delFieldORDt = null) {
        $_aryId = explode(',', $id);
        $_boolAryDt = is_array($dt);
        $_boolAryField = is_array($field);
        $_dt = $_boolAryDt ? array_shift($dt) : $dt;
        $_field = $_boolAryField ? array_shift($field) : $field;
        foreach ($_aryId as $_id) {
            if ($_id) {
                if ($delUpFile) {
                    if (isset($delFieldORDt['table'])) {
                        $_rs = $this->db->mode(PDO::FETCH_COLUMN)
                            ->select($delFieldORDt['field'])->table($delFieldORDt['table'])
                            ->where("{$_field} = ?")->bind(array($_id))->findAll();
                        if (count($_rs) > 0) {
                            foreach ($_rs as $_src) {
                                $this->upFile->deleteFile($_src);
                            }
                        }
                    } else {
                        //$this->db->debug();
                        if (is_array($delFieldORDt)) {
                            $_tmpRs = $this->db->select(implode(',', $delFieldORDt))->table($_dt)
                                ->where("{$_field} = ?")->bind(array($_id))->find();
                            foreach ($delFieldORDt as $_key) {
                                $this->upFile->deleteFile($_tmpRs->$_key);
                            }
                        } else {
                            $this->upFile->deleteFile($this->db
                                ->field($delFieldORDt)->table($_dt)
                                ->where("{$_field} = ?")->bind(array($_id))->find());
                        }
                    }
                }
                $_r = $this->db->table($_dt)->where("{$_field} = ?")
                    ->bind(array($_id))->delete();
                if ($_boolAryDt) {
                    foreach ($dt as $_k => $_delDt) {
                        //$this->db->debug();
                        $_r = $this->db->table($_delDt)
                            ->where(($_boolAryField ? $field[$_k] : $_field) . ' = ?')
                            ->bind(array($_id))->delete();
                        if (!$_r) {
                            break;
                        }
                    }
                    if (!$_r) {
                        return MsgHelper::json('DB_DELETE_ERR', $_id);
                    }
                }
            }
        }
        return MsgHelper::json('SUCCESS');
    }

    protected function deleteFileForDbField($field, $table, $id, $bindId) {
        $this->upFile->deleteFile($this->db
            ->field($field)->table($table)
            ->where("{$id} = ?")
            ->bind(array($bindId))->find());
    }

    /**
     * 生成图片
     * @param $imgId
     * @param null $markImg 是否生成水印图片
     */
    protected function _createImg($imgId, $markImg = null) {
        if ($_POST[$imgId]) {
            $this->upFile->createImg($_POST[$imgId], $markImg);
        }
    }

    /**
     * 生成多图
     * @param type $multipleImgId
     * @param type $context
     */
    protected function _createMultipleImg($multipleImgId, & $context) {
        if (count($context[$multipleImgId]) > 0) {
            foreach ($context[$multipleImgId] as $src) {
                if ($this->upFile->createImg($src)) {
                    $this->db->table('`#@__@goods_images`')
                        ->row(array(
                            '`goods_id`' => '?',
                            '`src`' => '?',
                            '`add_date`' => '?'
                        ))
                        ->bind(array(
                            $_POST['id'],
                            $src,
                            time()
                        ))
                        ->save();
                }
            }
        }
    }

    protected function _updateTags($articleTags, $articleId) {
        if ($articleTags != '') {
            $_aryTags = explode(',', str_replace(array('，', ' ', ';'),
                array(',', ',', ','), $articleTags));
            $_aryTagIds = array();
            $_countTotal = 0;
            foreach ($_aryTags as $_tag) {
                $_count = 0;
                $_tagsId = intval($this->db->field('tags_id')
                    ->table('`#@__@tags`')->where('tags_text = ?')
                    ->bind(array($_tag))->find());
                if ($_tagsId == 0) {//不存在
                    $_tagsId = $this->db->table('`#@__@tags`')
                        ->row(array('`tags_text`' => '?'))
                        ->bind(array($_tag))
                        ->save();
                    $_count++; //申明有变动
                }
                //$this->db->debug();
                if (intval($this->db->table('`#@__@tags_list`')
                        ->where('tags_id = ? AND article_id = ?')
                        ->bind(array($_tagsId, $articleId))
                        ->count()) == 0) {//不存在则插入
                    //$this->db->debug();
                    $this->db->table('`#@__@tags_list`')
                        ->row(array(
                            '`tags_id`' => '?',
                            '`article_id`' => '?'
                        ))
                        ->bind(array(
                            $_tagsId,
                            $articleId
                        ))
                        ->save();
                    $_count++;
                }
                if ($_count > 0) {//有变动就要重新统计数量
                    $this->db->table('`#@__@tags`')
                        ->row(array(
                            'total' => '(SELECT COUNT(*) FROM `#@__@tags_list` WHERE tags_id = ?)'
                        ))
                        ->where('`tags_id` = ?')
                        ->bind(array(
                            $_tagsId,
                            $_tagsId
                        ))
                        ->update();
                }
                $_countTotal += $_count; //统计返回的变动

                array_push($_aryTagIds, $_tagsId); //已存在的关键字
            }
            $_aryOldTagIds = $this->db->mode(PDO::FETCH_COLUMN)
                ->select('`tags_id`')->table('`#@__@tags_list`')
                ->where('`article_id` = ?')->bind(array($articleId))
                ->findAll(); //读取全部关键字，可能会比原有少
            $_diffTagIds = array_unique(array_diff($_aryTagIds, $_aryOldTagIds)); //得到差值
            //die(var_dump($_diffTagIds));
            if (count($_diffTagIds) > 0) {
                foreach ($_diffTagIds as $_tagId) {//删除老关键字
                    $this->db->table('`#@__@tags_list`')
                        ->where('`tags_id` = ? AND `article_id` = ?')
                        ->bind(array($_tagId, $articleId))
                        ->delete();
                }
                $_countTotal++; //申明变动
            }
            //logger::debug($_countTotal);
            return $_countTotal;
        }
    }

    /**
     * 置顶之类的通用方法，主要是将状态在0和1之间切换，如果非切换，则改变指定值
     * @param $aryId
     * @param $dt
     * @param $setFieldName
     * @param $whereFieldName
     * @param bool $isToggle 是否为状态切换
     * @param null $setFieldValue 非状体切换则指定值
     * @return string
     */
    protected function _setFieldStatus($aryId, $dt, $setFieldName, $whereFieldName,
                                       $isToggle = true, $setFieldValue = null) {
        $_errList = array();
        $_sql = $isToggle ? "ABS($setFieldName - 1)" : '?';
        foreach ($aryId as $_id) {
            $_bind = array();
            if (!$isToggle)
                array_push($_bind, $setFieldValue);

            array_push($_bind, $_id);
            $_return = $this->db->table($dt)
                ->row(array(
                    $setFieldName => $_sql
                ))
                ->where("$whereFieldName = ?")
                ->bind($_bind)
                ->update();
            if (!$_return) {
                array_push($_errList, $_id);
                continue;
            }
        }
        return MsgHelper::json('SUCCESS', count($_errList) > 0 ? implode(',', $_errList) . '未处理' : '');
    }

    protected function _editorAlert($msg) {
        echo(json_encode(array('error' => 1, 'message' => $msg)));
        exit();
    }

    protected function _filterToSeoUrl($url) {
        $url = strtolower(trim($url));
        $url = preg_replace(array('/[^a-z\s-\(\[\d]/', '/[\(\[]/', '/[\s-]+/'),
            array('', '-', '-'), $url);
        return $url;
    }

    /**
     * 得到属性的缓存Id
     * @param $table
     * @param int $typeId
     * @return string
     */
    protected function _getAttributesCacheName($table, $typeId = 0) {
        //logger::debug($table);
        return 'ary' . str_replace(' ', '', ucwords(str_replace('_', ' ', $table)))
        . 'DataView';
    }

}
