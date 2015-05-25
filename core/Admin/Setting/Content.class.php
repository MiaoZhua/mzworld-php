<?php

namespace Admin\Setting;

if (!defined('IN_PX'))
    exit;

use Admin\AbstractCommon;

/**
 * 站点配置
 */
class Content extends AbstractCommon {

    private function __Controller() {}

    private function __RequestMapping($value = '/setting') {}

    protected function __Inject($db, $session) {}

    public function areaContent() {
        if ($this->_boolCanReadData()) {
            $this->rs = $this->db->select()
                ->table('`#@__@area`')
                ->where('`area_id` = ?')
                ->bind(array($_GET['id']))
                ->find();
        }
        if (!isset($_GET['parentId']))
            $_GET['parentId'] = null;
        $this->sltIDTree = $this->_selectIDTree(array('table' => '`#@__@area`'),
            array('value' => 'area_id', 'text' => 'area_name',
                'selected' => $this->rs ? $this->rs->parent_id : $_GET['parentId']),
            array('id' => 'area_id',
                'disabled' => $this->pageControl),
            array('选择城市' => '0'));

        if (!isset($_GET['id']))
            $_GET['id'] = 0;

        $this->getSort = $this->_getSort('area');
        return true;
    }

    public function tagContent() {
        if ($this->_boolCanReadData()) {
            $this->rs = $this->db->select()
                ->table('`#@__@opus_tag`')
                ->where('`tag_id` = ?')
                ->bind(array($_GET['id']))
                ->find();
        }
        return true;
    }

    public function badWordContent() {
        if ($this->_boolCanReadData()) {
            $this->rs = $this->db->select()
                ->table('`#@__@bad_word`')
                ->where('`bw_id` = ?')
                ->bind(array($_GET['id']))
                ->find();
        }
        return true;
    }

    public function userContent() {
        if ($this->_boolCanReadData()) {
            $this->rs = $this->db->select()
                ->table('`#@__@manager_user`')
                ->where('`user_id` = ?')
                ->bind(array($_GET['id']))
                ->find();
        }
        if (!isset($_GET['id'])) {
            $_GET['id'] = 0;
        }
        $this->userRole = intval($_GET['id']) == 1 ? '系统默认超级管理员，无法修改角色' :
            $this->_getManagerRoleId($this->rs ? $this->rs->role_id : 0);
        $this->disabled = '';
        if (intval($this->session->adminUser['id']) != 1 && intval($_GET['id']) == 1)
            $this->disabled = ' disabled="disabled"';

        return true;
    }

    public function roleContent() {
        $this->setPower = '\'\'';
        if ($this->_boolCanReadData()) {
            $this->rs = $this->db->select()
                ->table('`#@__@manager_role`')
                ->where('`role_id` = ?')
                ->bind(array($_GET['id']))
                ->find();

            $this->setPower = $this->rs->role_power_value;
        }
        if (!isset($_GET['id'])) {
            $_GET['id'] = 0;
        }
        return true;
    }

    public function content() {
        $this->rs = $this->db->select()
            ->table('`#@__@sys_setting`')
            ->where('`group_id` = 1')
            ->order('setting_id', 'ASC')
            ->findAll();
        return true;
    }

}
