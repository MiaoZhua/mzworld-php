<?php

namespace Handler\Admin\System;

if (!defined('IN_PX'))
    exit;

use Phoenix\IHttpHandler;
use Service\UPFile;
use Tools\MsgHelper;

/**
 * DelFile
 */
class DelFile implements IHttpHandler {

    private function __Handler() {}

    protected function __Inject(UPFile $upFile) {}

    public function processRequest(Array & $context) {
        if (isset($_POST['delFileName']) && $this->upFile->deleteFile($_POST['delFileName'])) {
            echo(MsgHelper::json('SUCCESS'));
        } else {
            echo(MsgHelper::json('ERROR'));
        }
    }

}
