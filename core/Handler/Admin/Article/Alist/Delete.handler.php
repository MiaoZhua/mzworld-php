<?php

namespace Handler\Admin\Article\Alist;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;
use Tools\MsgHelper;
use Exception;

/**
 * 文章删除
 */
class Delete extends AbstractCommon {

    public function processRequest(Array & $context) {
        try {
            $this->db->beginTransaction();

            $this->_pushSetting();
            $this->cache->delete($this->setting['aryArticleDeleteCacheBindId']);
            if ($this->cfg['is_html_page'] > 0) {
                $_ary = explode(',', $_POST['id']);
                foreach ($_ary as $_id) {
                    //$_POST['db']->debug();
                    $_rs = $this->db->select('a.`seo_url`, a.`add_date`, a.`ilanguage`, c.`list_dir`')
                        ->table('`#@__@article` a, `#@__@article_type` b, `#@__@article_type` c')
                        ->where('a.`article_id` = ? AND a.`type_id` = b.`type_id` AND b.`root_id` = c.`type_id`')
                        ->bind(array($_id))->find();
                    $_htmlPath = ROOT_PATH . $context['__LANGUAGE_CONFIG__'][$_rs->ilanguage]
                        . DIRECTORY_SEPARATOR . trim($_rs->list_dir, '/')
                        . DIRECTORY_SEPARATOR;
                    if ($_rs->seo_url != '') {
                        $_htmlPath .= $_rs->seo_url;
                    } else {
                        $_htmlPath .= date('Ymd', $_rs->add_date) . DIRECTORY_SEPARATOR . $_id;
                    }
                    $_htmlPath .= '.html';
                    if (is_file($_htmlPath))
                        unlink($_htmlPath);
                }
            }
            echo($this->_publicDeleteFieldByPostItem($_POST['id'],
                array('`#@__@article`', '`#@__@article_content`'),
                'article_id', true, array('article_img')));

            $this->db->commit();
        } catch (Exception $e) {

            $this->db->rollBack();
            echo(MsgHelper::json('DB_ERROR'));
        }
    }

}
