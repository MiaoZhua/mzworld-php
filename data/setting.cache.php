<?php

if (!defined('IN_PX'))
    exit;
return array(
    'aryPicExtName' => array('gif', 'jpg', 'jpeg', 'bmp', 'png'),
    'aryFileExtName' => array('mp4', 'flv', 'zip', 'rar', 'doc', 'docx', 'sb2', 'sb', 'ppt', 'pptx', 'pdf'),
    'aryUploadPath' => array('pics', 'files'),
    'aryBool' => array('否', '是'),
    'arySex' => array('女', '男', '保密'),
    'aryAnchorStatus' => array('不使用', '使用'),
    'aryFooterLinkTarget' => array('_blank', '_self'),
    'aryFooterLinkType' => array('当前页', '全站'),
    'aryNavType' => array('主导航', '副导航', '跟随上级'),
    'aryDisplay' => array('不显示', '显示'),
    'aryGoodsDisplay' => array('下架', '上架'),
    'aryPart' => array('列表栏目(允许在本栏目发布文档)', '单页栏目(生成单页，可使用seo及高级功能)', '外部链接(在"文件保存目录"处填写网址)'),
    'aryPartShow' => array('列表栏目', '单页栏目', '外部链接'),
    'aryScope' => array('add' => '添加', 'edit' => '修改', 'delete' => '删除', 'view' => '查看', 'approved' => '审核'),
    'aryChannelTypeMapping' => array(
        'zh-CN' => array(
            // 内容模型名称，内容模型相对路径，列表显示的分页信息数量，列表页若存在列表用于显示详细信息的路径(不存在可为空)
            0 => array('列表', 'list', 20, 'detail'),
            1 => array('通栏', 'horizontal', 20, 'detail'),
            9 => array('图片', 'pro', 6, 'detail')
        )
    ),
    'aryArticleDeleteCacheBindId' => array(
//		'cacheIndexNotice',
//		'cacheIndexArticleList',
//		'cacheIndexMedicalEquipment'
    ),
    'aryShopDeleteCacheBindId' => array(
        'cacheHomepageLatestShop',
    ),
    'aryAreaType' => array(
        '直辖市',
        '华北地区',
        '东北地区',
        '华东地区',
        '华中地区',
        '华南地区',
        '西北地区',
        '西南地区',
        '其他地区'
    ),
    'aryMunicipality' => array(
        '0' => '全国',
        '1' => '上海',
        '2' => '北京',
        '3' => '天津',
        '4' => '重庆'
    ),
    'aryArticleStatus' => array(
        '普通',
        '最新',
        '热门',
        '推荐'
    ),
//    'aryParts' => array(
//        'hair' => '发式',
//        'eyes_mouth' => '眼睛嘴巴',
//        'clothes' => '衣服'
//    ),
    'aryParts' => array(
        '身体',
        '发式',
        '眼睛嘴巴',
        '衣服'
    ),
    'aryStageType' => array(
        '初级',
        '中级',
        '高级'
    ),
    'aryRole' => array(
        '学生',
        '老师',
        '家长'
    ),
    'aryIdentity' => array(
        '学生',
        '老师',
        '家长'
    ),
    'aryLevel' => array(
        'vip1',
        'vip2',
        'vip3'
    ),
    'aryMaterial' => array(
        '正面',
        '背面',
        '左侧',
        '右侧'
    ),
    'aryOpusType' => array(
        '游戏',
        '动画',
        '音乐',
        '美术'
    ),
    'aryStatus' => array(
        0 => '审核',
        1 => '未通过',
        2 => '冻结',
        3 => '删除',
        5 => '正常'
    ),
    'aryGoodsStatus' => array(
        '普通',
        '新品',
        '特价',
        '热卖',
        '人气'
    ),
    'aryAd' => array(
        '首页切换图 1260*376px',
        '首页右侧 229*400'
    )
);
