<?php

namespace Handler\Admin\Setting\Area;

if (!defined('IN_PX'))
    exit;

use Handler\Admin;

/**
 * 添加
 */
class Add extends Admin\AbstractCommon {

    public function processRequest(Array & $context) {
        $this->_pushSetting();
        $this->_getIdTree('area', 'area_id');

        $_POST['area_name'] = \Tools\Html::getTextToHtml($_POST['area_name']);
        $_POST['area_type_id'] = isset($_POST['area_type_id']) ? intval($_POST['area_type_id']) : 0;
        $_POST['letter_index'] = $_POST['letter_index'] ?
                strtolower(str_replace(' ', '', $_POST['letter_index'])) :
                '';
        $_POST['level'] = $_POST['level'] + 1;
        $_POST['master_id'] = $this->session->adminUser['id'];
        $_POST['add_date'] = time();

//        $this->db->debug();
        $_identity = $this->db->table('`#@__@area`')
                ->row(array(
                    '`area_name`' => '?',
                    '`area_type_id`' => '?',
                    '`letter_index`' => '?',
                    '`first_letter`' => '?',
                    '`level`' => '?',
                    '`id_tree`' => '?',
                    '`parent_id`' => '?',
                    // '`root_id`' => '?',
                    '`sort`' => '?',
                    // '`is_display`' => '?',
                    '`master_id`' => '?',
                    '`add_date`' => '?'
                ))
                ->bind($_POST)
                ->save();

        if ($_POST['level'] == 1)
            $_POST['root_id'] = $_identity;

        $this->db->debug();
        $_return = $this->db->table('`#@__@area`')
                ->row(array(
                    '`root_id`' => '?',
                    '`id_tree`' => '?'
                ))
                ->where('area_id = ?')
                ->bind(array(
                    $_POST['root_id'],
                    $_POST['id_tree'] . str_pad($_identity, 4, '0', STR_PAD_LEFT) . '.',
                    $_identity
                ))
                ->update();


        $this->cache->delete(array('aryLetterCityIdMapping', 'dropCityView', 'aryLocalCityDataView'));

        echo(\Tools\MsgHelper::json($_return ? 'SUCCESS' : 'DB_ERROR'));
    }

}
