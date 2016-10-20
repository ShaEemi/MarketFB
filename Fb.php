<?php

class Fb {

    public $body;

    function __construct() {
        $fb = new Facebook\Facebook( [
            'app_id'                => '1411376042220980',
            'app_secret'            => '463e680acb1012c7ae26dee6c19e35a6',
            'default_graph_version' => 'v2.5',
            'default_access_token'  => 'EAAUDo5ekHbQBAGY32O94OgZBxdjeXOOIk3dOPDzHFkYGJOMnN0FZBaGiXZB0ZCa4DFQNgG9D697dn5xu6O3Sg3wxGvZBcq4ONl0IRAW3OX9cGvL48Pde3YO0Mrk0V1MtyCrW45N2IKZBx6ZBDJ9cf5rcTR0yqvxfRc1tBmbFsPeOgZDZD', // optional
        ] );
        $response   = $fb->get('/352286651772611?fields=feed{likes,message,full_picture},country_page_likes,about,name,photos,posts.limit(10){story,id,likes},talking_about_count,username');
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

