<?php

namespace Handler\Admin\Setting\Area;

if (!defined('IN_PX'))
    exit;

use Handler\Admin;

/**
 * 删除
 */
class Delete extends Admin\AbstractCommon {

    public function processRequest(Array & $context) {
        $_aryIds = explode(',', $_POST['id']);
        $_delAry = array('aryLetterCityIdMapping', 'dropCityView');
        $_cacheName = '';
        foreach ($_aryIds as $_id) {
            $_cacheName = 'aryCityStreetDataView'
                    . intval($this->db->field('`root_id`')
                                    ->table('`#@__@area`')
                                    ->where('`area_id` = ?')
                                    ->bind(array($_id))
                                    ->find());
            if (!in_array($_cacheName, $_delAry)) {
                array_push($_delAry, $_cacheName);
            }
        }
        $this->cache->delete($_delAry);
        echo($this->_publicDeleteFieldByPostItem($_POST['id'], '`#@__@area`', 'area_id'));
    }

}
