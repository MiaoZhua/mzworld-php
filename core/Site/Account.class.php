<?php

namespace Site;

if (!defined('IN_PX'))
    exit;

use Model\Opus;
use Tools\Log4p as logger;

/**
 * Class Index
 * @package Site
 */
class Account extends AbstractCommon {

    private function __Controller() {}

    private function __RequestMapping($value = '/account') {}

//    private function __Value($cfg, $setting) {}

    protected function __Inject(Opus $opus, $session) {}

    public function account($__RequestMapping = '/', $__Inject = array('\Model\UserFollow' => '$userFollow','\Model\Challenge' => '$challenge')) {
        $this->opusList = $this->opus->findAll(50);
        $this->friendCount = $this->userFollow->count('user_id', true);
        $this->friendList = $this->userFollow->friend();
        
        
        //获取空间  我的召集
		$this->AccountchallengeRs=$this->challenge->findAccountlistchallenge();
		
        
        return true;
    }

    public function opusPost($__RequestMapping = '/{id}') {
        if ($this->id > 0) {
            if (($this->rs = $this->opus->find($this->id, true))) {
                if ($this->rs->is_status < 5) {
                    return 404;
                } else {
                    return true;
                }
            }
            return 404;
        }
        return true;
    }

}
