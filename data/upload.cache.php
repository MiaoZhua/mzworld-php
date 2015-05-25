<?php

if (!defined('IN_PX'))
    exit;
//upload上传配置
return array(
    //源图
    'source' => array(
        'width' => 800,
        'height' => 800,
        //上传限制大小 kb
        'limit' => 20480
    ),
    'thumb' => array(
        //生成缩略图
        'create' => true,
        //创建缩略图大小，宽度衡量
        'width' => 200,
        'height' => 200
    ),
    'medium' => array(
        //是否生成中等大小的图片
        'create' => false,
        //创建缩略图大小，宽度衡量
        'width' => 300,
        'height' => 300
    ),
    'mark' => array(
        //生成水印图
        'water' => false,
        //是否生成文字水印，默认关闭，以图片水印效果为佳
        'text' => false,
        //编辑器上传图片生成水印图
        'editor' => false,
        //是否生成中图水印
        'medium' => false,
        //水印源图
        'larger' => 'uploads/largerLogo.png',
        'small' => 'uploads/logo.png',
        //水印位置
        'pos' => 5
    )
);
