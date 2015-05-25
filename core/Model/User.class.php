<?php

namespace Model;

if (!defined('IN_PX'))
    exit;

use Tools\Auxi;
use Tools\MsgHelper;
use Tools\Log4p as logger;


class User {

    private function __Model() {}

    private function __Value($setting) {}

    private function __Inject($db, $session, UserAvatar $userAvatar) {}

    public function password(Array $profile) {
        $_rs = $this->db->select('`salt`, `password`')
            ->table('`#@__@user`')
            ->where('`user_id` = ?')
            ->bind(array($this->session->user['id']))
            ->find();
        if ($_rs) {
            if (strcmp($_rs->password, md5($profile['opassword'] . $_rs->salt)) != 0) {//password error
                return MsgHelper::aryJson('PASSWORD_ERROR', '原密码错误');
            } else {
                $_password = md5($profile['password'] . $_rs->salt);
                //$this->db->debug();
                $this->db->table('`#@__@user`')
                    ->row(array(
                        '`password`' => '?'
                    ))
                    ->where('`user_id` = ?')
                    ->bind(array(
                        $_password,
                        $this->session->user['id']
                    ))
                    ->update();

                return MsgHelper::aryJson('SUCCESS');
            }
        }
        return MsgHelper::aryJson('NOT_EXISTS');
    }

    public function avatar(Array $avatar) {
        try {
            $this->db->beginTransaction();

            if (!isset($avatar['avatar'])) {
                return MsgHelper::aryJson('AVATAR_NONE');
            }
            $_avatar = json_decode($avatar['avatar'], true);
            if (!isset($_avatar['body'])) {
                return MsgHelper::aryJson('AVATAR_ERROR');
            }

            $_tmp = json_decode($this->session->user['avatar'], true);
            $_avatar['user_avatar_id'] = $_tmp['userAvatarId'];

            $_avatar['user_id'] = $this->session->user['id'];
            $_avatar['edit'] = true;
            //保存avatar
            $_json = $this->userAvatar->save($_avatar);

            if (false === $_json) {
                return MsgHelper::aryJson('AVATAR_ERROR', 'avatar生成失败，请稍候再试');
            }

//          $this->db->debug();
            $_user['avatar'] = $_json;
            $this->session->user = $_user;

            $this->db->commit();
            return MsgHelper::aryJson('SUCCESS', null, $_json);
        } catch (Exception $e) {
            $this->db->rollBack();
            return MsgHelper::aryJson('REGISTER_ERROR', '注册失败，请检查您填入的数据');
        }
    }

    public function profile(Array $user) {
        try {
            $this->db->beginTransaction();

            $user['sex'] = isset($user['sex']) ? intval($user['sex']) : 2;
            if (intval($user['birthday-year']) > 0 && intval($user['birthday-year']) > 0
                && intval($user['birthday-year']) > 0) {
                $_birthday = "{$user['birthday-year']}-{$user['birthday-month']}-{$user['birthday-day']}";
                $user['birthday'] = strtotime($_birthday);
            } else {
                $user['birthday'] = 0;
            }
            $user['user_id'] = $this->session->user['id'];

//          $this->db->debug();
            $this->db->table('`#@__@user`')
                ->row(array(
                    '`email`' => '?',
                    '`birthday`' => '?',
                    '`sex`' => '?',
                    '`mobile`' => '?',
                    '`qq`' => '?',
                    '`school_id`' => '?',
                    '`parents_email`' => '?'
                ))
                ->where('`user_id` = ?')
                ->bind($user)
                ->update();

            $this->db->commit();
            return MsgHelper::aryJson('SUCCESS');
        } catch (Exception $e) {
            $this->db->rollBack();
            return MsgHelper::aryJson('REGISTER_ERROR', '注册失败，请检查您填入的数据');
        }
    }

