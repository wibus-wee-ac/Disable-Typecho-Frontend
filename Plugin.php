<?php
/**
 * 禁止讨厌鬼访问网站，眼不见心不烦~
 *
 * @package Template
 * @author Wibus
 * @version template
 * @link https://blog.iucky.cn
 */
// 修改此处的Template
class Template_Plugin implements Typecho_Plugin_Interface
{
    public static function activate()
    {
        return "启用插件成功"; //可以直接注释
    }

    public static function deactivate()
    {
        return "禁用插件成功"; //可以直接注释，有默认显示的文字
    }

    public static function config(Typecho_Widget_Helper_Form $form)
    {
        // 此处填写设置选项
        // new 新建实例，类型和theme相同
        // 获取config：Typecho_Widget::widget('Widget_Options')->plugin('Template');
    }

    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {}

}
