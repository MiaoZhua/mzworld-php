<?php

namespace Phoenix;

if (!defined('IN_PX'))
    exit;

/**
 * Session接口
 */
interface ISession {

    public function open($createTimeout, $timeout);

    public function set($realSessionId, Array $data = null);

    public function activity($realSessionId);

    public function get($realSessionId);

    public function destory($realSessionId);

    public function gc();

}