    public function register(Array $user) {
        try {
            $this->db->beginTransaction();

            $_time = time();
            $_userIp = Auxi::getIP();
            $user['user_id'] = $this->db->sequence64('user');
            $user['type'] = isset($user['type']) ? intval($user['type']) : 0;
            $user['reg_ip'] = ip2long($_userIp);
            $user['latest_log_ip'] = $user['reg_ip'];
            $user['salt'] = Auxi::guid();
            $user['password'] = md5($user['password'] . $user['salt']);
            $user['latest_log_time'] = $_time;
            $user['add_date'] = $_time;
            $user['log_count'] = 1;
            $user['sex'] = isset($user['sex']) ? intval($user['sex']) : 2;
            if (intval($user['birthday-year']) > 0 && intval($user['birthday-year']) > 0
                && intval($user['birthday-year']) > 0) {
                $_birthday = "{$user['birthday-year']}-{$user['birthday-month']}-{$user['birthday-day']}";
                $user['birthday'] = strtotime($_birthday);
            } else {
                $user['birthday'] = 0;
            }

            if (!isset($user['avatar'])) {
                return MsgHelper::aryJson('AVATAR_NONE');
            }
            $_avatar = json_decode($user['avatar'], true);
            if (!isset($_avatar['body'])) {
                return MsgHelper::aryJson('AVATAR_ERROR');
            }
            $user['user_avatar_id'] = $this->db->sequence64('global');
            $_avatar['user_avatar_id'] = $user['user_avatar_id'];
            $_avatar['user_id'] = $user['user_id'];
            //保存avatar
            $_json = $this->userAvatar->save($_avatar);

            if (false === $_json) {
                return MsgHelper::aryJson('AVATAR_ERROR', 'avatar生成失败，请稍候再试');
            }

//            $this->db->debug();
            $this->db->table('`#@__@user`')
                ->row(array(
                    '`user_id`' => '?',
                    '`email`' => '?',
                    '`nickname`' => '?',
                    '`password`' => '?',
                    '`salt`' => '?',
                    '`birthday`' => '?',
                    '`sex`' => '?',
                    '`mobile`' => '?',
                    '`qq`' => '?',
                    '`school_id`' => '?',
                    '`parents_email`' => '?',
                    '`user_avatar_id`' => '?',
                    '`latest_log_time`' => '?',
                    '`log_count`' => '?',
                    '`latest_log_ip`' => '?',
                    '`reg_ip`' => '?',
                    '`add_date`' => '?'
                ))
                ->bind($user)
                ->save();

            $this->session->user = array(
                'id' => $user['user_id'],
                'nickname' => $user['nickname'],
//                'level' => 1,
                'sex' => $user['sex'],
                'logCount' => 1,
                'latestLogTime' => Auxi::getShortTime($_time),
                'latestLogIp' => $_userIp,
                'avatar' => $_json
            );

            $this->db->commit();
            return MsgHelper::aryJson('SUCCESS');
        } catch (Exception $e) {
            $this->db->rollBack();
            return MsgHelper::aryJson('REGISTER_ERROR', '注册失败，请检查您填入的数据');
        }
    }

    public function check($type, $text) {
//        $this->db->debug();
        switch ($type) {
            case 'email' :
            case 'nickname' :
                if (!$this->db->table('`#@__@user`')->where("`{$type}` = ?")->bind(array(
                    $text
                ))->exists()) {
                    return true;
                }
                break;
            default :
                break;
        }
        return false;
    }

