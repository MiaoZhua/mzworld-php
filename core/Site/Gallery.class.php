<?php

namespace Site;

if (!defined('IN_PX'))
    exit;

use Phoenix\RequestMethod;
use Site\AbstractCommon;
use Model\Opus;
use Tools\MsgHelper;
use Tools\Log4p as logger;

class Gallery extends AbstractCommon {

    private function __Controller() {}

    protected function __Inject(Opus $opus) {}

    public function gallery() {
        $this->opusCount = $this->opus->count();
        return true;
    }

    public function galleryDetail($__RequestMapping = '/gallery/{id:\d+}',
                                  $__Inject = array('\Model\Opus' => '$opus', '$session')) {
        if (!($this->opusRs = $this->opus->find($this->id))) {
            return 404;
        }

        $this->pageSeoTitle = $this->opusRs->title;
        if (!is_null($this->session->user)) {
            $this->praise = $this->opus->praiseExists($this->id);
        }
        $this->praiseUser = $this->opus->readPraiseUser($this->id);
        return 'gallery/opus';
    }

}
