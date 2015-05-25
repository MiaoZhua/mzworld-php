<?php

namespace Handler\Admin\System;

if (!defined('IN_PX'))
    exit;

use Phoenix\IHttpHandler;
use Service\UPFile;
use Tools\MsgHelper;

/**
 * DelMultipleFile
 */
class DelMultipleFile implements IHttpHandler {

    private function __Handler() {}

    private function __Inject($db) {}

    public function processRequest(Array & $context) {
        if (isset($_POST['delImgSrc']) &&
            $this->upFile->deleteFile($_POST['delImgSrc'])) {
            $this->db->table('`#@__@goods_images`')
                ->where('`src` = ?')->bind(array($_POST['delImgSrc']))
                ->delete();
            echo(MsgHelper::json('SUCCESS'));
        } else {
            echo(MsgHelper::json('ERROR'));
        }
    }

}
