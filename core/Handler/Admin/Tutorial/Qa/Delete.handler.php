<?php

namespace Handler\Admin\Tutorial\Qa;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;
use Tools\MsgHelper;
use Exception;

/**
 * 删除
 * TODO:删除后更新tutorial chapter数量
 */
class Delete extends AbstractCommon {

    public function processRequest(Array & $context) {
        echo($this->_publicDeleteFieldByPostItem($_POST['id'], '`#@__@tutorial_chapter_qa`', 'tcq_id'));
    }

}
