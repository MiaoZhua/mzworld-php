<?php

namespace Site;

if (!defined('IN_PX'))
    exit;

use Tools\Auxi;
use Model\User;
use Tools\Log4p as logger;

/**
 * Class Index
 * @package Site
 */
class ForgotPassword extends AbstractCommon {

    private function __Controller() {}

//    private function __Value($cfg, $setting) {}

    protected function __Inject(User $user, $cache) {}

    public function forgotPassword() {
        if (!isset($_GET['uuid'])) {
            return 404;
        }
        if (($_tmp = $this->cache->expires(60 * 30)->get($_GET['uuid']))) {
            return true;
        }
        return 404;
    }

}
