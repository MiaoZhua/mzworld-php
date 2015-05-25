<?php

namespace Site\Api\Account;

if (!defined('IN_PX'))
    exit;

use Phoenix\RequestMethod;
use Site\AbstractCommon;
use Service\UPFile;
use Tools\MsgHelper;
use Model;
use Tools\Log4p as logger;

class Card extends AbstractCommon {

    private function __RestController() {}

    private function __RequestMapping($value = '/api/account/card') {}

    private function __Method($value = RequestMethod::POST) {}

    protected function __Inject(Model\Card $card) {}

    public function save($__Inject = array('$session')) {
        //chapter_id章节的id
        $_POST['user_id']=$this->session->user['id'];
        $_POST['tutorial_chapter_id']=intval($_POST['chapter_id']);
        $_POST['add_date']=time();
        return   $this->card->save($_POST);

    }

}
