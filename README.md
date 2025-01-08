# wpartp

这款插件来源https://github.com/oyjcmyn/wp-artplayer  
前几天给自己播放器插件更新的时候，想起了artplayer播放器，然后看看WordPress有没有artplayer播放器的插件，就看见了这个项目。  
但是原作者几年没有更新了，看了他社区，也有人说无法安装，我就下载下来看了下，顺便也改了点。  
  


我重新命名为：wpartp（artplayer HTML5播放器）  

我做了以下修改：  
1.修复无法安装的bug  
2.修复无法插入正常简码的bug  
3.优化简码改成视频链接自动识别（添加视频链接的时候不用手动选择）  
4.优化视频链接快捷入口方式  
5.优化封面图改为可以单独设置  
6.删掉了flv格式支持的选项和js文件  
7.删了语言选项，改为默认中文  
8.删了弹幕相关的功能  
9.artplayer播放器相关的js文件更新到5.2.1版  
10.新增网页全屏fullscreenWeb模式  
11.新增对b站视频的支持  
12.新增对多个视频的支持（实现多集视频播放，前台可以选集切换播放）  
13.新增视频翻转设置  
14.新增广告内容设置  

其他代码改了下菜单的图标，把原来菜单文件admin_menus.php的代码放到了主文件里面，因为删掉弹幕功能之后，这个文件就没啥代码了，干脆放到别的地方去，还有插件中心的快速设置页面入口也改了，原来的没有生效，我就换成了自己的方式。  
然后就没有改了，有的后台功能看都没看，也没测试。  



其他代码都没有改了，有的原版后台功能我都没测试。  

现在的短代码：  
[artplayer url="https://视频.mp4"]  
[artplayer url="https://视频.m3u8"]  
[artplayer url="https://www.bilibili.com/video/BVxxx"]  
b站的3种网址都支持和另外2个播放器插件一样。

社区反馈：https://iticu.icu/forum


Artplayer播放器源码 [https://github.com/zhw2590582/ArtPlayer](https://github.com/zhw2590582/ArtPlayer)

[ArtPlayer.js](https://artplayer.org/)is an easy-to-use and feature-rich HTML5 video player, and most of the player's functional controls support customization, which makes it easy to connect with your business logic. In addition, it directly supports .vtt, .ass and .srt subtitle formats. Integration with other dependencies such as flv.js, hls.js, dash.js, etc. is also very simple. The code is highly decoupled, the structure and logic are clear, and it is easy to track errors and add new features.
