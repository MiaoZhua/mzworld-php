<?php

namespace Site;

if (!defined('IN_PX'))
    exit;

use Tools\Auxi;
use Model\Article;
use Tools\Log4p as logger;

class Yplan extends AbstractCommon {

    private function __Controller() {}

    private function __Inject(Article $article) {}

    public function yplan($__RequestMapping = '/{id:\d*}') {
        if (!is_null($this->id)) {
            if (!($this->rs = $this->article->find($this->id))) {
                return 404;
            }
            $this->pageSeoTitle = $this->rs->seo_title;
            $this->pageSeoDescription = $this->rs->seo_description;
            $this->pageSeoKeywords = $this->rs->seo_keywords;
            return 'yplan/newsDetail';
        }
        $this->count = $this->article->count();
        $this->yplan = $this->article->findAll(3);
        return true;
    }

}
