<?php
/*
Plugin Name: Check Product
Description: Plugin hỗ trợ tạo, kiểm tra mã sản phẩm
Version: 1.0
Author: ZhangShang
*/

// Include pl-functions.php, use require_once to stop the script if pl-functions.php is not found
//require_once plugin_dir_path(__FILE__) . 'includes/pl-functions.php';
include plugin_dir_path(__FILE__) . 'views/create-code.php';

add_action( 'admin_menu', 'SetupMenu' );

function SetupMenu(){
	add_menu_page(
	 'Code', // Title of the page
	 'Code Product', // Text to show on the menu link
	 'manage_options', // Capability requirement to see the link
	 'create-code-product', // The 'slug' - file to display when clicking the link
	 'PageCreateCode'
	 );
}

add_action('admin_enqueue_scripts', 'wp_include_admin_js');

function wp_include_admin_js()
{
	wp_register_script( 'jquery-3.5.1.js', plugins_url("js/jquery-3.5.1.min.js",__FILE__) , array() );
	wp_enqueue_script( 'jquery-3.5.1.js' );
}
