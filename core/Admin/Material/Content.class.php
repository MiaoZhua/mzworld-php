<?php

namespace Admin\Material;

if (!defined('IN_PX'))
    exit;

use Admin\AbstractCommon;

/**
 * 内容页
 */
class Content extends AbstractCommon {

    private function __Controller() {}

    protected function __Inject($db) {}

    public function avatarContent() {
        if ($this->_boolCanReadData()) {
            $this->rs = $this->db->select()
                ->table('`#@__@material_avatar`')
                ->where('`material_avatar_id` = ?')
                ->bind(array($_GET['id']))
                ->find();
        }
        if (!isset($_GET['parentId'])) {
            $_GET['parentId'] = '';
        }
        if (!isset($_GET['level'])) {
            $_GET['level'] = '';
        }
        if (!isset($_GET['id'])) {
            $_GET['id'] = '';
        }
        return true;
    }

}
