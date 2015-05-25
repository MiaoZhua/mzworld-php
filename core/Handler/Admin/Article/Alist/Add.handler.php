<?php

namespace Handler\Admin\Article\Alist;

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
 *
 */
class Add extends AbstractCommon {

    protected function __Inject($db, $cache, $session, UPFile $upFile,
                                Article $serviceArticle = null, Templates $toolsTemplates = null) {}

    public function processRequest(Array & $context) {
        try {
            $this->db->beginTransaction();

            $this->_pushSetting();
            $this->_processingParameters();

            $_POST['article_title'] = Html::getTextToHtml($_POST['article_title']);
            $_POST['is_home_display'] = isset($_POST['is_home_display']) ? intval($_POST['is_home_display']) : 0;
            $_POST['view_count'] = isset($_POST['view_count']) ? intval($_POST['view_count']) : 0;
            $_POST['master_id'] = $this->session->adminUser['id'];
            $_POST['add_date'] = time();
            $_POST['release_date'] = time();

            $_identity = $this->db->table('`#@__@article`')
                ->row(array(
                    '`type_id`' => '?',
                    '`article_title`' => '?',
                    '`seo_url`' => '?',
                    '`synopsis`' => '?',
                    '`article_img`' => '?',
                    '`is_home_display`' => '?',
                    '`view_count`' => '?',
                    '`seo_title`' => '?',
                    '`seo_keywords`' => '?',
                    '`seo_description`' => '?',
                    '`master_id`' => '?',
                    '`add_date`' => '?',
                    '`release_date`' => '?',
                    '`ilanguage`' => '?'
                ))
                ->bind($_POST)
                ->save();

            //$_POST['content'] = $this->serviceArticle->addAnchorText($_POST['content']);
            //$this->db->debug();
            $this->db->table('`#@__@article_content`')
                ->row(array(
                    '`article_id`' => '?',
                    '`content`' => '?'
                ))
                ->bind(array(
                    $_identity,
                    $this->serviceArticle->addAnchorText($_POST['content'])
                    //, $_POST['content']
                ))
                ->save();

            $this->cache->delete($this->setting['aryArticleDeleteCacheBindId']);
            if (isset($_POST['article_tags'])) {
                $this->_updateTags($_POST['article_tags'], $_identity);
            }

            $this->_createImg('article_img');

            if ((int) $this->cfg['is_html_page'] > 0) {
                $this->toolsTemplates->createColumn($_POST['type_id']);
                $this->toolsTemplates->createArticle($_identity, 'article');
            }

            $this->db->commit();

            echo(MsgHelper::json($_identity ? 'SUCCESS' : 'DB_ERROR'));
        } catch (Exception $e) {

            $this->db->rollBack();
            echo(MsgHelper::json('DB_ERROR'));
        }
    }

}
