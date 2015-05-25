<?php

namespace Service;

if (!defined('IN_PX'))
    exit;

use Phoenix\Controller;
use Tools\Auxi;
use Tools\File;
use Exception;

/**
 * 模板类
 * v1.2.3 修复了静态页分页及若干bug，提升了运行时效率，加入运行时缓存
 * v1.2.4 将列表风格及文章详细分开
 * v1.2.5 修复若干路径bug
 * v1.2.6 统一通过Page类生成，可直接启用动态页
 * v1.3.2 若干bug 2013-5-5
 * v1.3.3 若干bug 2013-10-10 去掉了未用到的\Service\UrlHelper类注入
 * v1.3.4 使用链式sql访问器
 */
class Templates {

    //先声明，后构造器注入，否则在实例化之后注入类实体
    private function __Service() { }

    private function __Value($setting) { }

    private function __Inject($db, $cache, Article $serviceArticle) { }

    const VERSION = '1.3.4';

    private $_mappingChannelType;
    private $_data;
    private $_serviceArticle;

    /**
     * 构造器注入
     * @param array $__InjectData
     * @param $setting
     * @param $cache
     * @param $serviceArticle
     */
    public function __construct(Array & $__InjectData, & $setting, $cache, $serviceArticle) {
        $this->_data = &$__InjectData;
        $this->_data['setting'] = &$setting;
        //删除缓存
        $cache->delete(array('aryArticleTypeDataView', 'footerArticleTypeNavigation'));

        $this->_mappingChannelType = $this->_data['setting']['aryChannelTypeMapping'];

        $this->_data['resetAnchorText'] = isset($_POST['resetAnchorText']) ? intval($_POST['resetAnchorText']) : 0;
        $this->_data['deleteHtmlFolder'] = isset($_POST['deleteHtmlFolder']) ? intval($_POST['deleteHtmlFolder']) : 0;
        $this->_data['createSitemap'] = isset($_POST['createSitemap']) ? intval($_POST['createSitemap']) : 0;
        $this->_data['aryAnchorText'] = $serviceArticle->getAryAnchorText(); //预加载需要清除的链接
        $this->_serviceArticle = $serviceArticle;
    }

