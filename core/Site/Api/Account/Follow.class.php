<?php

namespace Site\Api\Account;

if (!defined('IN_PX'))
    exit;

use Phoenix\RequestMethod;
use Site\AbstractCommon;
use Model\UserFollow;
use Tools\MsgHelper;
use Tools\Log4p as logger;

class Follow extends AbstractCommon {

    private function __RestController() {}

    private function __RequestMapping($value = '/api/account/follow') {}

    private function __Method($value = RequestMethod::POST) {}

    protected function __Inject(UserFollow $userFollow) {}

    public function follow($__RequestMapping = '/') {
        if ($this->userFollow->follow($_POST['userId'])) {
            return MsgHelper::aryJson('SUCCESS');
        }
        return MsgHelper::aryJson('ERROR');
    }

    public function remove() {
        if ($this->userFollow->remove($_POST['userId'])) {
            return MsgHelper::aryJson('SUCCESS');
        }
        return MsgHelper::aryJson('ERROR');
    }

    public function read() {
        $_type = intval($_POST['type']) == 0 ? 'user_id' : 'follow_user_id';
        $_rsp = array(
            'count' => $this->userFollow->count($_type),
            'list' => $this->userFollow->findAll(100, $_type)
        );
        return MsgHelper::aryJson('SUCCESS', null, $_rsp);
    }

}
