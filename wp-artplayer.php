<?php
/**
 * Plugin Name: Art HTML5播放器
 * Plugin URI: https://www.jingxialai.com/4950.html
 * Description: 基于Artplayer的播放器支持mp4和m3u8格式视频，播放器的大部分功能控件支持自定义。
 * Author: Summer
 * Author URI: https://www.jingxialai.com/
 * Version: 1.2
 * Text Domain: wp-crontrol
 * Domain Path: /languages/
 * Requires PHP: 8.0
 * License: GPL v2 or later
 *
 * 原版：https://github.com/oyjcmyn/wp-artplayer
 * 
 * LICENSE
 * This file is part of WP Crontrol.
 *
 * WP Crontrol is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

defined( 'ABSPATH' ) || exit;

define( 'WP_ARTDPLAYER_VERSION', '1.2' );
define( 'WP_ARTDPLAYER_PATH', realpath( plugin_dir_path( __FILE__ ) ) . '/' );
define( 'WP_ARTDPLAYER_INC_PATH', realpath( WP_ARTDPLAYER_PATH . 'inc/' ) . '/' );
define( 'WP_ARTDPLAYER_URL', plugin_dir_url( __FILE__ ) );

$file=WP_ARTDPLAYER_PATH .'config.php';
if(file_exists($file)){
  include $file;//载入配置
}
require_once WP_ARTDPLAYER_INC_PATH . 'main.php';

register_activation_hook( __FILE__, array( 'ART_MAIN_MI', 'install' ) );

add_action( 'plugins_loaded', 'artplayer_load_textdomain');
function artplayer_load_textdomain() {
        // prefix
        $prefix = basename( dirname( plugin_basename( __FILE__ ) ) );
        $locale = get_locale();
        $dir    = WP_ARTDPLAYER_PATH.'/languages';
        $mofile = false;

        $globalFile = WP_LANG_DIR . '/plugins/' . $prefix . '-' . $locale . '.mo';
        $pluginFile = $dir . '/artplayer-'. $locale . '.mo';

        if ( file_exists( $globalFile ) ) {
            $mofile = $globalFile;
        } else if ( file_exists( $pluginFile ) ) {
            $mofile = $pluginFile;
        }

        if ( $mofile ) {
            load_textdomain( 'wpartplayer', $mofile );
        }
}

// 在插件中心添加设置链接
function artplayer_add_settings_link($links) {
    $settings_link = '<a href="admin.php?page=artplayerset">设置</a>';
    array_push($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'artplayer_add_settings_link');


// 菜单入口
function artplayer_menu(){
    add_menu_page('artplayer','Art播放器', 'manage_options', 'artplayerset' ,'artplayerset', 'dashicons-format-video', 80);
    
}
add_action("admin_menu","artplayer_menu");

function artplayerset(){
    include WP_ARTDPLAYER_INC_PATH . 'admin.php';
}   