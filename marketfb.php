<?php
/*
 *  Plugin Name: Facebook Market Like
 *  Description: Facebook Market Like is a plugin that allows companies to display a widget with the most beloved items facebook
 *  Version: 0.1
 *  Author: Sharon Colin
 */
require_once __DIR__ . '/facebook-sdk-v5/src/Facebook/autoload.php';
/**
 *  Translation Function
 */

load_plugin_textdomain( 'marketFb', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );

/**
 *  Functions
 */

