<?php

namespace Phoenix;

if (!defined('IN_PX'))
    exit;

/**
 * Cache接口
 */
interface ICache {

    public function open();

    public function set($key, $var, $expires);

    public function get($key, $expires);

    public function delete($key);

    public function gc();
}
