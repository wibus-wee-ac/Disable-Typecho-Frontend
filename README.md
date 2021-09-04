# Disable-Typecho-Frontend

这是一个全面禁用typecho前端的案例，同样也是一款全站维护插件

## 使用方法

1. 下载最新的代码压缩包：https://github.com/wibus-wee/Disable-Typecho-Frontend/archive/refs/heads/main.zip
2. 上传服务器至插件目录解压
3. 改目录名字为`DisableFrontend`
4. Typecho后台启动插件开始使用

## 为什么要写这个案例

说到这个，我很反感就这么一丢丢的小东西，收费干嘛？

又不是大项目，或者说是一个很复杂的东西，或者说要思考很久的策略，我们付费是为了购买到一个牛逼的东西，这玩意，懂得全都会写，而且也不难，为什么要付费出去？

## 友情提示

建议你不要来找我杠道理，我懒得理你谢谢

本插件案例灵感来自BlockIP插件！感谢！

## 原理解释

在Typecho中，还是万能的Widget中有一个：`Typecho_Plugin::factory('Widget_Archive')->beforeRender`，可以在渲染前输出东西，之后上个函数，一个threw就打断继续了，一个exit就直接退出了

但是原作者是这样的：

> 主要卡在Action无输出上面了，最后面通过Debug发现有必须实现的方法没实现，好久没写Route相关的插件了

据我所知，路由在插件中一般是用来自定义页面的吧？我到现在其实还不懂他在说啥route😂

## 感谢项目

- BlockIP —— 感谢！这是此项目的核心，通过此项目再翻找typecho源码，知道了beforeRender
- LoginDesigner —— config选项样式来源
- MDUI —— 头部样式来源
- Maintain —— 让我知道原来这也要收费
- Typecho —— 插件运行核心