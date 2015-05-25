<?php

if (!defined('IN_PX'))
    exit;
/**
 * 后台访问的路由配置
 * 本地缓存
 */
return array(
    //定义拦截器
    'interceptor' => array(
        'needLogin' => '\Site\Interceptor\Login',
        'setPageTitle' => '\Site\Interceptor\SetPageTitle'
    ),
    //拦截器堆栈
    'stack' => array(
        'default' => array(
            'needLogin' => array(
//                'excludeRoute' => array(
//
//                ),
                'includeRoute' => array(
                    'account', 'account/**', 'api/account/**'
                )
            ),
            'setPageTitle' => array(
                'excludeRoute' => array(
                    'api/**'
                ),
                'includeRoute' => array(
                    '/**'
                )
            )
        )
    ),
    //全局拦截器
    'ref' => 'default',
    'returnParamKey' => 'url', //返回url的关键字，如：url=... 或者 returnUrl=...
    'redirect' => '',
    'anchor' => '#login'
);