    /**
     * 首页生成
     * @return \Exception|int|Exception
     */
    public function createHomepage() {
        try {
            return $this->createHtml(ROOT_PATH . 'index.html');
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * 站点地图生成，创建所有语言的sitemap
     */
    public function createSitemap() {
        foreach ($this->_data['__LANGUAGE_CONFIG__'] as $_languageId => $_package) {
            $this->createHtml(ROOT_PATH . ($_languageId > 0 ?
                    $_package . DIRECTORY_SEPARATOR : '')
                . 'sitemap.html', $_package, array('sitemap'));
        }
    }

    /**
     * 创建html文件
     * @param $file
     * @param null $package
     * @param array $paths
     * @return int
     */
    public function createHtml($file, $package = null, $paths = array()) {
        $this->_data['__PACKAGE__'] = $package;
        $this->_data['__PATHS__'] = $paths;
        $this->_data['__METHOD__'] = 'GET'; //生成的页面模拟get访问
        ob_start();
        Controller::start($this->_data);
        return file_put_contents($file, ob_get_clean(), LOCK_EX);
    }

    /**
     * 创建所有栏目
     * @param int $typeId
     * @param null $limit
     * @return bool
     */
    public function createColumn($typeId = 0, $limit = null) {
        try {
            if ($this->createArticleDir()) {
                $this->createArticleType($typeId, $limit);
            }
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 创建文章html
     * @param null $id 指定生成文章id
     * @param string $mode 生成类别下所有文章 one 生成单个文章
     * @param null $limit
     */
    public function createArticle($id = null, $mode = 'type', $limit = null) {
        if ($this->createArticleDir()) {
            //die(var_dump($id));
            if (!$this->_data['aryArticleTypeDataView'])
                $this->_data['aryArticleTypeDataView'] = $this->_serviceArticle->getArticleTypeDataCache();
            $this->_data['isCreateColumn'] = false;
            $_where = '0 = 0';
            $_bind = array();
            if ($id != null) {
                if (strcasecmp('type', $mode) == 0) {
                    $_where = ' AND a.type_id = ?';
                } else {
                    $_where = ' AND a.article_id = ?';
                }
                array_push($_bind, $id);
            }

            //$this->db->debug();
            $_rs = $this->db->select('a.*, b.*, c.type_name, c.level, c.id_tree, c.parent_id,
				c.root_id, c.is_part, c.channel_type, c.list_dir, c.ilanguage')
                ->table('`#@__@article` a, `#@__@article_content` b, `#@__@article_type` c')
                ->where($_where . ' AND a.article_id = b.article_id AND a.is_display = 1 AND a.type_id = c.type_id AND c.is_display = 1')
                ->bind($_bind)
                ->order('a.article_id')
                ->limit($limit)
                ->findAll();
            if ($_rs) {
                foreach ($_rs as $this->_data['pageContentRs']) {
                    $this->_data['rootListDir'] = $_listDir = $this->_data['aryArticleTypeDataView'][$this->_data['pageContentRs']->root_id]['list_dir'];

                    $_package = $this->_data['__LANGUAGE_CONFIG__'][$this->_data['pageContentRs']->ilanguage];
                    $_listDir = ROOT_PATH . $_package
                        . DIRECTORY_SEPARATOR . trim($_listDir, '/');
                    if (!is_dir($_listDir))
                        mkdir($_listDir, 0777);

                    $_isSeoUrl = $this->_data['pageContentRs']->seo_url != '' ? true : false;
                    if ($_isSeoUrl) {
                        $_listDir .= DIRECTORY_SEPARATOR
                            . $this->_data['pageContentRs']->seo_url . '.html';
                    } else {
//						$_date = date('Ym', $this->_data['pageContentRs']->add_date);
//						$_listDir .= DIRECTORY_SEPARATOR . $_date;
//						if (!is_dir($_listDir))
//							mkdir($_listDir, 0777);

                        $_listDir .= DIRECTORY_SEPARATOR
                            . $this->_data['pageContentRs']->article_id . '.html';
                    }

                    $this->_data['__HOMEPAGE__'] = false;
                    $_tmpChannelTypeMapping = $this->_mappingChannelType[$_package][intval($this->_data['pageContentRs']->channel_type)];

                    $_paths = array();
                    if (isset($_tmpChannelTypeMapping[3])) {
                        $_paths = explode('/', $_tmpChannelTypeMapping[3] . '/'
                            . $this->_data['pageContentRs']->article_id);
                    } else {
                        $_paths = explode('/', $_tmpChannelTypeMapping[1]);
                        array_push(array_pop($_paths), 'detail'); //没有配置则默认使用show
                        array_push($_paths, $this->_data['pageContentRs']->article_id);
                    }
                    //die(var_dump($this->_data['pageContentRs']->article_id));
                    $this->createHtml($_listDir, $_package, $_paths);
                }
            }
        }
    }

    private function _getDataViewByIdTree($aryIdTree, $isGetParent = false) {
        //不能在注入时生成，否则在添加修改类别时会获得修改前的值
        if (!$this->_data['aryArticleTypeDataView'])
            $this->_data['aryArticleTypeDataView'] = $this->_serviceArticle->getArticleTypeDataCache();
        if ($isGetParent)
            array_pop($aryIdTree);
        $_aryArticleTypeDataView = $this->_data['aryArticleTypeDataView'];
        foreach ($aryIdTree as $_id) {
            $_aryArticleTypeDataView = $_aryArticleTypeDataView[(int)$_id];
        }
        return $_aryArticleTypeDataView;
    }

    /**
     * 创建类别下的文件，递归生成
     * @param int $typeId 生成路径，含递归值
     * @param null $limit 生成级别
     * @return bool
     */
    public function createArticleType($typeId = 0, $limit = null) {
        $this->_data['isCreateColumn'] = true;
        //$this->db->debug();
        //var_dump($typeLevel);
        $_bind = array();
        $_where = '0 = 0';
        if ($typeId > 0) {
            $_where = ' AND a.type_id = ?';
            array_push($_bind, intval($typeId));
        }

        $_tmpChannelTypeMapping = null;
        //$this->db->debug();
        $_rs = $this->db->select('a.*, b.*')
            ->table('`#@__@article_type` a, `#@__@article_type_content` b')
            ->where($_where . ' AND a.is_part < 2 AND a.is_display = 1 AND a.type_id = b.type_id')
            ->bind($_bind)
            ->order('a.sort', 'ASC')
            ->limit($limit)
            ->findAll();
        if ($_rs) {
            foreach ($_rs as $this->_data['currentTypeRs']) {
                $_aryIdTree = explode('.', trim($this->_data['currentTypeRs']->id_tree, '.')); //idTree
                $_selfDataView = $this->_getDataViewByIdTree($_aryIdTree); //获取自身的view
                $_i = 0;
                $_typeId = $this->_data['currentTypeRs']->type_id;
                $_selfListDir = $_selfDataView['list_dir'];

                if ($_selfDataView['level'] > 1) {
                    $_i = $_selfDataView['sort'];
                    $_parentDataView = $this->_getDataViewByIdTree($_aryIdTree, true); //获取父节点视图
                    //如果自身为index但父目录是单页频道页，则应该显示list_id
                    if ($_i == 0 && $_parentDataView['is_part'] == 1) {
                        ++$_i;
                    }

                    $_tmpChildTypeIdListDir = Auxi::getChildTypeIdListDir($_selfDataView, $_typeId);
                    $_typeId = $_tmpChildTypeIdListDir[0];
                    $_selfListDir = $_tmpChildTypeIdListDir[1];
                    unset($_tmpChildTypeIdListDir);

                    if ($_i == 0 && $_selfDataView['level'] > 2 && !Auxi::isDataViewIndexId(
                            $this->_data['aryArticleTypeDataView'][$_selfDataView['root_id']],
                            $_typeId, $_selfDataView['level'])
                    ) //2级以后都是以list_id显示
                        ++$_i;
                }

                $this->_data['rootListDir'] = trim($this->_data['aryArticleTypeDataView'][$_selfDataView['root_id']]['list_dir'], '/');
                $_package = $this->_data['__LANGUAGE_CONFIG__'][$this->_data['currentTypeRs']->ilanguage];
                $_dir = ROOT_PATH . $_package
                    . DIRECTORY_SEPARATOR
                    . $this->_data['rootListDir'] . DIRECTORY_SEPARATOR;
                if (!is_dir($_dir))
                    mkdir($_dir, 0777);
                //$this->db->debug();
                //读取子类数量
                $_childrenTotal = intval($this->db->table('#@__@article_type')
                    ->where('parent_id = ?')
                    ->bind(array($this->_data['currentTypeRs']->type_id))
                    ->count());
                //如果没有了子分类[ 这个类别单页不生成 ] 或者
                //单页同时又含有子类[ 将子类集中在一个页面展示 ]
                if ($_childrenTotal >= 0) {
                    $_fileName = Auxi::getArticleListName($_i, $_typeId, $_selfListDir);
                    $_tmpFile = $_file = $_dir . $_fileName;

                    $_tmpChannelTypeMapping = $this->_mappingChannelType[$_package][intval($this->_data['currentTypeRs']->channel_type)];
                    $_paths = explode('/', $_tmpChannelTypeMapping[1]);
                    array_push($_paths, $_typeId);
                    $_tmpPaths = $_paths;
                    if ($this->_data['currentTypeRs']->is_part == 0) { //列表栏目
                        if ($_childrenTotal == 0) {
                            $_pages = 0;
                            $this->_data['currentTypeTotal'] = intval($this->db->table('#@__@article')
                                ->where('type_id = ? AND is_display = 1')
                                ->bind(array($this->_data['currentTypeRs']->type_id))
                                ->count());
                            $_pages = ceil($this->_data['currentTypeTotal'] / $_tmpChannelTypeMapping[2]);

                            $this->_data['fileName'] = $_fileName; //用于分页
                            for ($_page = 1; $_page <= $_pages; $_page++) {
                                if ($_page > 1) {
                                    $_tmpFile = str_replace('.html', '_' . $_page . '.html', $_file);
                                }
                                $_paths = $_tmpPaths;
                                array_push($_paths, $_page);
                                $this->createHtml($_tmpFile, $_package, $_paths);
                            }
                        }
                        continue;
                    }
                    $this->createHtml($_tmpFile, $_package, $_paths);
                }
            }
            return true;
        }
        return false;
    }

    /**
     * 创建生成文档的根路径，根据配置文件
     * @return bool
     */
    public function createArticleDir() {
        try {
            foreach ($this->_data['__LANGUAGE_CONFIG__'] as $_dir) {
                if (!is_dir(ROOT_PATH . $_dir)) {
                    mkdir(ROOT_PATH . $_dir, 0777);
                }
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 创建生成文档的根路径，根据配置文件
     * @return bool
     */
    public function deleteArticleDir() {
        try {
            foreach ($this->_data['__LANGUAGE_CONFIG__'] as $_dir) {
                File::rmdir($_dir, ROOT_PATH);
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function createByStep() {
        $_aryCreateInfo = explode('-', $_POST['createInfo']);
        if ($this->_data['deleteHtmlFolder'] > 0) {//如果设置了则删除目录
            $this->deleteArticleDir();
        }
        switch (intval($_aryCreateInfo[1])) {
            case 0:
                //生成首页
                $this->createHomepage();
                $_aryCreateInfo[1] = $_aryCreateInfo[0] == 3 ? 1 : 3;
                break;
            case 1:
                if ($_aryCreateInfo[3] == 0)
                    $_aryCreateInfo[3] = intval($this->db->table('#@__@article_type')
                        ->where('is_part < 2 AND is_display = 1')
                        ->count());

                if ($_aryCreateInfo[2] == 0) {
                    $_aryCreateInfo[2] = 1;
                }
                $_limit = $_aryCreateInfo[4] * ($_aryCreateInfo[2] - 1) . ' , ' . $_aryCreateInfo[4];
                $_pages = ceil($_aryCreateInfo[3] / $_aryCreateInfo[4]);
                if ($_aryCreateInfo[2] <= $_pages) {
                    $this->createColumn(0, $_limit);
                    $_aryCreateInfo[1] = 1;
                    $_aryCreateInfo[2]++;
                }
                if ($_aryCreateInfo[2] > $_pages) {
                    $_aryCreateInfo[1] = $_aryCreateInfo[0] == 3 ? 2 : 3; //步进到生成文章
                    $_aryCreateInfo[2] = 0; //页码清零
                    $_aryCreateInfo[3] = 0; //总数清零
                }
                break;
            case 2:
                if ($_aryCreateInfo[3] == 0)
                    $_aryCreateInfo[3] = intval($this->db->table('#@__@article')
                        ->where('is_display = 1')
                        ->count());

                if ($_aryCreateInfo[2] == 0) {
                    $_aryCreateInfo[2] = 1;
                }
                $_limit = $_aryCreateInfo[4] * ($_aryCreateInfo[2] - 1) . ' , ' . $_aryCreateInfo[4];
                $_pages = ceil($_aryCreateInfo[3] / $_aryCreateInfo[4]);
                if ($_aryCreateInfo[2] <= $_pages) {
                    $this->createArticle(null, 'type', $_limit);
                    $_aryCreateInfo[1] = 2;
                    $_aryCreateInfo[2]++;
                }
                if ($_aryCreateInfo[2] > $_pages) {
                    $_aryCreateInfo[1] = 3;
                    $_aryCreateInfo[2] = 0; //页码清零
                    $_aryCreateInfo[3] = 0; //总数清零
                }
                break;
        }
        if ($this->_data['createSitemap'] > 0) {//如果设置了生成sitemp
            $this->createSitemap();
        }
        return implode('-', $_aryCreateInfo);
    }

}
