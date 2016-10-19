<?php
/*
 *  Plugin Name: Facebook Market Like
 *  Description: Facebook Market Like is a plugin that allows companies to display a widget with the most beloved items facebook
 *  Version: 0.1
 *  Author: Sharon Colin
 */
require_once __DIR__ . '/php-graph-sdk-master/src/Facebook/autoload.php';


$fb = new Facebook\Facebook([
    'app_id' => '1411376042220980',
    'app_secret' => '463e680acb1012c7ae26dee6c19e35a6',
    'default_graph_version' => 'v2.5',
    'default_access_token' => 'EAAUDo5ekHbQBAKVSKdSNp3XsS4ZAQ09Uce7RvFMj1L6ECGS4cdhYLX3UrQi46E9k9DMsBT1femmfVtOmqWcxXRM0kKW3BVWABjYw6w8evvXOS2hSf7CkA6WKLCk4Ki3RQiD4fW1gIfcguO1uRZB72z1Iv6zD4SbBicAYbsagZDZD', // optional
]);

$response = $fb->get('/352286651772611?fields=feed{likes,message,full_picture},country_page_likes,about,name,photos,posts{story,id,likes},talking_about_count,username');
//$response = $fb->get('/352286651772611?fields=feed{likes,message,full_picture},country_page_likes');

$body = json_decode($response->getBody());

/* handle the result */


//var_dump($body);

/**
 *  Functions
 */

function countLikesPost($body)
{
    foreach (($body->posts->data) as $value) {
        $count = count($value->likes->data);

        echo '<div>' . $count . '</div>';
    }
}

//echo countLikesPost($body);


function linkPost($body){
    foreach(($body->posts->data) as $posts){
        $idPost = $posts->id;
        $titlePost = $posts->story;
        echo '<a href=http://www.facebook.com/'.$idPost.'> '.$titlePost.' </a> <br/>';
    }
}

//echo linkPost($body);


//die();


/* handle the result */

/**
 *  Translation Function
 */

//load_plugin_textdomain( 'marketFb', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );


