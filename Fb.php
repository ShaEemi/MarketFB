<?php

class Fb {

    public $body;

    function __construct() {
        $fb = new Facebook\Facebook( [
            'app_id'                => '{app_id}',
            'app_secret'            => '{secret_key}',
            'default_graph_version' => 'v2.5',
            'default_access_token'  => '{user_token}',
        ] );
        $response   = $fb->get('/{page_id}?fields=feed{likes,message,full_picture},country_page_likes,about,name,photos,posts.limit(10){story,id,likes},talking_about_count,username');
        $this->body = json_decode( $response->getBody() );
    }


    /**
    *  Functions Api Facebook
    */


    function linkPost() {
        $pikachu = array();
        foreach ( ( $this->body->posts->data ) as $posts ) {
            $pikachu[] = array(
                'nb_like' => count($posts->likes->data),
                'posts'   => $posts
            );
        }
        usort( $pikachu, array( $this, 'comparison' ) );
        foreach ( $pikachu as $pika ) {
            echo '<a href=http://www.facebook.com/'.$pika['posts']->id.'> '. $pika['posts']->story.' </a> <br/>';
        }
    }

    function comparison( $a, $b ) {
        return $a['nb_like'] < $b['nb_like'];
    }
}

