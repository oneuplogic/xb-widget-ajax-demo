<?php
/*
   Plugin Name: Xb Ajax Widget Demo
   Plugin URI: http://www.explodybits.com/2011/11/wordpress-ajax-widgets/
   Description: Demo of creating Ajax enabled widgets, using the Xb_Ajax_Widget class.
	Author: Matthew Hail (OneUpLogic)
	Version: 0.1
	Author URI: http://www.explodybits.com/
 * 
 * 
 */


/**
 * plugins_loaded action callback
 * @return void 
 */
function xb_ajaxwidgetdemo_plugins_loaded() {
    
    // Load the XB_Ajax_Widget class
    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'xb-widget-ajax.php';
    
    // Load our custom widgets. 
    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'widgets.php';
    
    // Add action hook to add our custom widget
    add_action('widgets_init', 'xb_ajaxwidgetdemo_widgets_init');
    
    // Add action hook to enqueue jQuery javascript framework
    add_action('wp_enqueue_scripts', 'xb_ajaxwidgetdemo_wp_enqueue_scripts');
    
    // The load method needs called in the plugin load to add the init action callback
    Xb_Widget_Ajax::load();
}

// Add our action callback to the plugins_loaded action. 
// See: http://codex.wordpress.org/Plugin_API/Action_Reference#Actions_Run_During_a_Typical_Request
add_action( 'plugins_loaded', 'xb_ajaxwidgetdemo_plugins_loaded' );

/**
 * widgets_init action callback
 * @uses register_widget
 */
function xb_ajaxwidgetdemo_widgets_init() {
    register_widget( 'Xb_Widget_Ajax_Demo' );
}

/**
 * wp_enqueue_scripts action callback
 * @uses wp_enqueue_script
 */
function xb_ajaxwidgetdemo_wp_enqueue_scripts() {
    // enqueue the included no-conflicts jQuery framework
    // See: http://codex.wordpress.org/Function_Reference/wp_enqueue_script#Default_scripts_included_with_WordPress
    wp_enqueue_script( 'jquery' );
}