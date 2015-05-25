<?php

namespace Site\Api\Account;

if (!defined('IN_PX'))
    exit;

use Phoenix\RequestMethod;
use Site\AbstractCommon;
use Service\UPFile;
use Tools\MsgHelper;
use Model;
use Tools\Log4p as logger;

class Opus extends AbstractCommon {

    private function __RestController() {}

    private function __RequestMapping($value = '/api/account/opus') {}

    private function __Method($value = RequestMethod::POST) {}

    protected function __Inject($session,Model\Opus $opus,Model\Card $card,UPFile $upFile) {}

    public function upload() {
        $_return = $this->upFile->user($this->session->user['id'], 'opus-file', $_POST['mode']);
        if ($this->upFile->noneErr) {
            return MsgHelper::aryJson('SUCCESS', null, $_return);
        } else {
            return MsgHelper::aryJson('ERROR', $_return);
        }
    }
//    public function read() {
//        return MsgHelper::aryJson('SUCCESS', null, $this->opus->findAll(50));
//    }
    public function read() {
        return MsgHelper::aryJson('SUCCESS', null,
            array( 'opus'=>$this->opus->findAll(50),
                'cards'=>$this->card->find_user_cards(50,$this->session->user['id'])));
    }

    public function save() {
        if (isset($_POST['thumbJson']) && $_POST['thumbJson'] != '') {
            $_thumb = json_decode($_POST['thumbJson'], true);
            if (false !== $this->upFile->createUserFile($_thumb)) {
                $_POST['thumb'] = $_thumb['path'] . '/' . $_thumb['name'];
            }
        }
        if (isset($_POST['sb2SrcJson']) && $_POST['sb2SrcJson'] != '') {
            $_src = json_decode($_POST['sb2SrcJson'], true);
            if (false !== $this->upFile->createUserFile($_src)) {
                $_POST['sb2_src'] = $_src['path'] . '/' . $_src['name'];
                $_POST['sb2_size'] = $_src['size'];
            }
        }

        $_flag = true;
        if (isset($_POST['attach']) && count($_POST['attach']) > 0) {
            foreach ($_POST['attach'] as $_ah) {
                $_ah = json_decode($_ah, true);
                if (isset($_ah['name']) && !isset($_ah['opus_attach_id'])
                    && false === $this->upFile->createUserFile($_ah, false)) {
                    $_flag = false;
                    break;
                }
            }
        }

        if ($_flag) {
            return $this->opus->save($_POST);
        }
        return MsgHelper::aryJson('FILE_ERROR', '文件存储出错或已存在，请稍候再试');
    }
    
    function testtest(){
    	$this->opus->save(array());
    }

    public function remove() {
        if ($this->opus->remove($_POST['opusId'])) {
            return MsgHelper::aryJson('SUCCESS');
        }
        return MsgHelper::aryJson('ERROR');
    }

    public function praise() {
        if ($this->opus->praise($_POST['opusId'])) {
            return MsgHelper::aryJson('SUCCESS');
        }
        return MsgHelper::aryJson('IS_EXISTS');
    }

    public function praiseRemove() {
        if ($this->opus->praiseRemove($_POST['opusId'])) {
            return MsgHelper::aryJson('SUCCESS');
        }
        return MsgHelper::aryJson('ERROR');
    }

}
