<?php
/**
 * 禁止讨厌鬼访问网站，眼不见心不烦~
 *
 * @package DisableFrontend
 * @author Kokororin
 * @version 1.0
 * @update: 2015.9.10
 * @link https://kotori.love
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
echo '<link rel="stylesheet" href="<?php Helper::options()->pluginUrl(); ?>/LoginDesigner/style.css?202108">';
$url=Helper::options()->pluginUrl.'/LoginDesigner/';
$zz1='<div class="zz">Default</div>';
$zz2='<div class="zz">Nginx</div>';
$zz3='<div class="zz">midBig</div>'; 
      
 $bgfengge = new Typecho_Widget_Helper_Form_Element_Radio(
'bgfengge', array(
  'Default' => _t('<div class="kuai"><img src="'.$url.'/images/suya.jpg" loading="lazy">'.$zz1.'</div>'),
  'Nginx' => _t('<div class="kuai"><img src="'.$url.'/images/BlueSkyAndMountains.jpg" loading="lazy">'.$zz2.'</div>'),
  'midBig' => _t('<div class="kuai"><img src="'.$url.'/images/Earlyspringimpression.jpg" loading="lazy">'.$zz3.'</div>'),
    ), 'suya', _t('维护页面样式'), _t('')); 
    $bgfengge->setAttribute('id', 'yangshi');
    $form->addInput($bgfengge); 
    }

    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {}

    public static function DisableFrontend()
    {
        $options = Typecho_Widget::widget('Widget_Options')->plugin('DisableFrontend');
        $choose = $options->choose;
        include './template/'.$choose;
        exit;    
    }

}
