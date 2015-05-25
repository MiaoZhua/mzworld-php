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
 * 修改
 */
class Edit extends AbstractCommon {

    protected function __Inject($db, $cache, $session, UPFile $upFile,
                                Article $serviceArticle = null, Templates $toolsTemplates = null) {}

    public function processRequest(Array & $context) {
        try {
            $this->db->beginTransaction();

            $this->_pushSetting();
            $this->_processingParameters();
            $this->_getIdTree();

            //$this->db->debug();
            if ($_POST['list_dir'] != '' && $_POST['is_part'] < 2) {
                $_POST['list_dir'] = $this->_filterToSeoUrl($_POST['list_dir']);
            }

            $_POST['type_name'] = Html::getTextToHtml($_POST['type_name']);
            $_POST['level'] = $_POST['level'] + 1;
            $_POST['id_tree'] = $_POST['id_tree'] . str_pad($_POST['id'], 3, '0', STR_PAD_LEFT) . '.';
            $_POST['nav_type'] = ($_POST['level'] > 1 && $_POST['nav_type'] != 1 ? 2 : $_POST['nav_type']);
            $_POST['type_id'] = $_POST['id'];

            $_return = $this->db->table('`#@__@article_type`')
                ->row(array(
                    '`type_name`' => '?',
                    '`type_img`' => '?',
                    '`level`' => '?',
                    '`id_tree`' => '?',
                    '`parent_id`' => '?',
                    '`root_id`' => '?',
                    '`channel_type`' => '?',
                    '`is_part`' => '?',
                    '`list_dir`' => '?',
                    '`target`' => '?',
                    '`sort`' => '?',
                    '`nav_type`' => '?',
                    '`is_display`' => '?',
                    '`release_date`' => '?',
                    '`ilanguage`' => '?'
                ))
                ->where('`type_id` = ?')
                ->bind($_POST)
                ->update();

            //$_POST['content'] = $this->serviceArticle->addAnchorText($_POST['content']);
            //$this->db->debug();
            $_return += $this->db->table('`#@__@article_type_content`')
                ->row(array(
                    '`seo_title`' => '?',
                    '`seo_keywords`' => '?',
                    '`seo_description`' => '?',
                    '`content`' => '?'
                ))
                ->where('`type_id` = ?')
                ->bind(array(
                    $_POST['seo_title'],
                    $_POST['seo_keywords'],
                    $_POST['seo_description'],
                    $this->serviceArticle->addAnchorText($_POST['content']),
                    $_POST['type_id']
                ))
                ->update();

            $this->db->commit();

            if ($_return > 0) {
                $this->_createImg('type_img', false);

                if ((int) $this->cfg['is_html_page'] > 0) {
                    $this->toolsTemplates->createColumn($_POST['id']);
                } else {
                    $this->cache->delete(array('aryArticleTypeDataView', 'footerArticleTypeNavigation'));
                }
            }

            echo(MsgHelper::json($_return ? 'SUCCESS' : ($_return == 0 ? 'NO_CHANGES' : 'DB_ERROR')));
        } catch (Exception $e) {

            $this->db->rollBack();
            echo(MsgHelper::json('DB_ERROR'));
        }
    }

}
