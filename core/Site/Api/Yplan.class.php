<?php

namespace Site\Api;

if (!defined('IN_PX'))
    exit;

use Site\AbstractCommon;
use Model\Article;
use Tools\MsgHelper;
use Tools\Auxi;
use Tools\Log4p as logger;

class Yplan extends AbstractCommon {

    private function __RestController() {}

    private function __Inject(Article $article) {}

    public function yplan() {
        $_rs = $this->article->findAll(4, 50);
        if (count($_rs) > 0) {
            foreach ($_rs as $_m) {
                $_m->release_date = Auxi::getShortTime($_m->release_date);
            }
        }
        return MsgHelper::aryJson('SUCCESS', null, $_rs);
    }

}
