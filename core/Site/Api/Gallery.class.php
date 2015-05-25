<?php

namespace Site\Api;

if (!defined('IN_PX'))
    exit;

use Phoenix\RequestMethod;
use Site\AbstractCommon;
use Model\Opus;
use Tools\MsgHelper;
use Tools\Log4p as logger;

class Gallery extends AbstractCommon {

    private function __RestController() {}

    private function __RequestMapping($value = '/api/gallery') {}

    private function __Method($value = RequestMethod::POST) {}

    protected function __Inject(Opus $opus) {}

    public function read() {
        $_rp = 8;
        $_page = intval($_POST['page']);
        if ($_page == 0) {
            $_page = 1;
        }
        $_topId = 0;
        if ($_page == 1) {
            $_rp = 9;
            $_start = 0;
        } else {
            $_start = (($_page - 1) * $_rp);
            $_topId = $_POST['topId'];
        }

        $_rs = $this->opus->findAll($_start, $_rp, $_POST['order'], false, $_topId);
        return MsgHelper::aryJson('SUCCESS', null, $_rs);
    }

    public function userOpus($__Inject = array('\Model\User' => '$user', '\Model\UserFollow' => '$userFollow', '$session')) {
        $_followStatus = 'show';
        if (is_null($this->session->user)) {
            $_followStatus = 'login';
        } else if(intval($this->session->user['id']) == intval($_POST['userId'])) {
            $_followStatus = 'hide';//无法关注自己
        } else if ($this->userFollow->followed($_POST['userId'])) {
            $_followStatus = 'remove';
        }
        $_rsp = array(
            'profile' => $this->user->statistics($_POST['userId']),
            'opus' => $this->opus->findAll(50, null, 2, $_POST['userId']),
            'follow' => $_followStatus
        );

        return MsgHelper::aryJson('SUCCESS', null, $_rsp);
    }

}
