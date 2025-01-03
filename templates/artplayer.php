<?php
    $artdplayerjson = get_option('artdplayerjson');
    $artdplayer = json_decode($artdplayerjson, true);
    $art = $artdplayer;

    // 解析URL列表
    $urls = explode(',', $atts['url']);
    $videoCount = count($urls);  // 视频数量
    $currentVideoIndex = isset($_GET['video_index']) ? intval($_GET['video_index']) : 0;
    $currentVideoUrl = esc_url(trim($urls[$currentVideoIndex]));  // 默认选择第一个视频
?>

<div id="artplayer<?php echo $atts['_id']; ?>" class="artplayerbox" style="width:<?php echo $atts['width']; ?>;height:<?php echo $atts['height']; ?>">
    <div class="video-buttons-container">
        <?php echo $buttonsHtml; ?>
    </div>
</div>

<!-- 集数按钮 -->
<?php if ($videoCount > 1) : ?>
    <div class="episode-buttons">
        <?php foreach ($urls as $index => $url) : ?>
            <button type="button" class="video-button" data-video-url="<?php echo esc_url(trim($url)); ?>" data-video-index="<?php echo $index; ?>">
                第<?php echo $index + 1; ?>集
            </button>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<script type="text/javascript">
    var art = null;  // 定义播放器实例

    // 初始化播放器
    function initializePlayer(videoUrl, autoplay = false) {
        if (art) {
            art.destroy();  // 销毁当前播放器实例
        }

        // 创建新播放器实例
        art = new Artplayer({
            id: "art<?php echo $atts['_id']; ?>",
            container: "#artplayer<?php echo $atts['_id']; ?>",
            url: videoUrl,  // 传递的当前视频URL
            theme: '<?php echo $artdplayer['theme']; ?>',
            autoplay: autoplay,  // 切换视频时是否自动播放
            <?php if(isset($art['poster']) && !empty($art['poster'])){ echo 'poster:"'.$art['poster'].'",'; } ?>
            <?php if(isset($art['volume']) && !empty($art['volume'])){ echo 'volume:'.$art['volume'].','; } ?>
            <?php if(isset($art['muted']) && !empty($art['muted'])){ echo 'muted:true,'; } ?>
            <?php if(isset($art['autoplayone']) && !empty($art['autoplayone'])){ echo 'autoplay:true,'; } ?>
            <?php if(isset($art['loop']) && !empty($art['loop'])){ echo 'loop:true,'; } ?>
            <?php if(isset($art['autoMini']) && !empty($art['autoMini'])){ echo 'autoMini:true,'; } ?>
            <?php if(isset($art['playbackRate']) && !empty($art['playbackRate'])){ echo 'playbackRate:true,'; } ?>
            <?php if(isset($art['screenshot']) && !empty($art['screenshot'])){ echo 'screenshot:true,'; } ?>
            <?php if(isset($art['pip']) && !empty($art['pip'])){ echo 'pip:true,'; } ?>
            <?php if(isset($art['miniProgressBar']) && !empty($art['miniProgressBar'])){ echo 'miniProgressBar:true,'; } ?>
            <?php if(isset($art['lock']) && !empty($art['lock'])){ echo 'lock:true,'; } ?>
            <?php if(isset($art['fastForward']) && !empty($art['fastForward'])){ echo 'fastForward:true,'; } ?>
            <?php if(isset($art['autoPlayback']) && !empty($art['autoPlayback'])){ echo 'autoPlayback:true,'; } ?>
            <?php if(isset($art['autoOrientation']) && !empty($art['autoOrientation'])){ echo 'autoOrientation:true,'; } ?>
            <?php if(isset($art['airplay']) && !empty($art['airplay'])){ echo 'airplay:true,'; } ?>
            hotkey: true,
            fullscreenWeb: true,
            fullscreen: true,
            setting: true,
            whitelist: ['*'],
            lang: <?php if(isset($art['lang']) && $art['lang']!=1){ echo '"'.$art['lang'].'"'; }else{echo 'navigator.language.toLowerCase()';} ?>,
            customType: {
                m3u8: function (video, url) {
                    if (Hls.isSupported()) {
                        const hls = new Hls();
                        hls.loadSource(url);
                        hls.attachMedia(video);
                    } else {
                        const canPlay = video.canPlayType('application/vnd.apple.mpegurl');
                        if (canPlay === 'probably' || canPlay === 'maybe') {
                            video.src = url;
                        } else {
                            art.notice.show = "<?php _e('Unsupported playback format: m3u8','wpartplayer'); ?>";
                        }
                    }
                }
            },
            plugins: [
                <?php if(isset($art['danmuku']) && !empty($art['danmuku'])){ ?>
                    artplayerPluginDanmuku({
                        danmuku: function () {
                            return new Promise((resolve) => {
                                var httpRequest = new XMLHttpRequest();
                                var gourl='<?php echo admin_url('admin-ajax.php?vid='.$atts['_id']); ?>&action=get_artdanmuku';
                                httpRequest.open('GET', gourl, true);
                                httpRequest.send();
                                httpRequest.onreadystatechange = function () {
                                    if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                                        var json = httpRequest.responseText;
                                        return resolve(JSON.parse(json).result)
                                    }
                                };
                            });
                        },
                        speed: 8, 
                        opacity: 1, 
                        fontSize: 25, 
                        color: '#FFFFFF', 
                        mode: 0, 
                        margin: [10, '25%'], 
                        antiOverlap: true, 
                        useWorker: true, 
                        synchronousPlayback: false, 
                        filter: (danmu) => danmu.text.length < 50, 
                        lockTime: 5, 
                        maxLength: 100, 
                        minWidth: 200, 
                        maxWidth: 0, 
                        theme: 'dark', 
                        beforeEmit: (danmu) => !!danmu.text.trim(),
                    }),
                <?php } ?>
            ],
        });
    }

    // 初始化播放器时传入默认的视频URL，不自动播放
    initializePlayer("<?php echo $currentVideoUrl; ?>");

    // 集数按钮点击事件
    jQuery('.video-button').on('click', function () {
        var videoUrl = jQuery(this).data('video-url');
        
        // 销毁并重新初始化播放器，传入autoplay参数为true
        initializePlayer(videoUrl, true);  // 切换集数时自动播放

        // 更新按钮样式（高亮当前集）
        jQuery('.video-button').removeClass('active');
        jQuery(this).addClass('active');
        
        // 保持网址不变
        history.pushState(null, null, window.location.pathname); // 清除查询字符串（不改变URL）
    });
</script>

<style>
    /* 集数按钮的基本样式 */
    .video-button {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        margin: 5px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    /* 按钮悬停时 */
    .video-button:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    /* 按钮点击时 */
    .video-button:active {
        transform: scale(0.98);
    }

    /* 集数按钮容器的布局 */
    .video-buttons-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 15px;
    }
</style>
