<?php

namespace Tools;

if (!defined('IN_PX'))
    exit;

/**
 * Class Log4p
 * @package Tools
 */
class Log4p {

    /**
     * 写入日志
     * @param string $word
     * @param string $path
     * @return bool|string
     */
    public static final function write($word = '', $path = 'log.txt') {
        return File::write($path,
            '执行日期：' . strftime('%Y-%m-%d %H:%M:%S', time())
            . "\n" . print_r($word, true) . "\n",
            FILE_APPEND | LOCK_EX, LOG_PATH);
    }

    /**
     * 开发者调试
     * @param type $word
     * @return type
     */
    public static final function debug($word) {
        return self::write($word, 'debug.txt');
    }

    /**
     * 输出信息，通常是程序自我监控级别
     * @param type $word
     * @return type
     */
    public static final function info($word) {
        return self::write($word, 'info.txt');
    }

    /**
     * 输出警告
     * @param type $word
     * @return type
     */
    public static final function warn($word) {
        return self::write($word, 'warn.txt');
    }

    /**
     * 输入运行期错误
     * @param type $word
     * @return type
     */
    public static final function error($word) {
        return self::write($word, 'error.txt');
    }

    /**
     * 输入致命错误
     * @param type $word
     * @return type
     */
    public static final function fatal($word) {
        return self::write($word, 'fatal.txt');
    }

    /**
     * 删除文件
     * @param type $fileName
     * @return type
     */
    public static final function delete($fileName) {
        return File::delete($fileName, LOG_PATH);
    }

}
