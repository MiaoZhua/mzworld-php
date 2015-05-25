<?php

namespace Model;

if (!defined('IN_PX'))
    exit;

use Service\UPFile;
use Tools\Log4p as logger;


class UserAvatar {

    private function __Model() {}

    private function __Value($__CDN__) {}

    private function __Inject($db, MaterialAvatar $materialAvatar, UPFile $upFile) {}

    public function save(Array $avatar) {

//        $avatar['user_avatar_id'] = $this->db->sequence64('global');
//        $avatar['user_id'] = $userId;

        $_avatarJson = array(
//            'id' => $userId,
//            'nickname' => $nickname,
            'body' => array(
                'front' => ''
            ),
            'hair' => array(
                'front' => '',
                'left' => '',
                'right' => ''
            ),
            'face' => array(
                'front' => ''
            ),
            'clothes' => array(
                'front' => '',
                'rear' => ''
            ),
            'front' => '',
            'rear' => '',
            'idIndex' => array(
                'body' => '',
                'hair' => '',
                'face' => '',
                'clothes' => ''
            ),
            'userAvatarId' => $avatar['user_avatar_id'],
            'cdn' => $this->__CDN__
        );

        $_rs = $this->materialAvatar->find($avatar['body']);
        $_avatarJson['body']['front'] = $_rs->src_front;
        $_avatarJson['idIndex']['body'] = $_rs->material_avatar_id;

        $_rs = $this->materialAvatar->find($avatar['hair']);
        $_avatarJson['hair']['front'] = $_rs->src_front;
        $_avatarJson['hair']['left'] = $_rs->src_left;
        $_avatarJson['hair']['right'] = $_rs->src_right;
        $_avatarJson['idIndex']['hair'] = $_rs->material_avatar_id;

        $_rs = $this->materialAvatar->find($avatar['face']);
        $_avatarJson['face']['front'] = $_rs->src_front;
        $_avatarJson['idIndex']['face'] = $_rs->material_avatar_id;

        $_rs = $this->materialAvatar->find($avatar['clothes']);
        $_avatarJson['clothes']['front'] = $_rs->src_front;
        $_avatarJson['clothes']['rear'] = $_rs->src_rear;
        $_avatarJson['idIndex']['clothes'] = $_rs->material_avatar_id;

        $this->upFile->deleteMerge($avatar['user_id']);

        if ($this->upFile->imageMerge(array(
                $_avatarJson['body']['front'],
                $_avatarJson['hair']['front'],
                $_avatarJson['face']['front'],
                $_avatarJson['clothes']['front']
            ), $avatar['user_id'], 'avatar_front.png')
            && $this->upFile->imageMerge(array(
                $_avatarJson['body']['front'],
                $_avatarJson['hair']['front'],
                $_avatarJson['clothes']['rear']
            ), $avatar['user_id'], 'avatar_rear.png')
            && $this->upFile->avatarIntact($avatar['user_id'])
        ) {
            $_avatarJson['front'] = 'avatar_front.png';
            $_avatarJson['rear'] = 'avatar_rear.png';
            $_json = json_encode($_avatarJson);

            if (isset($avatar['edit'])) {
                $this->db->table('`#@__@user_avatar`')
                    ->row(array(
                        '`body`' => '?',
                        '`hair`' => '?',
                        '`face`' => '?',
                        '`clothes`' => '?'
                    ))
                    ->where('`user_avatar_id` = ?')
                    ->bind($avatar)
                    ->update();


                $this->db->table('`#@__@user_avatar_cache`')
                    ->row(array(
                        '`json`' => '?'
                    ))
                    ->where('`user_avatar_id` = ?')
                    ->bind(array(
                        $_json,
                        $avatar['user_avatar_id']
                    ))
                    ->update();
            } else {
                $this->db->table('`#@__@user_avatar`')
                    ->row(array(
                        '`user_avatar_id`' => '?',
                        '`user_id`' => '?',
                        '`body`' => '?',
                        '`hair`' => '?',
                        '`face`' => '?',
                        '`clothes`' => '?',
                        '`avatar_front`' => '?',
                        '`avatar_rear`' => '?'
                    ))
                    ->bind($avatar)
                    ->save();

                $this->db->table('`#@__@user_avatar_cache`')
                    ->row(array(
                        '`user_avatar_id`' => '?',
                        '`json`' => '?'
                    ))
                    ->bind(array(
                        $avatar['user_avatar_id'],
                        $_json
                    ))
                    ->save();
            }

            return $_json;
        }
        return false;
    }

    /**
     * 获取到avatar缓存
     * @param $userAvatarId
     * @return mixed
     */
    public function field($userAvatarId) {
//        $this->db->debug();
        return $this->db->field('`json`')
            ->table('`#@__@user_avatar_cache`')
            ->where('`user_avatar_id` = ?')
            ->bind(array($userAvatarId))->find();
    }

}
