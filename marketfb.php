<?php
/*
 *  Plugin Name: Facebook Market Like
 *  Description: Facebook Market Like is a plugin that allows companies to display a widget with the most beloved items facebook
 *  Version: 1.0
 *  Author: Sharon Colin
 */
require_once __DIR__ . '/php-graph-sdk-master/src/Facebook/autoload.php';

require_once( 'Fb.php' );

/**
 *  Translation Function
 */

load_plugin_textdomain( 'marketFb', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );


/**
 *  Creation du widget
 */

require_once( 'PopularFbPosts.php' );

function register_popularFbPosts_widget() {
    register_widget( 'popularFbPosts' );
}

add_action( 'widgets_init', 'register_popularFbPosts_widget' );
