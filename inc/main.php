<?php
/**
 * 
 * @authors Your Name (you@example.org)
 * @date    2025-01-08 18:17:51
 * @version $Id$
 */

class ART_MAIN_MI{

public static function save_options() {
    if (wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mi_artplayer_save_field'])), 'mi_artplayer_save_action')) {
        $data = $_POST;
        unset($data['mi_artplayer_save_field'], $data['_wp_http_referer']);
        
        // 处理广告设置，保存到数据库
        if (isset($data['enable_ads'])) {
            $data['enable_ads'] = 1;
        } else {
            $data['enable_ads'] = 0;
        }

        // 处理HTML广告内容，确保不被过滤
        if (isset($data['ad_html'])) {
            $data['ad_html'] = wp_kses_post($data['ad_html']); // 允许部分HTML标签
        }

        update_option('artdplayerjson', json_encode($data, JSON_UNESCAPED_UNICODE));
    }
}

}


class Artplayer_Admin_Media{

    static $add_script;
    public function __construct() {
        add_shortcode( 'artplayer', array( $this, 'artplayer_shortcode' ));
        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'add_script' ) );
    }


    public function artplayer_shortcode($atts, $content = null)
    {
    // 获取并设置默认值
    $atts = shortcode_atts(array(
        '_id' => get_the_ID(),
        'url' => '',
        'poster' => '',
        'width' => '100%',  // 默认宽度
        'height' => '500px',  // 默认高度
    ), $atts);

    // 解析视频链接URL列表
    $urls = explode(',', $atts['url']);
    $videoCount = count($urls);  // 视频数量
    $buttonsHtml = '';  // 集数按钮

    // 如果有多个视频链接，则生成集数按钮
    if ($videoCount > 1) {
        for ($i = 0; $i < $videoCount; $i++) {
            $buttonsHtml .= '<button class="video-button" data-video-url="' . esc_url(trim($urls[$i])) . '">第' . ($i + 1) . '集</button>';
        }
    }

    // 检查是否为B站视频
    $isBilibili = false;
    $bilibiliBvid = '';

    // 正则匹配B站视频URL
    foreach ($urls as $url) {
        if (preg_match('/bilibili\.com\/video\/(BV\w+)/', $url, $matches)) {
            $isBilibili = true;
            $bilibiliBvid = $matches[1];  // 提取BV号
            break;
        }
    }

    // 输出播放器HTML
    ob_start();

    // 如果是B站视频，生成iframe播放器
    if ($isBilibili) {
        ?>
        <div id="artplayer<?php echo $atts['_id']; ?>" class="artplayerbox" style="width:<?php echo $atts['width']; ?>;height:<?php echo $atts['height']; ?>">
            <iframe src="https://player.bilibili.com/player.html?bvid=<?php echo $bilibiliBvid; ?>&autoplay=0" scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true" style="width:100%; height:100%;"></iframe>
        </div>
        <?php
    } else {
        // 非B站视频按原来的方式加载播放器
        include WP_ARTDPLAYER_PATH . '/templates/artplayer.php';
    }

    return ob_get_clean();
    }
    

    public static function add_script() {
        if (!self::$add_script) {
            $artdplayerjson=get_option('artdplayerjson');
            if(empty($artdplayerjson)){
                return;
            }
            $artdplayer=json_decode($artdplayerjson,true);
            
            if((isset($artdplayer['enable_hls']) && $artdplayer['enable_hls']==1) || (isset($artdplayer['isLive']) && $artdplayer['isLive']==1)){ 
                wp_enqueue_script( 'arthls', WP_ARTDPLAYER_URL.'/assets/js/hls.min.js', false, false, false);
            }
            wp_enqueue_script( 'artplayer', WP_ARTDPLAYER_URL.'/assets/js/artplayer.js', false, false, false);

            // 加载广告插件
            if (isset($artdplayer['enable_ads']) && $artdplayer['enable_ads'] == 1) {
                wp_enqueue_script('artplayer-plugin-ads', WP_ARTDPLAYER_URL . '/assets/js/artplayer-plugin-ads.js', false, false, false);
            }

            self::$add_script = true;
        } 
    }
}


new Artplayer_Admin_Media();