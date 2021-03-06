<?php

namespace Handler\Admin\Setting;

if (!defined('IN_PX'))
    exit;

use Handler\Admin\AbstractCommon;
use Tools\File;
use Tools\Html;
use Tools\MsgHelper;

/**
 * 配置修改
 */
class Action extends AbstractCommon {

    public function processRequest(Array & $context) {
        $_config = "<?php\n";
        $_config .= "if(!defined('IN_PX')) exit;\n";
        $_config .= "return array(\n";
        $_temp = null;
        $_root = null;
        $_domain = null;
        foreach ($_POST as $key => $value) {
            //echo($key . ' ' . $value);
            if (strcasecmp('base_host', $key) == 0) {
                $_temp = 'http://' . $_SERVER['HTTP_HOST'];
                $value = strcasecmp($_temp, $value) != 0 ? $_temp : $value;
            } else if (strcasecmp('img_servers', $key) == 0 && $value != '') {
                $_temp = array();
                $_aryTmp = explode(',', strtolower(str_replace('，', ',', $value)));
                foreach ($_aryTmp as $_server) {
                    if ($_server)
                        array_push($_temp, 'http://' . rtrim(ltrim(trim($_server), 'http://'), '/'));
                }
                $value = implode(',', $_temp);
            }
            $this->db->table('#@__@sys_setting')
                ->row(array(
                    '`synopsis`' => '?'
                ))
                ->where('`field_name` = ?')
                ->bind(array(
                    $value,
                    $key
                ))->update();
            switch ($key) {
                case 'root' :
                    $_root = $value;
                    break;
                case 'domain' :
                    $_domain = $value;
                    break;
                default :
                    $_config .= "	'$key' => '";
                    $value = Html::getTextToHtml($value);
                    $_config .= preg_replace('/\n/i', '', nl2br($value));
                    //$common->db->debug();
                    $_config .= "',\n";
                    break;
            }
        }
        $_config .= "	'softCore' => 'core:Phoenix(PHP)',\n";
        $_config .= "	'softName' => 'dq',\n";
        $_config .= "	'strCompanyName' => 'dq',\n";
        $_config .= "	'author' => ''\n";
        $_config .= ");";
        $_routePath = CORE_PATH . 'route.config.php';
        $_route = file_get_contents($_routePath);
        file_put_contents($_routePath,
            preg_replace(array("/('root'[^']+)'[^']*'/",
                "/('domain'[^']+)'[^']*'/"),
                array("$1'$_root'", "$1'$_domain'"),
                $_route),
            LOCK_EX);

        $return = File::fileWrite(ROOT_PATH . 'data/config.cache.php', $_config);

        echo(MsgHelper::json($return ? 'SUCCESS' : 'DB_ERROR'));
    }

}
