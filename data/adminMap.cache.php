<?php

if (!defined('IN_PX'))
    exit;

return array(
    'article' => array(
        'title' => '新闻',
        'menu' => array(
            'alist' => array(
                'name' => '新闻管理', 'scope' => array('view', 'add', 'edit', 'delete'),
                'class' => 'ico_list'
            ),
            'type' => array(
                'name' => '新闻栏目管理', 'scope' => array('view', 'add', 'edit', 'delete'),
                'class' => 'ico_type'
            ),
            'footerLink' => array(
                'name' => '友情链接管理', 'scope' => array('view', 'add', 'edit', 'delete'),
                'class' => 'ico_link'
            ),
            'ad' => array(
                'name' => '图片广告管理', 'scope' => array('view', 'add', 'edit', 'delete'),
                'class' => 'ico_ad'
            )
        )
    ),
    'opus' => array(
        'title' => '作品',
        'menu' => array(
//            'opusType' => array(
//                'name' => '作品分类', 'scope' => array('view', 'add', 'edit', 'delete')
//            ),
            'opList' => array(
                'name' => '作品列表', 'scope' => array('view', 'edit')
            ),
            'comment' => array(
                'name' => '作品评论', 'scope' => array('view', 'edit')
            )
        )
    ),
    'tutorial' => array(
        'title' => '微课',
        'menu' => array(
            'tutor' => array(
                'name' => '微课单元列表', 'scope' => array('view', 'add', 'edit', 'delete')
            ),
            'chapter' => array(
                'name' => '微课章节管理', 'scope' => array('view', 'add', 'edit', 'delete')
            ),
            'qa' => array(
                'name' => 'QA管理', 'scope' => array('view', 'add', 'edit', 'delete')
            )
        )
    ),
    'users' => array(
        'title' => '用户',
        'menu' => array(
            'userList' => array(
                'name' => '注册用户', 'scope' => array('view', 'edit', 'delete')
            )
        )
    ),
    'material' => array(
        'title' => '素材库',
        'menu' => array(
            'avatar' => array(
                'name' => '形象素材库管理', 'scope' => array('view', 'add', 'edit', 'delete')
            )
        )
    ),
    'setting' => array(
        'title' => '系统',
        'menu' => array(
            'area' => array(
                'name' => '省市地区', 'scope' => array('view', 'add', 'edit', 'delete')
            ),
            'tag' => array(
                'name' => '作品标签', 'scope' => array('view', 'add', 'edit', 'delete')
            ),
            'user' => array(
                'name' => '管理员列表', 'scope' => array('view', 'add', 'edit', 'delete'),
                'class' => 'ico_user'
            ),
            'role' => array(
                'name' => '管理角色列表', 'scope' => array('view', 'add', 'edit', 'delete'),
                'class' => 'ico_role'
            ),
            'content' => array(
                'name' => '配置列表', 'scope' => array('edit'), 'class' => 'ico_gear'
            )
        )
    )
);
