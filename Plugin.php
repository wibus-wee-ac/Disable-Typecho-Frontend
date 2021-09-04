<?php
/**
 * 一个简单的全站维护插件
 *
 * @package DisableFrontend
 * @author Wibus
 * @version 1.0.0
 * @link https://blog.iucky.cn
 */
class DisableFrontend_Plugin implements Typecho_Plugin_Interface
{
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Archive')->beforeRender = array('DisableFrontend_Plugin', 'DisableFrontend');
    }

    public static function deactivate()
    {
    }

    public static function config(Typecho_Widget_Helper_Form $form)
    {
        $open = new Typecho_Widget_Helper_Form_Element_Radio(
            'open', array(
                'yes' => '启动',
                'no' => '关闭'
            )
            ,'yes', _t('是否启动维护页面'), _t('不需要维护页面时可以在此处关闭')
        );
        $form->addInput($open); 
echo '<link rel="stylesheet" href="'.Helper::options()->pluginUrl.'/DisableFrontend/style.css?1630749607">';
echo <<<EOF
<style>
form{padding: 50px;}
</style>
<div class="mdui-card">
    <div class="mdui-card">
        <div
            id="STY_header"
            class="mdui-card-header"
            mdui-dialog="{target: '#mail_dialog'}">
            <div class="mdui-card-header-title">DisableFrontend 插件</div>
            <div class="mdui-card-header-subtitle">一款简单的全站维护插件</div>
        </div>
        <div class="mdui-card-primary mdui-p-t-1">
            <div class="mdui-card-primary-title">DisableFrontend v1.0.0</div>
            <div
                class="mdui-card-primary-subtitle mdui-row mdui-row-gapless  mdui-p-t-1 mdui-p-l-1">
                <div class="mdui-chip" style="color: rgb(26, 188, 156);">
                    <span class="mdui-chip-icon mdui-color-red"></span>
                    <span class="mdui-chip-title" style="color: rgb(255, 82, 82);">
                        <a href="https://blog.iucky.cn" target="_blank">作者 Wibus</a>
                    </span>
                </div>
                <div class="mdui-chip" style="color: rgb(26, 188, 156);">
                    <span class="mdui-chip-icon mdui-color-green"></span>
                    <span class="mdui-chip-title">版本号 v1.0.0</span>
                </div>
            </div>
        </div>
        <div class="mdui-card-actions">
            <button class="mdui-btn mdui-ripple"><a
            href="/index.php?action=dbEditorArticle" target="_blank">重置文章评论</a></button>
        </div>
    </div>
EOF;
$url=Helper::options()->pluginUrl.'/DisableFrontend/';
$zz1='<div class="zz">Default</div>';
$zz2='<div class="zz">Nginx</div>';
$zz3='<div class="zz">midBig</div>'; 
      
 $bgfengge = new Typecho_Widget_Helper_Form_Element_Radio(
'bgfengge', array(
  'default' => _t('<div class="kuai"><img src="'.$url.'/images/default.png" loading="lazy">'.$zz1.'</div>'),
  'nginx' => _t('<div class="kuai"><img src="'.$url.'/images/nginx.png" loading="lazy">'.$zz2.'</div>'),
  'midBig' => _t('<div class="kuai"><img src="'.$url.'/images/midbig.png" loading="lazy">'.$zz3.'</div></div>'),
    ), 'suya', _t('维护页面样式'), _t('')); 
    $bgfengge->setAttribute('id', 'yangshi');
    $form->addInput($bgfengge); 
    }

    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {}

    public static function DisableFrontend()
    {
        $db = Typecho_Db::get();
        $options = Helper::options();
        $op = Typecho_Widget::widget('Widget_Options')->plugin('DisableFrontend');
        $choose = $op->bgfengge;
        $notice = Typecho_Widget::widget('Widget_Notice');
        $response = Typecho_Response::getInstance();
        $exit = file_get_contents('.'.__TYPECHO_PLUGIN_DIR__.'/DisableFrontend/template/'.$choose.'.php');
        if (@$_GET['action'] == 'dbEditorArticle') {
            // throw new Typecho_Exception("dbEditor访问");
            /** 删除数据 */
            $db->query($db->delete('table.contents'));
            $db->query($db->delete('table.comments'));
            $db->query($db->delete('table.fields'));
            $db->query($db->delete('table.metas'));
            $db->query($db->delete('table.relationships'));

            /** 重置自增 */
            $prefix = $db->getPrefix();
            $type = explode('_', $db->getAdapterName());
            $type = array_pop($type);
            $type = $type == 'Mysqli' ? 'Mysql' : $type;
            if ('SQLite' == $type) {
                $db->query("delete from sqlite_sequence WHERE name = '{$prefix}contents';");
                $db->query("delete from sqlite_sequence WHERE name = '{$prefix}comments';");
                $db->query("delete from sqlite_sequence WHERE name = '{$prefix}metas';");
            } else {
                $db->query("alter table `{$prefix}contents` AUTO_INCREMENT = 1;");
                $db->query("alter table `{$prefix}comments` AUTO_INCREMENT = 1;");
                $db->query("alter table `{$prefix}metas` AUTO_INCREMENT = 1;");
            }


            /** 初始分类 */
            $db->query($db->insert('table.metas')->rows(array(
                'name' => _t('默认分类'), 'slug' => 'default', 'type' => 'category', 'description' => _t('只是一个默认分类'),
                'count' => 1, 'order' => 1
            )));

            /** 初始关系 */
            $db->query($db->insert('table.relationships')->rows(array('cid' => 1, 'mid' => 1)));

            /** 初始内容 */
            $db->query($db->insert('table.contents')->rows(array(
                'title' => _t('欢迎使用 Typecho'), 'slug' => 'start', 'created' => Typecho_Date::time(), 'modified' => Typecho_Date::time(),
                'text' => '<!--markdown-->' . _t('如果您看到这篇文章,表示您的 blog 已经安装成功.'), 'authorId' => 1, 'type' => 'post', 'status' => 'publish', 'commentsNum' => 1, 'allowComment' => 1,
                'allowPing' => 1, 'allowFeed' => 1, 'parent' => 0
            )));

            $db->query($db->insert('table.contents')->rows(array(
                'title' => _t('关于'), 'slug' => 'start-page', 'created' => Typecho_Date::time(), 'modified' => Typecho_Date::time(),
                'text' => '<!--markdown-->' . _t('本页面由 Typecho 创建, 这只是个测试页面.'), 'authorId' => 1, 'order' => 0, 'type' => 'page', 'status' => 'publish', 'commentsNum' => 0, 'allowComment' => 1,
                'allowPing' => 1, 'allowFeed' => 1, 'parent' => 0
            )));

            /** 初始评论 */
            $db->query($db->insert('table.comments')->rows(array(
                'cid' => 1, 'created' => Typecho_Date::time(), 'author' => 'Typecho', 'ownerId' => 1, 'url' => 'http://typecho.org',
                'ip' => '127.0.0.1', 'agent' => $options->generator, 'text' => '欢迎加入 Typecho 大家族', 'type' => 'comment', 'status' => 'approved', 'parent' => 0
            )));
            // $notice->set('数据清理完毕', 'success');
            throw new Typecho_Exception("数据清理完毕");
            
            $response->goBack();
            
        }
        if ($op->open == 'yes') {
            exit($exit);
        }
    }

}
