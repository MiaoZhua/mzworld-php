<?php

namespace Handler\Admin\Article\Create;

if (!defined('IN_PX'))
    exit;

use Phoenix\IHttpHandler;
use Service\Templates;
use Tools\File;
use Tools\MsgHelper;

/**
 * 文章生成
 */
class Action implements IHttpHandler {

    private function __Handler() {}

    protected function __Value($cfg) {}

    private function __Inject($db, $session, Templates $toolsTemplates) {}

    public function processRequest(Array & $context) {
        if (!isset($_POST['createInfo']) || intval($this->cfg['is_html_page']) == 0) {
            //运行的类型-当前步进-运行了几次-总数-一次多少条
            $_POST['createInfo'] = '3-3-0-0-100';
        }
        //动态文件删除index.html同时copy page.php为index.php
        if (intval($this->cfg['is_html_page']) == 0) {
            File::delete('index.html', ROOT_PATH);
            if (!File::exists('index.php', ROOT_PATH)) {
                File::write('index.php', File::fetch('server.php', ROOT_PATH), LOCK_EX, ROOT_PATH);
            }
        } else {
            File::delete('index.php', ROOT_PATH); //静态文件删除index.php
        }

        echo(MsgHelper::json('SUCCESS', $this->toolsTemplates->createByStep()));
    }

}
