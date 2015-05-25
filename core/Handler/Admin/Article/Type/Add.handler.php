<?php

namespace Handler\Admin\Article\Type;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;
use Service\Article;
use Service\Templates;
use Service\UPFile;
use Tools\Html;
use Tools\MsgHelper;
use Exception;

/**
 * 添加
 */
class Add extends AbstractCommon {

    protected function __Inject($db, $cache, $session, UPFile $upFile,
                                Article $serviceArticle = null, Templates $toolsTemplates = null) {}

    public function processRequest(Array & $context) {
        try {
            $this->db->beginTransaction();

            $this->_pushSetting();
            $this->_processingParameters();
            $this->_getIdTree();

            //		if ($_POST['is_part'] == 1 && empty($_POST['seo_title']))
            //			$_POST['seo_title'] = $_POST['type_name'] . '_' . $this->cfg['title'];
            //$this->db->debug();
            if ($_POST['list_dir'] != '' && $_POST['is_part'] < 2) {
                $_POST['list_dir'] = $this->_filterToSeoUrl($_POST['list_dir']);
            }
            $_POST['type_name'] = Html::getTextToHtml($_POST['type_name']);
            $_POST['level'] = $_POST['level'] + 1;
            $_POST['nav_type'] = ($_POST['level'] > 1 && $_POST['nav_type'] != 1 ? 2 : $_POST['nav_type']);
            $_POST['master_id'] = $this->session->adminUser['id'];
            $_POST['add_date'] = time();
            $_POST['release_date'] = time();

            $_identity = $this->db->table('`#@__@article_type`')
                ->row(array(
                    '`type_name`' => '?',
                    '`type_img`' => '?',
                    '`level`' => '?',
                    '`id_tree`' => '?',
                    '`parent_id`' => '?',
                    '`channel_type`' => '?',
                    '`is_part`' => '?',
                    '`list_dir`' => '?',
                    '`target`' => '?',
                    '`sort`' => '?',
                    '`nav_type`' => '?',
                    '`is_display`' => '?',
                    '`master_id`' => '?',
                    '`add_date`' => '?',
                    '`release_date`' => '?',
                    '`ilanguage`' => '?'
                ))
                ->bind($_POST)
                ->save();

            if ($_POST['level'] == 1)
                $_POST['root_id'] = $_identity;

            $_return = $this->db->table('`#@__@article_type`')
                ->row(array(
                    '`root_id`' => '?',
                    '`id_tree`' => '?'
                ))
                ->where('type_id = ?')
                ->bind(array(
                    $_POST['root_id'],
                    $_POST['id_tree'] . str_pad($_identity, 3, '0', STR_PAD_LEFT) . '.',
                    $_identity
                ))
                ->update();

            $this->db->table('`#@__@article_type_content`')
                ->row(array(
                    '`type_id`' => '?',
                    '`seo_title`' => '?',
                    '`seo_keywords`' => '?',
                    '`seo_description`' => '?',
                    '`content`' => '?'
                ))
                ->bind(array(
                    $_identity,
                    $_POST['seo_title'],
                    $_POST['seo_keywords'],
                    $_POST['seo_description'],
                    $this->serviceArticle->addAnchorText($_POST['content'])
                ))
                ->save();

            $this->db->commit();

            $this->_createImg('type_img', false);

            if ((int) $this->cfg['is_html_page'] > 0) {
                $this->toolsTemplates->createColumn($_identity);
            } else {
                $this->cache->delete(array('aryArticleTypeDataView', 'footerArticleTypeNavigation'));
            }

            echo(MsgHelper::json($_return ? 'SUCCESS' : 'DB_ERROR'));
        } catch (Exception $e) {

            $this->db->rollBack();
            echo(MsgHelper::json('DB_ERROR'));
        }
    }

}
