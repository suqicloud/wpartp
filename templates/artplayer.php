<?php
// 获取视频相关信息和HTML生成
$artdplayerjson = get_option('artdplayerjson');
$artdplayer = json_decode($artdplayerjson, true);
$art = $artdplayer;

// 解析URL列表
$urls = explode(',', $atts['url']);
$videoCount = count($urls);  // 视频数量
$currentVideoIndex = isset($_GET['video_index']) ? intval($_GET['video_index']) : 0;
$currentVideoUrl = esc_url(trim($urls[$currentVideoIndex]));  // 默认选择第一个视频
$poster = isset($atts['poster']) ? esc_url($atts['poster']) : '';  // 获取封面图地址

// 获取广告设置
$artdplayerjson = get_option('artdplayerjson');
$artdplayer = json_decode($artdplayerjson, true);

// 读取广告设置
$enableAds = isset($artdplayer['enable_ads']) && $artdplayer['enable_ads'] == 1;
$adHtml = isset($artdplayer['ad_html']) ? $artdplayer['ad_html'] : '';
$adVideo = isset($artdplayer['ad_video']) ? $artdplayer['ad_video'] : '';
$adUrl = isset($artdplayer['ad_url']) ? $artdplayer['ad_url'] : '';
$adPlayDuration = isset($artdplayer['ad_play_duration']) ? intval($artdplayer['ad_play_duration']) : 5;
$adTotalDuration = isset($artdplayer['ad_total_duration']) ? intval($artdplayer['ad_total_duration']) : 10;

?>

<div id="artplayer<?php echo $atts['_id']; ?>" class="artplayerbox" style="width:<?php echo $atts['width']; ?>;height:<?php echo $atts['height']; ?>">
        <!-- 广告展示 -->
    <?php if ($enableAds) : ?>
        <div class="artplayer-ads">
            <?php if (!empty($adVideo)) : ?>
                <video id="ad-video" class="ad-video" autoplay>
                    <source src="<?php echo esc_url($adVideo); ?>" type="video/mp4">
                    你的浏览器不支持视频标签。
                </video>
            <?php elseif (!empty($adHtml)) : ?>
                <div class="ad-html">
                    <?php echo $adHtml; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="video-buttons-container">
        <!-- 集数按钮 -->
        <?php echo $buttonsHtml; ?>
    </div>
</div>

<!-- 集数按钮和播放下一集按钮 -->
<?php if ($videoCount > 1) : ?>
    <div class="episode-buttons">
        <!-- 播放下一集按钮 -->
        <button class="next-video-button">播放下一集</button>
        <!-- 集数按钮 -->
        <?php foreach ($urls as $index => $url) : ?>
            <button type="button" class="video-button" data-video-url="<?php echo esc_url(trim($url)); ?>" data-video-index="<?php echo $index; ?>">
                第<?php echo $index + 1; ?>集
            </button>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<script type="text/javascript">
    var art = null;  // 定义播放器实例
    var currentVideoIndex = <?php echo $currentVideoIndex; ?>;  // 当前视频索引
    var videoCount = <?php echo $videoCount; ?>;  // 视频总数
    var urls = <?php echo json_encode($urls); ?>;  // 视频URL列表
    var poster = "<?php echo $poster; ?>";  // 获取封面图地址

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
            poster: poster,  // 传递封面图地址
            theme: '<?php echo $artdplayer['theme']; ?>',
            autoplay: autoplay,  // 切换视频时是否自动播放
            <?php if(isset($art['volume']) && !empty($art['volume'])){ echo 'volume:'.$art['volume'].','; } ?>
            <?php if(isset($art['muted']) && !empty($art['muted'])){ echo 'muted:true,'; } ?>
            <?php if(isset($art['autoplayone']) && !empty($art['autoplayone'])){ echo 'autoplay:true,'; } ?>
            <?php if(isset($art['loop']) && !empty($art['loop'])){ echo 'loop:true,'; } ?>
            <?php if(isset($art['autoMini']) && !empty($art['autoMini'])){ echo 'autoMini:true,'; } ?>
            <?php if(isset($art['playbackRate']) && !empty($art['playbackRate'])){ echo 'playbackRate:true,'; } ?>
            <?php if(isset($art['screenshot']) && !empty($art['screenshot'])){ echo 'screenshot:true,'; } ?>
            <?php if(isset($art['pip']) && !empty($art['pip'])){ echo 'pip:true,'; } ?>
            <?php if(isset($art['fullscreenWeb']) && !empty($art['fullscreenWeb'])){ echo 'fullscreenWeb:true,'; } ?>
            <?php if(isset($art['flip']) && !empty($art['flip'])){ echo 'flip:true,'; } ?>
            <?php if(isset($art['miniProgressBar']) && !empty($art['miniProgressBar'])){ echo 'miniProgressBar:true,'; } ?>
            <?php if(isset($art['lock']) && !empty($art['lock'])){ echo 'lock:true,'; } ?>
            <?php if(isset($art['fastForward']) && !empty($art['fastForward'])){ echo 'fastForward:true,'; } ?>
            <?php if(isset($art['autoPlayback']) && !empty($art['autoPlayback'])){ echo 'autoPlayback:true,'; } ?>
            <?php if(isset($art['autoOrientation']) && !empty($art['autoOrientation'])){ echo 'autoOrientation:true,'; } ?>
            <?php if(isset($art['airplay']) && !empty($art['airplay'])){ echo 'airplay:true,'; } ?>
            plugins: [
            <?php if ($enableAds) : ?>
                artplayerPluginAds({
                    html: '<?php echo addslashes($adHtml); ?>',
                    video: '<?php echo esc_url($adVideo); ?>',
                    url: '<?php echo esc_url($adUrl); ?>',
                    playDuration: <?php echo $adPlayDuration; ?>,
                    totalDuration: <?php echo $adTotalDuration; ?>,
                }),
            <?php endif; ?>
            ],
            hotkey: true,
            fullscreen: true,
            setting: true,
            whitelist: ['*'],
            lang: 'zh-cn',
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

        });

    }


    // 初始化播放器时传入默认的视频URL，不自动播放
    initializePlayer(urls[currentVideoIndex]);

    // 集数按钮点击事件
    jQuery('.video-button').on('click', function () {
        var videoIndex = jQuery(this).data('video-index');
        var videoUrl = urls[videoIndex];

        // 销毁并重新初始化播放器，传入autoplay参数为true
        initializePlayer(videoUrl, true);  // 切换集数时自动播放

        // 更新按钮样式（高亮当前集）
        jQuery('.video-button').removeClass('active');
        jQuery(this).addClass('active');

        // 更新当前视频索引
        currentVideoIndex = videoIndex;
    });

    // 播放下一集按钮点击事件
    jQuery('.next-video-button').on('click', function () {
        // 如果当前是最后一集，什么也不做
        if (currentVideoIndex < videoCount - 1) {
            currentVideoIndex++;
            var nextVideoUrl = urls[currentVideoIndex];
            initializePlayer(nextVideoUrl, true);  // 自动播放下一集
        }
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

    /* 播放下一集按钮 */
    .next-video-button {
        background-color: #2a59f1;
        color: #fff;
        padding: 10px 20px;
        margin: 5px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .next-video-button:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    .next-video-button:active {
        transform: scale(0.98);
    }   
</style>