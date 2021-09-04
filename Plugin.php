<?php
/**
 * 一个简单的全站维护插件
 *
 * @package DisableFrontend
 * @author Wibus
 * @version 1.0
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
echo '<link rel="stylesheet" href="'.Helper::options()->pluginUrl.'/DisableFrontend/style.css">';
echo <<<EOF

EOF;
$url=Helper::options()->pluginUrl.'/DisableFrontend/';
$zz1='<div class="zz">Default</div>';
$zz2='<div class="zz">Nginx</div>';
$zz3='<div class="zz">midBig</div>'; 
      
 $bgfengge = new Typecho_Widget_Helper_Form_Element_Radio(
'bgfengge', array(
  'default' => _t('<div class="kuai"><img src="'.$url.'/images/default.png" loading="lazy">'.$zz1.'</div>'),
  'nginx' => _t('<div class="kuai"><img src="'.$url.'/images/nginx.png" loading="lazy">'.$zz2.'</div>'),
  'midBig' => _t('<div class="kuai"><img src="'.$url.'/images/midbig.png" loading="lazy">'.$zz3.'</div>'),
    ), 'suya', _t('维护页面样式'), _t('')); 
    $bgfengge->setAttribute('id', 'yangshi');
    $form->addInput($bgfengge); 
    }

    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {}

    public static function DisableFrontend()
    {
        $options = Typecho_Widget::widget('Widget_Options')->plugin('DisableFrontend');
        $choose = $options->bgfengge;
        $exit = file_get_contents('.'.__TYPECHO_PLUGIN_DIR__.'/DisableFrontend/template/'.$choose.'.php');
        exit($exit);
    }

}
