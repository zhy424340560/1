<?php

define('KRATOS_VERSION','0.4.3');

require_once(get_template_directory().'/inc/core.php');
require_once(get_template_directory().'/inc/shortcode.php');
require_once(get_template_directory().'/inc/imgcfg.php');
require_once(get_template_directory().'/inc/post.php');
require_once(get_template_directory().'/inc/ua.php');
require_once(get_template_directory().'/inc/widgets.php');
require_once(get_template_directory().'/inc/smtp.php');
require_once(get_template_directory().'/inc/logincfg.php');
require_once(get_template_directory().'/inc/avatars.php');

function remove_logo($wp_toolbar) {	$wp_toolbar->remove_node('wp-logo'); }add_action('admin_bar_menu', 'remove_logo', 999);

add_filter('admin_footer_text', 'left_admin_footer_text');
function left_admin_footer_text($text) {
$text = '开心分享';
return $text;
}
add_filter('update_footer', 'right_admin_footer_text', 11);
function right_admin_footer_text($text) {
}

/*****************************************************
函数名称：wp_login_notify
函数作用：有登录wp后台就会email通知博主
******************************************************/
function wp_login_notify()
{
date_default_timezone_set('PRC');
$admin_email = get_bloginfo ('admin_email');
$to = $admin_email;
$subject = '你的博客空间登录提醒';
$message = '<p>你好！你的博客空间(' . get_option("blogname") . ')有登录！</p>' .
'<p>请确定是您自己的登录，以防别人攻击！登录信息如下：</p>' .
'<p>登录名：' . $_POST['log'] . '<p>' .
'<p>登录密码：' . $_POST['pwd'] .  '<p>' .
'<p>登录时间：' . date("Y-m-d H:i:s") .  '<p>' .
'<p>登录IP：' . $_SERVER['REMOTE_ADDR'] . '<p>';
$wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
$from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
wp_mail( $to, $subject, $message, $headers );
}
 
add_action('wp_login', 'wp_login_notify');


/**

 * WordPress 去除后台标题中的“—— WordPress”

 */

add_filter('admin_title', 'wpdx_custom_admin_title', 10, 2);

function wpdx_custom_admin_title($admin_title, $title){

    return $title.' ‹ '.get_bloginfo('name');
}




//Wordpress 5.0+ 禁用 Gutenberg 编辑器
add_filter('use_block_editor_for_post', '__return_false');
remove_action( 'wp_enqueue_scripts', 'wp_common_block_scripts_and_styles' );


