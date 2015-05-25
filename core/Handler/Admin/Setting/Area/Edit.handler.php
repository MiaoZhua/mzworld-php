<?php

namespace Handler\Admin\Setting\Area;

if (!defined('IN_PX'))
    exit;

use Handler\Admin;

/**
 * 修改
 */
class Edit extends Admin\AbstractCommon {

    public function processRequest(Array & $context) {
        $this->_pushSetting();
        $this->_getIdTree('area', 'area_id');

        //$this->db->debug();
        $_POST['area_name'] = \Tools\Html::getTextToHtml($_POST['area_name']);
        $_POST['area_type_id'] = intval($_POST['area_type_id']);
        $_POST['letter_index'] = $_POST['letter_index'] ?
                strtolower(str_replace(' ', '', $_POST['letter_index'])) :
                '';
        $_POST['level'] = $_POST['level'] + 1;
        $_POST['id_tree'] = $_POST['id_tree']
                . str_pad($_POST['id'], 4, '0', STR_PAD_LEFT) . '.';
        $_POST['area_id'] = $_POST['id'];

        //$this->db->debug();
        $_return = $this->db->table('`#@__@area`')
                ->row(array(
                    '`area_name`' => '?',
                    '`area_type_id`' => '?',
                    '`letter_index`' => '?',
                    '`first_letter`' => '?',
                    '`level`' => '?',
                    '`id_tree`' => '?',
                    '`parent_id`' => '?',
                    '`root_id`' => '?',
                    '`sort`' => '?'
                        //, '`is_display`' => '?'
                ))
                ->where('area_id = ?')
                ->bind($_POST)
                ->update();

        $this->cache->delete(array('aryLetterCityIdMapping', 'dropCityView',
            'aryLocalCityDataView'));
        //$this->cache->delete($this->getAttributesCacheName('city_street', $context['root_id']));

        echo(\Tools\MsgHelper::json($_return ?
                        'SUCCESS' :
                        ($_return == 0 ? 'NO_CHANGES' : 'DB_ERROR')
        ));
    }

}
