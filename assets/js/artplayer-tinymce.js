(function() {
    tinymce.PluginManager.add('wp_artplayer_button', function(editor, url) {
        editor.addButton('wp_artplayer_button', {
            text: 'Artplayer播放器',  // 按钮文本
            icon: false,  // 不使用图标，保留默认样式
            onclick: function() {
                // 弹出窗口
                editor.windowManager.open({
                    title: 'Artplayer播放器设置',
                    body: [
                        {
                            type: 'textbox',
                            name: 'artplayer_urls',
                            label: '视频链接 (每行一个)',
                            multiline: true,
                            minWidth: 300,
                            minHeight: 100,
                        },
                        {
                            type: 'textbox',
                            name: 'artplayer_poster_url',
                            label: '封面图地址 (可选)',
                            value: '',  // 初始值为空
                            minWidth: 300,
                        },
                        {
                            type: 'label',
                            text: '请在上面输入视频链接，多个链接请按行分隔。',
                        },
                        {
                            type: 'label',
                            text: '如果需要封面图，填写对应的图片链接，留空则不显示封面。',
                        }
                    ],
                    onsubmit: function(e) {
                        // 获取用户输入的视频链接，并去掉多余空格
                        var videoUrls = e.data.artplayer_urls.split('\n').map(function(url) {
                            return url.trim();
                        }).join(',');

                        // 获取封面图地址（如果填写了）
                        var posterUrl = e.data.artplayer_poster_url.trim();

                        // 构建短代码
                        var shortcode = '[artplayer url="' + videoUrls + '"';

                        // 如果有封面图地址，添加到短代码中
                        if (posterUrl) {
                            shortcode += ' poster="' + posterUrl + '"';
                        }

                        shortcode += ']';

                        // 插入短代码到编辑器
                        editor.insertContent(shortcode);
                    }
                });
            }
        });
    });
})();
