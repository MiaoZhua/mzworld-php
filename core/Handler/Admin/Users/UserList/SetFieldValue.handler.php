<?php

namespace Handler\Admin\Users\UserList;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;

/**
 * 修改
 */
class SetFieldValue extends AbstractCommon {

    public function processRequest(Array & $context) {
        $_aryId = explode(',', $_POST['id']);
        foreach ($_aryId as $_id) {
//            $this->db->debug();
            $this->db->table('`#@__@opus`')
                ->row(array(
                    '`is_status`' => '?'
                ))
                ->where('`user_id` = ?')
                ->bind(array(
                    $_POST['fieldValue'],
                    $_id
                ))
                ->update();
        }
        echo($this->_setFieldStatus($_aryId,
            '`#@__@user`', $_POST['field'], 'user_id',
            false, $_POST['fieldValue']));
    }

}
