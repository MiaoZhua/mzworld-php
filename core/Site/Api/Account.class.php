<?php

namespace Site\Api;

if (!defined('IN_PX'))
    exit;

use Phoenix\RequestMethod;
use Site\AbstractCommon;
use Tools\MsgHelper;
use Tools\Auxi;
use Model;
use Tools\Log4p as logger;

/**
 * Class User
 * @package Site\Api
 */
class Account extends AbstractCommon {

    private function __RestController() {}

    private function __Value($cfg) {}

    private function __Method($value = RequestMethod::POST) {}

    protected function __Inject(Model\User $user) {}

    /**
     * 注册
     * @return array|null
     */
    public function register() {

        $_tmpNick = preg_replace('/[\x{4e00}-\x{9fa5}]/u', '**', $_POST['nickname']);
        $_r = null;
//        if (Auxi::chkBadwords($context['nick_name'])) {
//            $_return = MsgHelper::aryJson('IS_BADWORD', '昵称含有非法关键字');
//        } else
        if (strlen($_tmpNick) < 4 && strlen($_tmpNick) > 20) {
            $_r = MsgHelper::aryJson('NICK_ERROR', '昵称请保证在4-20位之间');
        } else if (strlen($_POST['opassword']) < 6) {
            $_r = MsgHelper::aryJson('PWD_SHORT', '密码请保证在6位以上');
        } else if (strcmp($_POST['opassword'], $_POST['password']) != 0) {
            $_r = MsgHelper::aryJson('ERROR', '两次密码输入不一致');
        } else if (!Auxi::isValidEmail($_POST['email'])) {
            $_r = MsgHelper::aryJson('EMAIL_ERROR', '邮箱格式不正确');
        } else {
            if (!$this->user->check('nickname', $_POST['nickname'])) {
                $_r = MsgHelper::aryJson('REGISTER_ERROR', '昵称已存在');
            } else if (!$this->user->check('email', $_POST['email'])) {
                $_r = MsgHelper::aryJson('REGISTER_ERROR', '邮箱已存在');
            } else {
                $_r = $this->user->register($_POST);
            }
        }
        return $_r;
    }

    /**
     * @return array
     */
    public function check() {
        $_status = 'ERROR';
        if (!isset($_POST['type']) || !isset($_POST['text'])) {
            $_status = 'DATA_ERROR';
        }
        if ($this->user->check($_POST['type'], $_POST['text'])) {
            $_status = 'SUCCESS';
        } else {
            $_status = 'IS_EXISTS';
        }
        return MsgHelper::aryJson($_status);
    }

    /**
     *
     * @return array
     */
    public function login() {
        if (empty($_POST['nickname']) || empty($_POST['pwd'])) {
            return MsgHelper::aryJson('ERROR', '用户名和密码不能为空');
        }
        return $this->user->login($_POST['nickname'], $_POST['pwd']);
    }

    /**
     *
     * @return array
     */
    public function logout() {
        if ($this->user->logout()) {
            return MsgHelper::aryJson('SUCCESS');
        }
        return MsgHelper::aryJson('ERROR');
    }

    public function sentMail($__Inject = array('\Service\Mail' => '$mailer', '$cache')) {
        if (($_rs = $this->user->getUserIdSalt($_POST['nickname'], $_POST['email']))) {
            $_uuid = Auxi::guid();

            $this->cache->expires(60 * 30)->set($_uuid, json_encode(array(
                'userId' => $_rs->user_id,
                'salt' => $_rs->salt
            )));
            $_url = $this->cfg['base_host'] . '/forgotPassword?uuid=' . $_uuid;
            $_mailContent = <<<EOF
亲爱的用户：<br>
您的密码设置/重设要求已经得到验证。请点击以下链接输入您新的密码：<br>
<a href="{$_url}" target="_blank">{$_url} </a><br>
如果您的email程序不支持链接点击，请将上面的地址拷贝至您的浏览器(例如IE)的地址栏进入喵爪网站。<br>
本链接地址自发送之日起30分钟内有效，逾时请至<a href="http://www.mzworld.cn" target="_blank">喵爪网站（www.mzworld.cn）</a>，点击"忘记密码"，再次获取。<br>
(这是一封自动产生的email，请勿回复。)
EOF;
            if($this->mailer->wrap2SystemMail()
                ->send($_POST['email'], '找回密码', $_mailContent)) {
                return MsgHelper::aryJson('SUCCESS');
            }
            return MsgHelper::aryJson('ERROR');
        }
        return MsgHelper::aryJson('NONE');
    }

    public function forgotPassword($__Inject = array('\Model\User' => '$user', '$cache')) {
        if (!isset($_POST['uuid'])) {
            return MsgHelper::aryJson('NONE');
        }
        if (($_tmp = $this->cache->expires(60 * 30)->get($_POST['uuid']))) {
            $_tmp = json_decode($_tmp, true);
            $this->user->forgotPassword($_tmp['userId'], $_POST['password'], $_tmp['salt']);
            $this->cache->delete($_POST['uuid']);
            return MsgHelper::aryJson('SUCCESS');
        }
        return MsgHelper::aryJson('ERROR');
    }

}
