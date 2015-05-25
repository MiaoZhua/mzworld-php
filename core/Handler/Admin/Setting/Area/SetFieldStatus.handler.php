<?php

namespace Handler\Admin\Setting\Area;

if (!defined('IN_PX'))
    exit;

use Handler\Admin;

/**
 * 状态
 */
class SetFieldStatus extends Admin\AbstractCommon {

    public function processRequest(Array & $context) {
        $_aryIds = explode(',', $_POST['id']);
        $_delAry = array('aryAreaDataViewProvinceOpt');
        $_cacheName = '';
        foreach ($_aryIds as $_id) {
            $_cacheName = 'aryDataViewCity'
                    . intval($this->db->field('root_id')
                                    ->table('`#@__@area`')
                                    ->where('area_id = ?')
                                    ->bind(array($_id))
                                    ->find());
            array_push($_delAry, $_cacheName);
        }
        $this->cache->delete($_delAry);
        echo($this->_setFieldStatus(explode(',', $_POST['id']),
                '`#@__@area`', $_POST['field'], 'area_id'));
    }

}
