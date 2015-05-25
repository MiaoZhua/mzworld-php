<?php

namespace Admin\Interceptor;

if (!defined('IN_PX'))
    exit;

use Phoenix\IInterceptor;

/**
 * 拦截创建config
 */
class CreateConfig implements IInterceptor {

    private function __Inject($db) {}

    public function preHandle(Array & $context) {
        if (strcasecmp($context['__VC__'], $context['__CI__']) == 0 && $context['__CM__'] == '/') {
            header("Location: http://{$_SERVER['HTTP_HOST']}{$context['__ROOT__']}{$context['__VC__']}/system/welcome");
            exit;
        }
        if (!is_file(ROOT_PATH . $context['__ROUTE_CONFIG__']['bundles']['cfg'])) {
            $this->_createConfigCache($context['__ROUTE_CONFIG__']['bundles']['cfg']);
        }
    }

    /**
     * 若全局配置不存在则生成一份
     * @return type
     */
    private function _createConfigCache(& $path) {
        $_config = "<?php\n";
        $_config .= "if(!defined('IN_PX')) exit;\n";
        $_config .= "return array(\n";
        $_aryConfig = array();
        $_rs = $this->db->nonCacheable()->select('`field_name`, `synopsis`')
            ->table('`#@__@sys_setting`')
            ->order('`setting_id`', 'ASC')
            ->findAll();
        foreach ($_rs as $m) {
            if (strcasecmp('root', $m->field_name) != 0 || strcasecmp('domain', $m->field_name) != 0) {
                $_aryConfig[$m->field_name] = $m->synopsis;
                $_config .= "   '{$m->field_name}' => '";
                $_config .= preg_replace('/\n/i', '', nl2br(\Tools\Html::getTextToHtml($m->synopsis)));
                $_config .= "',\n";
            }
        }
        $_config .= "   'softCore' => 'core:Phoenix(PHP)',\n";
        $_config .= "   'softName' => 'px',\n";
        $_config .= "   'strCompanyName' => 'px',\n";
        $_config .= "   'author' => ''\n";
        $_config .= ");";
        file_put_contents($path, $_config);
        return $_aryConfig;
    }

    public function postHandle(Array & $context) {}

    public function afterCompletion(Array & $context) {}

}
