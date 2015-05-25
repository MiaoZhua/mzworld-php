<?php

namespace Tools;

if (!defined('IN_PX'))
    exit;

class MsgHelper {

    public static final function get($errCode, $arg = '', $break = true) {
        $_errList = array(
            '0x00000001' => '系统级错误',
            '0x00000002' => "{$arg} 包中未匹配任何url规则，请检查路由文件",
            '0x00000003' => "未在路由配置中找到 {$arg}",
            '0x00000004' => "{$arg} 模块包裹类入口数据异常",
            '0x00000005' => "未找到拦截栈 -> {$arg}",
            '0x00000006' => "404 未找到页面文件 -> {$arg}",
            '0x00001001' => "AOP __Around 未执行 proceed() 方法"
        );
        if ($break) {
            header('Content-type: text/html; charset=utf-8');
            die($_errList[$errCode]);
        }
        else {
            echo $_errList[$errCode];
        }
    }

    public static final function json($status, $desc = '', $rsp = null) {
        //header('Content-type: text/plain; charset=utf-8');
        return json_encode(self::aryJson($status, $desc, $rsp));
    }

    public static final function aryJson($status, $desc = '', $rsp = null) {
        $_desc = array(
            'SUCCESS' => $desc,
            'ERROR' => $desc,
            'INTERCEPTOR' => '未通过拦截器验证',
            'VALIDCODE_ERROR' => '您输入的验证码和系统产生的不一致',
            'VALIDCODE_LOSE' => '请刷新页面重新生成验证码',
            'VALIDCODE_EMPTY' => '验证码不能为空',
            'SESSION_IS_NULL' => '会话状态丢失',
            'USER_EMPTY' => '用户名不能为空',
            'PASS_EMPTY' => '密码不能为空',
            'PASSWORD_ERROR' => '用户名或密码错误',
            'NO_CHANGES' => '未做任何改变',
            'POWER_ERROR' => '您未有访问此资源的权限',
            'DB_ERROR' => '数据库出错',
            'NEED' => '此项无法删除',
            'IS_EXISTS' => '已存在！请重新输入',
            'DB_DELETE_ERR' => "从数据库删除 {$desc} 时出错",
            'SYS_BUSY' => '系统繁忙'
        );
        return array(
            'status' => $status,
            'desc' => isset($_desc[$status]) ? $_desc[$status] : $desc,
            'rsp' => $rsp
        );
    }

}
