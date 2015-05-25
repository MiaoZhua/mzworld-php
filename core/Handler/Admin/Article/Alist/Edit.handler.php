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
 * 文章修改
 */
class Edit extends AbstractCommon {

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
            $_POST['article_id'] = $_POST['id'];

            //$this->db->debug();
            $_return = $this->db->table('`#@__@article`')
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
                    '`release_date`' => '?',
                    '`ilanguage`' => '?'
                ))
                ->where('`article_id` = ?')
                ->bind($_POST)
                ->update();

            $_return += $this->db->table('`#@__@article_content`')
                ->row(array(
                    '`content`' => '?'
                ))
                ->where('`article_id` = ?')
                ->bind(array(
                    $this->serviceArticle->addAnchorText($_POST['content']),
                    $_POST['article_id']
                ))
                ->update();

            if (isset($_POST['article_tags'])) {
                $_return += $this->_updateTags($_POST['article_tags'], $_POST['article_id']);
            }

            if ($_return > 0) {
                $this->cache->delete($this->setting['aryArticleDeleteCacheBindId']);
                $this->_createImg('article_img');

                if ((int) $this->cfg['is_html_page'] > 0) {
                    $this->toolsTemplates->createColumn($_POST['type_id']);
                    $this->toolsTemplates->createArticle($_POST['id'], 'article');
                }
            }

            $this->db->commit();

            echo(MsgHelper::json($_return ? 'SUCCESS' : ($_return == 0 ? 'NO_CHANGES' : 'DB_ERROR')));
        } catch (Exception $e) {

            $this->db->rollBack();
            echo(MsgHelper::json('DB_ERROR'));
        }
    }

}
