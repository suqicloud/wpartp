<?php
/**
 * Plugin Name: Artplayer HTML5播放器
 * Plugin URI: https://www.jingxialai.com/4950.html
 * Description: 基于Artplayer的播放器支持mp4和m3u8格式视频，可以设置广告，播放器的大部分功能控件支持自定义。
 * Author: Summer
 * Author URI: https://www.jingxialai.com/
 * Version: 1.3
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

define( 'WP_ARTDPLAYER_VERSION', '1.3' );
define( 'WP_ARTDPLAYER_PATH', realpath( plugin_dir_path( __FILE__ ) ) . '/' );
define( 'WP_ARTDPLAYER_INC_PATH', realpath( WP_ARTDPLAYER_PATH . 'inc/' ) . '/' );
define( 'WP_ARTDPLAYER_URL', plugin_dir_url( __FILE__ ) );

$file=WP_ARTDPLAYER_PATH .'config.php';
if(file_exists($file)){
  include $file;//载入配置
}
require_once WP_ARTDPLAYER_INC_PATH . 'main.php';

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

// 经典编辑器快捷键
function wp_artplayer_register_tinymce_plugin($plugin_array) {
    $plugin_array['wp_artplayer_button'] = plugin_dir_url(__FILE__) . '/assets/js/artplayer-tinymce.js';
    return $plugin_array;
}

function wp_artplayer_add_tinymce_button($buttons) {
    array_push($buttons, 'wp_artplayer_button');
    return $buttons;
}

function wp_artplayer_add_tinymce_plugin() {
    if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
        return;
    }

    if (get_user_option('rich_editing') !== 'true') {
        return;
    }

    add_filter('mce_external_plugins', 'wp_artplayer_register_tinymce_plugin');
    add_filter('mce_buttons', 'wp_artplayer_add_tinymce_button');
}

add_action('init', 'wp_artplayer_add_tinymce_plugin');
// 经典编辑器快捷键结束