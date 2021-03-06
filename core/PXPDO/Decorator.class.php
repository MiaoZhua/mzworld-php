<?php

namespace PXPDO;

if (!defined('IN_PX'))
    exit;

/**
 * 多数据源 装饰器
 * singleton模式
 */
class Decorator extends AbstractDecorator {

    //持久层组件
    private function __Repository() {}

    //使用全局定义
    private function __Value($dsn) {}

    //如果未指明类，将从route.config.php中取定义
    private function __Inject($cache) {}

    private $_pdoHandlers = array();
    private $_dsnKey = 'default';
    private $_cache = null;
    protected $_dsn = null;

    //初始化传参可以直接拿到配置中的变量值
    //构造器注入 构造器必须为 public 否则无法注入
    //cache使用代理免疫直接返回类的实例而不是代理类，所以不能使用引用传址，也不需要引用传址
    //php5中对象默认就是引用
    public function __construct(& $dsn, $cache) {
        $this->_dsn = & $dsn;
        $this->_cache = $cache;
        return $this->set();
    }

    public final function set($dsnKey = 'default') {
        $this->_dsnKey = $dsnKey;
        if (!isset($this->_pdoHandlers[$this->_dsnKey])) {
            switch (strtolower($this->_dsn[$this->_dsnKey]['driver'])) {
                case 'mysql':
                    $this->_pdoHandlers[$this->_dsnKey] = new Mysql($this->_dsn[$this->_dsnKey], $this->_cache);
                    break;
                case 'postgresql':
                    break;
                case 'oci'://oracle
                    $this->_pdoHandlers[$this->_dsnKey] = new Oracle($this->_dsn[$this->_dsnKey], $this->_cache);
                    break;
                case 'mssql':
                    break;
            }
        }
        parent::__construct($this->_pdoHandlers[$this->_dsnKey]);
        $this->_dsnKey = 'default'; //每次取到其他数据源之后马上重置为默认
        return $this;
    }

    /**
     * 手动关闭数据库，同时注销
     */
    public final function close() {
        if (isset($this->_pdoHandlers[$this->_dsnKey])) {
            $this->_pdoHandlers[$this->_dsnKey]->close();
            $this->_pdoHandlers[$this->_dsnKey] = null;
            unset($this->_pdoHandlers[$this->_dsnKey]);
        }
    }

}
