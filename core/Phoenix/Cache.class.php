<?php

namespace Phoenix;

if (!defined('IN_PX'))
    exit;

use Phoenix\Impl;

class Cache {

    //持久层 value 别名 $value = ''
    //TODO
    private function __Repository() {}

    private function __Value($dsn) {}

    //private function __Bundle($dsn = 'data/dsn.cache.php') {}

    private $_cacheHandler = null;
    private $_fileHandler = null;
    private $_memcacheHandler = null;
    private $_mode = null;
    private $_cacheType = null;
    private $_result = null;
    private $_expires = 0; //默认值0

    /**
     * 设置超时时间，如果需要应用超时设置，get,set方法前都需要使用这个函数
     * 链式操作
     * 如果确定只使用memcache，可以只在set时设置时间
     * 不设置默认不超时
     * @param int|type $sec
     * @return Cache
     */

    public function expires($sec = 0) {
        $this->_expires = $sec;
        return $this;
    }

    public function set($key, $var) {
        $this->_lazyInit();
        $this->_result = $this->_cacheHandler->set($key, $var, $this->_expires);
        $this->_expires = 0;
        return $this->_result;
    }

    public function get($key) {
        $this->_lazyInit();
        $this->_result = $this->_cacheHandler->get($key, $this->_expires);
        $this->_expires = 0;
        return $this->_result;
    }

    public function exists($key) {
        $this->_lazyInit();
        return $this->_cacheHandler->exists($key);
    }

    public function delete($key) {
        $this->_lazyInit();
        return $this->_cacheHandler->delete($key);
    }

    public function gc() {
        $this->_lazyInit();
        $this->_result = null;
        return $this->_cacheHandler->gc();
    }

    /**
     * 指定缓存使用模式：file memcache
     * 如果有大量的缓存碎片不希望占用宝贵的内存空间(与memcache分开缓存)
     * 可在此方法上指定某个缓存类型，如 file(磁盘缓存)
     * @param type $mode
     * @return \\Phoenix\Cache
     */
    public function mode($mode = null) {
        if (!is_null($mode)) {
            $this->_mode = strtolower($mode);
        }
        return $this;
    }

    private function _lazyInit() {
        if (is_null($this->_cacheType)) {
            $this->_cacheType = strtolower($this->dsn['default']['cacheType']);
        }
        if (is_null($this->_mode)) {
            $this->_mode = $this->_cacheType;
        }
        switch ($this->_mode) {
            case 'file':
                if (is_null($this->_fileHandler)) {
                    $this->_run(new Impl\CacheFileImpl());
                }
                $this->_cacheHandler = & $this->_fileHandler;
                break;
            case 'memcache':
                if (is_null($this->_memcacheHandler)) {
                    $this->_run(new Impl\CacheMemcacheImpl($this->dsn['default']['memServers'],
                        $this->dsn['default']['dbName']));
                }
                //对象为引用，可省略取址
                $this->_cacheHandler = & $this->_memcacheHandler;
                break;
            case 'memcached':
                if (is_null($this->_memcacheHandler)) {
                    $this->_run(new Impl\CacheMemcachedImpl($this->dsn['default']['memServers'],
                        $this->dsn['default']['dbName']));
                }
                $this->_cacheHandler = & $this->_memcacheHandler;
                break;
        }
        $this->_mode = $this->_cacheType; //重置为默认
    }

    private function _run(ICache & $handler) {
        switch ($this->_mode) {
            case 'file':
                if (!is_dir(CACHE_PATH)) {
                    mkdir(CACHE_PATH, 0777);
                }
                $this->_fileHandler = & $handler;
                $this->_fileHandler->open();
                break;
            case 'memcache':
            case 'memcached':
                $this->_memcacheHandler = & $handler;
                $this->_memcacheHandler->open();
                break;
        }
    }

}
