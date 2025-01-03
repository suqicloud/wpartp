# wpartp

这款插件来源https://github.com/oyjcmyn/wp-artplayer  
前几天给自己播放器插件更新的时候，想起了artplayer播放器，然后看看WordPress有没有artplayer播放器的插件，就看见了这个项目。  
但是原作者几年没有更新了，看了他社区，也有人说无法安装，我就下载下来看了下，顺便也改了点。  

我重新命名为：wpartp（WPart播放器）  

我只做了以下修改：  
1、修复无法安装的bug  
2、优化简码改成视频链接自动识别（添加视频链接的时候不用手动选择）  
3、添加了对多个视频的支持（实现多集视频播放，前台可以选集播放）  
4、删掉了flv格式支持的选项和js文件  
5、artplayer播放器js文件更新到5.2.1版本  
6、删了几个语言文件，只保留了中文和英文  
7、添加了网页全屏fullscreenWeb模式  

其他代码都没有改了，有的后台功能看都没看，也没测试。  


Artplayer播放器源码 [https://github.com/zhw2590582/ArtPlayer](https://github.com/zhw2590582/ArtPlayer)

[ArtPlayer.js](https://artplayer.org/)is an easy-to-use and feature-rich HTML5 video player, and most of the player's functional controls support customization, which makes it easy to connect with your business logic. In addition, it directly supports .vtt, .ass and .srt subtitle formats. Integration with other dependencies such as flv.js, hls.js, dash.js, etc. is also very simple. The code is highly decoupled, the structure and logic are clear, and it is easy to track errors and add new features.
