<?php

namespace Site\Api\Account;

if (!defined('IN_PX'))
    exit;

use Phoenix\RequestMethod;
use Site\AbstractCommon;
use Model\User;
use Tools\MsgHelper;
use Tools\Log4p as logger;

class Profile extends AbstractCommon {

    private function __RestController() {}

    private function __RequestMapping($value = '/api/account/user') {}

    private function __Method($value = RequestMethod::POST) {}

    protected function __Inject(User $user) {}

    public function profile() {
        return $this->user->profile($_POST);
    }

    public function read() {
        return MsgHelper::aryJson('SUCCESS', null, $this->user->read($_POST));
    }

    public function avatar() {
        return $this->user->avatar($_POST);
    }

    public function password() {
        return $this->user->password($_POST);
    }

    public function statistics() {
        $_rs = $this->user->statistics();
        $_rs->day = floor((time() - $_rs->add_date) / (3600 * 24));
        return MsgHelper::aryJson('SUCCESS', null, $_rs);
    }

}
