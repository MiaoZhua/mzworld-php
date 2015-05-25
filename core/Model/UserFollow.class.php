<?php

namespace Model;

if (!defined('IN_PX'))
    exit;

use Tools\Log4p as logger;


class UserFollow {

    private function __Model() {}

    private function __Inject($db, $session) {}

    public function friend($limit = 10) {
        return $this->db->select('u.`user_id`, u.`nickname`')
            ->table('`#@__@user_follow` uf')
            ->inner('`#@__@user` u', 'uf.`follow_user_id` = u.`user_id`')
            ->where('uf.`user_id` = ? AND uf.`is_friend` = 1 AND u.`is_status` = 5')
            ->bind(array(
                $this->session->user['id']
            ))->limit($limit)->order('uf.`add_date`')->findAll();
    }

    /**
     * 读取我关注的或关注我的
     * @param int $limit
     * @param string $iFollowOrFollowMe
     * @return mixed
     */
    public function findAll($limit = 100, $iFollowOrFollowMe = 'user_id') {
        $_inner = 'follow_user_id';
        if (strcmp('follow_user_id', $iFollowOrFollowMe) == 0) {
            $_inner = 'user_id';
        }
        return $this->db->select('uf.`is_friend`, u.`user_id`, u.`nickname`')
            ->table('`#@__@user_follow` uf')
            ->inner('`#@__@user` u', "uf.`{$_inner}` = u.`user_id`")
            ->where("uf.`{$iFollowOrFollowMe}` = ? AND u.`is_status` = 5")
            ->bind(array(
                $this->session->user['id']
            ))->limit($limit)->order('uf.`add_date`')->findAll();
    }

    public function count($iFollowOrFollowMe = 'user_id', $isFriend = false) {
        return $this->db->table('`#@__@user_follow`')
            ->where("`{$iFollowOrFollowMe}` = ?" . ($isFriend ? ' AND `is_friend` = 1' : ''))
            ->bind(array(
                $this->session->user['id']
            ))->count();
    }

    /**
     * 查看对方是否已关注我
     * @param $userId
     * @return mixed
     */
    public function followMe($userId) {
        return $this->db->table('`#@__@user_follow`')
            ->where('`user_id` = ? AND `follow_user_id` = ?')
            ->bind(array($userId, $this->session->user['id']))->exists();
    }

    /**
     * 是否已关注对方
     * @param $userId
     * @return mixed
     */
    public function followed($userId) {
        return $this->db->table('`#@__@user_follow`')
            ->where('`user_id` = ? AND `follow_user_id` = ?')
            ->bind(array($this->session->user['id'], $userId))->exists();
    }

    public function follow($followUserId) {
        if (intval($followUserId) == intval($this->session->user['id'])) {
            return false;
        }
        try {
            $this->db->beginTransaction();

            $_row = array(
                '`user_id`' => '?',
                '`follow_user_id`' => '?',
                '`is_friend`' => '1',
                '`add_date`' => '?'
            );
            $_bind = array(
                $this->session->user['id'],
                $followUserId,
                time()
            );
            $_userFollowMe = false;//对方未关注
            if (!$this->followMe($followUserId)) {//对方未关注
                //关注对方，但不是好友
                unset($_row['`is_friend`']);
            } else {//对方已关注
                $_userFollowMe = true;
            }
            $this->db->table('`#@__@user_follow`')
                ->row($_row)
                ->bind($_bind)
                ->save();

            if ($_userFollowMe) {//双向关注
                $this->db->table('`#@__@user_follow`')
                    ->row(array(
                        '`is_friend`' => '1'
                    ))
                    ->where('`user_id` = ? AND `follow_user_id` = ?')
                    ->bind(array(
                        $followUserId,
                        $this->session->user['id']
                    ))
                    ->update();
            }

            $this->_updateFollowAndFriendCount($this->session->user['id'], $followUserId);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function remove($userId) {
        if (intval($userId) == intval($this->session->user['id'])) {
            return false;
        }
        try {
            $this->db->beginTransaction();

            $_userFollowMe = false;//对方未关注
            if ($this->followMe($userId)) {//对方已关注
                $_userFollowMe = true;
            }

            $this->db->table('`#@__@user_follow`')
                ->where('`user_id` = ? AND `follow_user_id` = ?')
                ->bind(array(
                    $this->session->user['id'],
                    $userId
                ))
                ->delete();

            if ($_userFollowMe) {//对方已关注
                $this->db->table('`#@__@user_follow`')
                    ->row(array(
                        '`is_friend`' => '0'
                    ))
                    ->where('`user_id` = ? AND `follow_user_id` = ?')
                    ->bind(array(
                        $userId,
                        $this->session->user['id']
                    ))
                    ->update();
            }

            $this->_updateFollowAndFriendCount($this->session->user['id'], $userId);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    private function _updateFollowAndFriendCount($me, $follow) {
        //更新对方的粉丝及好友数量
        $this->db->table('`#@__@user`')
            ->row(array(
                '`follow_count`' => '(SELECT COUNT(*) FROM `#@__@user_follow` WHERE `follow_user_id` = ?)',
                '`friend_count`' => '(SELECT COUNT(*) FROM `#@__@user_follow` WHERE `user_id` = ? AND `is_friend` = 1)'
            ))
            ->where('`user_id` = ?')
            ->bind(array(
                $follow,
                $follow,
                $follow
            ))
            ->update();
        //更新自己的粉丝及好友数量
        $this->db->table('`#@__@user`')
            ->row(array(
                '`follow_count`' => '(SELECT COUNT(*) FROM `#@__@user_follow` WHERE `follow_user_id` = ?)',
                '`friend_count`' => '(SELECT COUNT(*) FROM `#@__@user_follow` WHERE `user_id` = ? AND `is_friend` = 1)'
            ))
            ->where('`user_id` = ?')
            ->bind(array(
                $me,
                $me,
                $me
            ))
            ->update();
    }

}
