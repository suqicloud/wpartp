<div class='wrap' id='dplayer-options'>
    <h2>Artplaye <?php _e('播放器设置','wpartplayer'); ?></h2>
    <form id='dplayer-for-wordpress' name='dplayer-for-wordpress' action='' method='POST'>
        <?php wp_nonce_field( 'mi_artplayer_save_action', 'mi_artplayer_save_field', true ); ?>
    <table class='form-table'>
        <?php  
        if ( isset( $_POST['mi_artplayer_save_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mi_artplayer_save_field'] ) ), 'mi_artplayer_save_action' )) {
            echo "<div class='updated settings-error' id='etting-error-settings_updated'><p><strong>".__('保存成功','wpartplayer')."</strong></p></div>\n";
            ART_MAIN_MI::save_options();
        }
        $artdplayerjson=get_option('artdplayerjson');
        $artdplayer=json_decode($artdplayerjson,true);
        ?>

        <tr>
        <th scope="row"><?php _e('开启','wpartplayer'); ?> hls.js</th>
        <td> <fieldset><legend class="screen-reader-text"></legend>
            <label for="enable_hls">
                <input name="enable_hls" type="checkbox" id="enable_hls" value="1" <?php if(isset( $artdplayer['enable_hls']) && $artdplayer['enable_hls']==1)echo 'checked'; ?>>
            <?php _e('实时视频（HTTP Live Streaming，M3U8 格式）支持','wpartplayer'); ?></label>
        </fieldset></td>
        </tr>

        <tr>
        <th scope="row"><?php _e('直播模式','wpartplayer'); ?></th>
        <td> <fieldset><legend class="screen-reader-text"></legend>
            <label for="isLive">
                <input name="isLive" type="checkbox" id="isLive" value="1" <?php if(isset( $artdplayer['isLive']) && $artdplayer['isLive']==1)echo 'checked'; ?>>
             <?php _e('使用直播模式，会隐藏进度条和播放时间','wpartplayer'); ?></label>
        </fieldset></td>
        </tr>

        <tr>
        <th scope="row"><label for="theme"><?php _e('播放器主题色','wpartplayer'); ?></label></th>
        <td><input name="theme" type="text" id="theme" value="<?php if(isset( $artdplayer['theme'])){echo $artdplayer['theme'];}else{echo '#ffad00';} ?>" class="regular-text"><p class="description"><?php _e('播放器主题颜色，目前只作用于进度条上。例如：#ffad00','wpartplayer'); ?></p></td>
        
        </tr>

        <tr>
        <th scope="row"><label for="volume"><?php _e('默认音量','wpartplayer'); ?></label></th>
        <td><input name="volume" type="text" id="volume" value="<?php if(isset( $artdplayer['volume'])){echo $artdplayer['volume'];}else{echo '0.7';} ?>" class="regular-text"><p class="description"><?php _e('播放器的默认音量：0-1范围','wpartplayer'); ?></p></td>
        </tr>

        <tr>
        <th scope="row"><?php _e('开启静音','wpartplayer'); ?></th>
        <td> <fieldset><legend class="screen-reader-text"></legend>
            <label for="muted">
                <input name="muted" type="checkbox" id="muted" value="1" <?php if(isset( $artdplayer['muted']) && $artdplayer['muted']==1)echo 'checked'; ?>>
            <?php _e('开启静音','wpartplayer'); ?></label>
        </fieldset></td>
        </tr>

        <tr>
        <th scope="row"><?php _e('自动播放','wpartplayer'); ?></th>
        <td> <fieldset><legend class="screen-reader-text"></legend>
            <label for="autoplayone">
                <input name="autoplayone" type="checkbox" id="autoplayone" value="1" <?php if(isset( $artdplayer['autoplayone']) && $artdplayer['autoplayone']==1)echo 'checked'; ?>>
             <?php _e('启用后，视频自动播放','wpartplayer'); ?></label>
        </fieldset></td>
        </tr>

        <tr>
        <th scope="row"><?php _e('循环播放','wpartplayer'); ?></th>
        <td> <fieldset><legend class="screen-reader-text"></legend>
            <label for="loop">
                <input name="loop" type="checkbox" id="loop" value="1" <?php if(isset( $artdplayer['loop']) && $artdplayer['loop']==1)echo 'checked'; ?>>
            <?php _e('循环播放','wpartplayer'); ?></label>
        </fieldset></td>
        </tr>


        <tr>
        <th scope="row"><?php _e('迷你播放模式','wpartplayer'); ?></th>
        <td> <fieldset><legend class="screen-reader-text"></legend>
            <label for="autoMini">
                <input name="autoMini" type="checkbox" id="autoMini" value="1" <?php if(isset( $artdplayer['autoMini']) && $artdplayer['autoMini']==1)echo 'checked'; ?>>
             <?php _e('当播放器滚动到浏览器视口以外时，自动进入迷你播放模式','wpartplayer'); ?></label>
        </fieldset></td>
        </tr>

        <tr>
        <th scope="row"><?php _e('显示播放速度','wpartplayer'); ?></th>
        <td> <fieldset><legend class="screen-reader-text"></legend>
            <label for="playbackRate">
                <input name="playbackRate" type="checkbox" id="playbackRate" value="1" <?php if(isset( $artdplayer['playbackRate']) && $artdplayer['playbackRate']==1)echo 'checked'; ?>>
            <?php _e('是否显示视频播放速度功能，会出现在设置面板和右键菜单里','wpartplayer'); ?></label>
        </fieldset></td>
        </tr>

        <tr>
        <th scope="row"><?php _e('截图功能','wpartplayer'); ?></th>
        <td> <fieldset><legend class="screen-reader-text"></legend>
            <label for="screenshot">
                <input name="screenshot" type="checkbox" id="screenshot" value="1" <?php if(isset( $artdplayer['screenshot']) && $artdplayer['screenshot']==1)echo 'checked'; ?>>
            <?php _e('是否在底部控制栏里显示视频截图功能','wpartplayer'); ?></label>
        </fieldset></td>
        </tr>

        <tr>
        <th scope="row"><?php _e('画中画','wpartplayer'); ?></th>
        <td> <fieldset><legend class="screen-reader-text"></legend>
            <label for="pip">
                <input name="pip" type="checkbox" id="pip" value="1" <?php if(isset( $artdplayer['pip']) && $artdplayer['pip']==1)echo 'checked'; ?>>
            <?php _e('是否在底部控制栏里显示画中画的开关按钮','wpartplayer'); ?></label>
        </fieldset></td>
        </tr>

        <tr>
        <th scope="row"><?php _e('网页全屏','wpartplayer'); ?></th>
        <td> <fieldset><legend class="screen-reader-text"></legend>
            <label for="fullscreenWeb">
                <input name="fullscreenWeb" type="checkbox" id="fullscreenWeb" value="1" <?php if(isset( $artdplayer['fullscreenWeb']) && $artdplayer['fullscreenWeb']==1)echo 'checked'; ?>>
            <?php _e('是否在控制栏中显示网页全屏功能','wpartplayer'); ?></label>
        </fieldset></td>
        </tr>

        <tr>
        <th scope="row"><?php _e('视频翻转','wpartplayer'); ?></th>
        <td> <fieldset><legend class="screen-reader-text"></legend>
            <label for="flip">
                <input name="flip" type="checkbox" id="flip" value="1" <?php if(isset( $artdplayer['flip']) && $artdplayer['flip']==1)echo 'checked'; ?>>
            <?php _e('是否在控制栏设置中显示视频翻转功能','wpartplayer'); ?></label>
        </fieldset></td>
        </tr>

        <tr>
        <th scope="row"><?php _e('迷你进度条','wpartplayer'); ?></th>
        <td> <fieldset><legend class="screen-reader-text"></legend>
            <label for="miniProgressBar">
                <input name="miniProgressBar" type="checkbox" id="miniProgressBar" value="1" <?php if(isset( $artdplayer['miniProgressBar']) && $artdplayer['miniProgressBar']==1)echo 'checked'; ?>>
            <?php _e('迷你进度条，只在播放器失去焦点后且正在播放时出现','wpartplayer'); ?></label>
        </fieldset></td>
        </tr>

        <tr>
        <th scope="row"><?php _e('锁定按钮','wpartplayer'); ?></th>
        <td> <fieldset><legend class="screen-reader-text"></legend>
            <label for="lock">
                <input name="lock" type="checkbox" id="lock" value="1" <?php if(isset( $artdplayer['lock']) && $artdplayer['lock']==1)echo 'checked'; ?>>
            <?php _e('是否在移动端显示一个锁定按钮，用于隐藏底部控制栏','wpartplayer'); ?></label>
        </fieldset></td>
        </tr>

        <tr>
        <th scope="row"><?php _e('长按视频快进','wpartplayer'); ?></th>
        <td> <fieldset><legend class="screen-reader-text"></legend>
            <label for="fastForward">
                <input name="fastForward" type="checkbox" id="fastForward" value="1" <?php if(isset( $artdplayer['fastForward']) && $artdplayer['fastForward']==1)echo 'checked'; ?>>
            <?php _e('是否在移动端添加长按视频快进功能','wpartplayer'); ?></label>
        </fieldset></td>
        </tr>

        <tr>
        <th scope="row"><?php _e('自动回放','wpartplayer'); ?></th>
        <td> <fieldset><legend class="screen-reader-text"></legend>
            <label for="autoPlayback">
                <input name="autoPlayback" type="checkbox" id="autoPlayback" value="1" <?php if(isset( $artdplayer['autoPlayback']) && $artdplayer['autoPlayback']==1)echo 'checked'; ?>>
        <?php _e('是否使用自动回放功能','wpartplayer'); ?></label>
        </fieldset></td>
        </tr>

        <tr>
        <th scope="row"><?php _e('移动端旋转播放器','wpartplayer'); ?></th>
        <td> <fieldset><legend class="screen-reader-text"></legend>
            <label for="autoOrientation">
                <input name="autoOrientation" type="checkbox" id="autoOrientation" value="1" <?php if(isset( $artdplayer['autoOrientation']) && $artdplayer['autoOrientation']==1)echo 'checked'; ?>>
            <?php _e('是否在移动端的网页全屏时，根据视频尺寸和视口尺寸，旋转播放器','wpartplayer'); ?></label>
        </fieldset></td>
        </tr>

        <tr>
        <th scope="row">airplay</th>
        <td> <fieldset><legend class="screen-reader-text"></legend>
            <label for="airplay">
                <input name="airplay" type="checkbox" id="airplay" value="1" <?php if(isset( $artdplayer['airplay']) && $artdplayer['airplay']==1)echo 'checked'; ?>>
            <?php _e('是否显示 airplay 按钮，当前只在 Safari 下可用','wpartplayer'); ?></label>
        </fieldset></td>
        </tr>


        <tr>
        <th scope="row"><?php _e('开启广告功能', 'wpartplayer'); ?></th>
        <td><fieldset><legend class="screen-reader-text"></legend>
            <label for="enable_ads">
                <input name="enable_ads" type="checkbox" id="enable_ads" value="1" <?php if (isset($artdplayer['enable_ads']) && $artdplayer['enable_ads'] == 1) echo 'checked'; ?>>
            <?php _e('开启广告功能', 'wpartplayer'); ?>
        </label>
        </fieldset></td>
        </tr>

        <tr>
        <th scope="row"><label for="ad_html"><?php _e('HTML广告内容', 'wpartplayer'); ?></label></th>
        <td>
        <textarea name="ad_html" id="ad_html" rows="3" class="large-text" style="width: 60%"><?php if (isset($artdplayer['ad_html'])) { echo esc_textarea($artdplayer['ad_html']); } ?></textarea>
        <p class="description"><?php _e('请输入广告的HTML内容，只支持部分html标签', 'wpartplayer'); ?> 例如：&lt;img src="图片地址"/&gt;</p>
        </td>
        </tr>

        <tr>
        <th scope="row"><label for="ad_video"><?php _e('视频广告URL', 'wpartplayer'); ?></label></th>
        <td><input name="ad_video" type="text" id="ad_video" value="<?php if (isset($artdplayer['ad_video'])) { echo esc_url($artdplayer['ad_video']); } ?>" class="regular-text" style="width: 50%;">
        <p class="description"><?php _e('输入视频广告的视频URL，视频广告和HTML广告内容二选一。', 'wpartplayer'); ?></p>
        </td>
        </tr>

        <tr>
        <th scope="row"><label for="ad_url"><?php _e('广告跳转网址', 'wpartplayer'); ?></label></th>
        <td><input name="ad_url" type="text" id="ad_url" value="<?php if (isset($artdplayer['ad_url'])) { echo esc_url($artdplayer['ad_url']); } ?>" class="regular-text">
        <p class="description"><?php _e('广告被点击后跳转的网址，留空则不跳转。', 'wpartplayer'); ?></p>
        </td>
        </tr>

        <tr>
        <th scope="row"><label for="ad_play_duration"><?php _e('必看时长（秒）', 'wpartplayer'); ?></label></th>
        <td><input name="ad_play_duration" type="number" id="ad_play_duration" value="<?php if (isset($artdplayer['ad_play_duration'])) { echo esc_attr($artdplayer['ad_play_duration']); } ?>" class="regular-text">
        <p class="description"><?php _e('广告必须播放的最短时间，单位为秒。', 'wpartplayer'); ?></p>
        </td>
        </tr>

        <tr>
        <th scope="row"><label for="ad_total_duration"><?php _e('广告总时长（秒）', 'wpartplayer'); ?></label></th>
        <td><input name="ad_total_duration" type="number" id="ad_total_duration" value="<?php if (isset($artdplayer['ad_total_duration'])) { echo esc_attr($artdplayer['ad_total_duration']); } ?>" class="regular-text">
        <p class="description"><?php _e('广告的总时长，单位为秒。', 'wpartplayer'); ?></p>
        </td>
        </tr>

        
        <caption class='screen-reader-text'>Artplayer<?php _e('setting','wpartplayer'); ?></caption>
    </table>
    <p class="submit"><input type="submit" class="button button-primary" value="<?php _e('保存设置','wpartplayer'); ?>"/></p>
    </form>
</div>