<?php

namespace Site;

if (!defined('IN_PX'))
    exit;

use Phoenix\RequestMethod;
use Site\AbstractCommon;
use Model\Opus;
use Tools\MsgHelper;
use Tools\Log4p as logger;

class Challenge extends AbstractCommon {

    private function __Controller() {}

    protected function __Inject(Opus $opus) {}


    public function ChallengeDetail($__RequestMapping = '/challenge/{id:\d+}',
        $__Inject = array('\Model\Challenge' => '$challenge', '$session')) {
//        echo $this->id;exit;
        if (!($this->challengeRs = $this->challenge->find($this->id))) {
            return 404;
        }
        $this->pageSeoTitle = $this->challengeRs->challenge_name;
        
        //获取召集的描述列表
        $this->descriptionRs=$this->challenge->findalldescription($this->id);
//        print_r($this->descriptionRs);exit;
        //获取召集的附件列表
        $this->attachRs=$this->challenge->findallattach($this->id);
//        print_r($this->attachRs);exit;
        
//        if (!is_null($this->session->user)) {
//            $this->praise = $this->opus->praiseExists($this->id);
//        }
//        $this->praiseUser = $this->opus->readPraiseUser($this->id);
        return 'challenge/info';
    }

}
