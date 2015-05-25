<?php

namespace Phoenix\Impl;

if (!defined('IN_PX'))
    exit;

use Phoenix\ISession;
use Memcached;

/**
 * memcached session访问器
 */
class SessionMemcachedImpl implements ISession {

    private $_createTimeout;
    private $_timeout;
    private $_handler = null;
    private $_hosts = null;
    private $_salt = null;

    public function __construct($hosts, $salt) {
        $this->_hosts = $hosts;
        $this->_salt = $salt;
    }

    public function open($createTimeout, $timeout) {
        $this->_createTimeout = $createTimeout;
        $this->_timeout = $timeout;

        $this->_handler = new Memcached($this->_salt);
        $this->_handler->setOption(Memcached::OPT_RECV_TIMEOUT, 1000);
        $this->_handler->setOption(Memcached::OPT_SEND_TIMEOUT, 1000);
        $this->_handler->setOption(Memcached::OPT_TCP_NODELAY, true);
        $this->_handler->setOption(Memcached::OPT_SERVER_FAILURE_LIMIT, 50);
        $this->_handler->setOption(Memcached::OPT_CONNECT_TIMEOUT, 500);
        $this->_handler->setOption(Memcached::OPT_RETRY_TIMEOUT, 300);
        $this->_handler->setOption(Memcached::OPT_DISTRIBUTION, Memcached::DISTRIBUTION_CONSISTENT);
        $this->_handler->setOption(Memcached::OPT_REMOVE_FAILED_SERVERS, true);
        $this->_handler->setOption(Memcached::OPT_LIBKETAMA_COMPATIBLE, true);
        $this->_handler->setOption(Memcached::OPT_BINARY_PROTOCOL, true); //使用binary二进制协议
        $this->_handler->setOption(Memcached::OPT_COMPRESSION, false); //关闭压缩功能
        if (!count($this->_handler->getServerList())) {
            if (isset($this->_hosts['aliocs'])) {
                $this->_handler->addServer($this->_hosts['aliocs'][0], $this->_hosts['aliocs'][1]); //添加OCS实例地址及端口号
                $this->_handler->setSaslAuthData($this->_hosts['aliocs'][2], $this->_hosts['aliocs'][3]); //设置OCS帐号密码进行鉴权
            } else if ($this->_hosts['memcache']) {
                $this->_handler->addServer($this->_hosts['memcache'][0], $this->_hosts['memcache'][1]);
            } else if ($this->_hosts['memcached']) {
                $this->_handler->addServers($this->_hosts['memcached']);
            }
        }
    }

    public function set($realSessionId, Array $data = null) {
        return $this->_handler->set($realSessionId, $data, $this->_timeout);
    }

    public function activity($realSessionId) {
        $_flag = null;
        if (false !== ($_flag = $this->get($realSessionId))) {
            return $this->_handler->replace($realSessionId, $_flag, $this->_timeout);
        }
        return false;
    }

    public function get($realSessionId) {
        return $this->_handler->get($realSessionId);
    }

    public function destory($realSessionId) {
        return $this->_handler->delete($realSessionId);
    }

    /**
     * memcache会自动清理已超时
     * $this->_handler->flush()如果使用会讲所有缓存清空
     * */
    public function gc() {
        return true;
    }

}