    public function login($nickname, $password) {
        $_rs = $this->db->select('`user_id`, `nickname`, `salt`, `password`, `sex`, `level`, `user_avatar_id`, `follow_count`, `friend_count`, `latest_log_time`, `log_count`, `latest_log_ip`, `is_err_lock`, `err_lock_time`, `pwd_err_count`, `is_status`')
            ->table('`#@__@user`')
            ->where('`nickname` = ?')
            ->bind(array($nickname))
            ->find();
        if ($_rs) {
            if (intval($_rs->is_status) < 5) {
                return MsgHelper::aryJson('USER_STATUS_ERROR', '账户已' . $this->setting['aryStatus'][$_rs->is_status]);
            } else if ($_rs->is_err_lock > 0 && time() - $_rs->err_lock_time < 3600) {
                return MsgHelper::aryJson('IS_LOCK', '1小时');
            } else if (strcmp($_rs->password, md5($password . $_rs->salt)) != 0) {//password error
                $_tryCount = 5;
                if ($_rs->pwd_err_count + 1 >= $_tryCount) {
                    $this->db->table('`#@__@user`')
                        ->row(array(
                            '`pwd_err_count`' => '`pwd_err_count` + 1',
                            '`is_err_lock`' => '1',
                            '`err_lock_time`' => '?'
                        ))
                        ->where('`user_id` = ?')
                        ->bind(array(
                            time(), $_rs->user_id
                        ))
                        ->update();
                    return MsgHelper::aryJson('IS_LOCK', '1小时');
                } else {
                    $this->db->table('`#@__@user`')
                        ->row(array(
                            '`pwd_err_count`' => '`pwd_err_count` + 1'
                        ))
                        ->where('`user_id` = ?')
                        ->bind(array(
                            $_rs->user_id
                        ))
                        ->update();
                    return MsgHelper::aryJson('PASSWORD_ERROR', null, $_tryCount - $_rs->pwd_err_count - 1);
                }
            } else {
                //$this->db->debug();
                $this->db->table('`#@__@user`')
                    ->row(array(
                        '`latest_log_time`' => '?',
                        '`log_count`' => '`log_count` + 1',
                        '`latest_log_ip`' => '?',
                        '`pwd_err_count`' => '0',
                        '`is_err_lock`' => '0'
                    ))
                    ->where('`user_id` = ?')
                    ->bind(array(
                        time(),
                        ip2long(Auxi::getIP()),
                        $_rs->user_id
                    ))
                    ->update();

                $_json = array();
                if ($_rs->user_avatar_id > 0) {
                    $_json = $this->userAvatar->field($_rs->user_avatar_id);
                }

                $this->session->user = array(
                    'id' => $_rs->user_id,
                    'nickname' => $_rs->nickname,
//                    'level' => $_rs->level,
                    'sex' => $_rs->sex,
                    'logCount' => $_rs->log_count,
                    'latestLogTime' => Auxi::getShortTime($_rs->latest_log_time),
                    'latestLogIp' => long2ip($_rs->latest_log_ip),
                    'avatar' => $_json
                );

                return MsgHelper::aryJson('SUCCESS');
            }
        }
        return MsgHelper::aryJson('NOT_EXISTS');
    }

    public function logout() {
        $this->session->destory('user');
        return true;
    }

    public function statistics($userId = null) {
        $userId = is_null($userId) ? $this->session->user['id'] : $userId;
        return $this->db->select('`nickname`, `opus_count`, `challenge_count`, `praise_count`, `follow_count`, `friend_count`, `add_date`')
            ->table('#@__@user')
            ->where('`user_id` = ?')
            ->bind(array($userId))->find();
    }

    public function read() {
        $_rs = $this->db->select('`birthday`, `sex`, `mobile`, `qq`, `school_id`, `parents_email`')
            ->table('#@__@user')
            ->where('`user_id` = ?')
            ->bind(array($this->session->user['id']))->find();
        $_rs->year = date('Y', $_rs->birthday);
        $_rs->month = date('n', $_rs->birthday);
        $_rs->day = date('j', $_rs->birthday);
        return $_rs;
    }

    public function getUserIdSalt($nickname, $email) {
        return $this->db->select('`user_id`, `salt`')
            ->table('#@__@user')
            ->where('`nickname` = ? AND `email` = ?')
            ->bind(array($nickname, $email))->find();
    }

    public function forgotPassword($userId, $password, $salt) {
        //$this->db->debug();
        $this->db->table('`#@__@user`')
            ->row(array(
                '`password`' => '?'
            ))
            ->where('`user_id` = ?')
            ->bind(array(
                md5($password . $salt),
                $userId
            ))
            ->update();

        return true;
    }

}
