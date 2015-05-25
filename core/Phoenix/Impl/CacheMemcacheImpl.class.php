<?php

namespace Phoenix\Impl;

if (!defined('IN_PX'))
    exit;

use Phoenix\ICache;
use Memcache;

/**
 * memcache 访问器
 */
class CacheMemcacheImpl implements ICache {

    private $_handler = null;
    private $_host = null;
    private $_port = null;
    private $_salt = null; //加入salt，避免在memcache中不同项目key一致

//    private $_cacheMapping = null; //缓存id映射
//    private $_cacheMappingName = '__CacheMapping__'; //存放id映射的地址

    public function __construct($hosts, $salt) {
        $this->_host = $hosts['memcache'][0];
        $this->_port = $hosts['memcache'][1];
        $this->_salt = $salt;
//        $this->_cacheMappingName .= $this->_salt;
    }

    public function open() {
        $this->_handler = new Memcache();
        $_r = $this->_handler->pconnect($this->_host, $this->_port);
//        if (!($this->_cacheMapping = $this->_handler->get($this->_cacheMappingName)))
//            $this->_cacheMapping = array();
        return $_r;
    }

    public function set($key, $var, $expires) {
        $key = md5($key . $this->_salt);
//        if (!isset($this->_cacheMapping[$key])) {
//            $this->_cacheMapping[$key] = 0;
//            return $this->_handler->set($this->_cacheMappingName, $this->_cacheMapping, MEMCACHE_COMPRESSED, 0);
//        }
        return $this->_handler->set($key, $var, MEMCACHE_COMPRESSED, $expires);
    }

    public function get($key, $expires) {
        return $this->_handler->get(md5($key . $this->_salt));
    }

    public function exists($key) {
        return $this->get($key, null) === false ? false : true;
    }

    public function delete($key) {
        if (is_array($key) && count($key) > 0) {
            foreach ($key as $v) {
                $this->_handler->delete(md5($v . $this->_salt));
            }
            return true;
        } else {
            return $this->_handler->delete(md5($key . $this->_salt));
        }
    }

    /**
     * memcache会自动清理已超时
     * $this->_handler->flush()如果使用会将所有缓存清空
     * @return boolean
     */
    public function gc() {
//        if (count($this->_cacheMapping) > 0) {
//            foreach ($this->_cacheMapping as $_key => $_diabled)
//                $this->_handler->delete($_key);
//        }
        return $this->_handler->flush();
        return true;
    }

}
