<?php

namespace PXPDO;

if (!defined('IN_PX'))
    exit;

use MongoClient;

class Mongo {

    //持久层 value 别名 $value = ''
    //TODO
    private function __Repository() {}

    private function __Value($dsn) {}

    private $_mongoHandler = null;
    private $_dbHandler = null;
    private $_collections = array();

    public function db() {
        if ($this->_lazyInit()) {
            return $this->_dbHandler;
        }
        return false;
    }

    public function collections($_collections) {
        if (!isset($this->_collections[$_collections])) {
            if (false !== $this->_lazyInit()) {
                $_preCollections = $this->dsn['mongo']['prefix'] . $_collections;
                $this->_collections[$_collections] = $this->_dbHandler->$_preCollections;
            } else {
                return false;
            }
        }
        return $this->_collections[$_collections];
    }

    private function _lazyInit() {
        if (is_null($this->_mongoHandler)) {
            $_dsn = 'mongodb://'
                . "{$this->dsn['mongo']['user']}:{$this->dsn['mongo']['user']}"
                . "@{$this->dsn['mongo']['host']}:{$this->dsn['mongo']['port']}";
            if ($this->dsn['mongo']['auth']) {
                $_dsn .= "/{$this->dsn['mongo']['dbName']}";
            }
            $this->_mongoHandler = new MongoClient($_dsn);
            $this->_dbHandler = $this->_mongoHandler->{$this->dsn['mongo']['dbName']};
            return true;
        }
        return false;
    }

}
