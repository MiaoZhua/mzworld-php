<?php

namespace Site;

if (!defined('IN_PX'))
    exit;

use Tools\Log4p as logger;

/**
 * Class Index
 * @package Site
 */
class Index extends AbstractCommon {

    private function __Controller() {}

//    private function __Value($cfg, $setting) {}

//    protected function __Inject($db, UPFile $upFile) {}

    public function index() {
//    public function index($__Bundle = 'Vendors/Import.php', $__Value = '$cfg', $__Inject = array('db')) {
        return true;
    }

    public function avatar() {
        $_intact = ROOT_PATH . DIRECTORY_SEPARATOR . $this->__UPLOAD__ . DIRECTORY_SEPARATOR
            . 'u' . DIRECTORY_SEPARATOR . $_GET['id'] . DIRECTORY_SEPARATOR . 'avatar_intact.png';
        if (is_file($_intact)) {
            header('Content-type: application/octet-stream');
            header('Accept-Ranges: bytes');
            header('Accept-Length: ' . filesize($_intact));
            header('Content-Disposition: attachment; filename=' . $_GET['nickname'] . '-avatar.png');
            readfile($_intact);
            exit;
        } else {
            return 404;
        }
    }

//    public function create($__Inject = array('$db', '\Service\UPFile' => '$upFile')) {
//        $_user = $this->db->select('`user_id`')->table('`#@__@user`')->findAll();
//        foreach ($_user as $_u) {
//            $this->upFile->avatarIntact($_u->user_id);
//        }
//        return 'index';
//    }

}
