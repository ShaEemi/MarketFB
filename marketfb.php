<?php
/*
 *  Plugin Name: Facebook Market Like
 *  Description: Facebook Market Like is a plugin that allows companies to display a widget with the most beloved items facebook
 *  Version: 0.1
 *  Author: Sharon Colin
 */
require_once __DIR__ . '/php-graph-sdk-master/src/Facebook/autoload.php';


class fb {

    public $body;

    function __construct(){
        $fb = new Facebook\Facebook([
            'app_id' => '1411376042220980',
            'app_secret' => '463e680acb1012c7ae26dee6c19e35a6',
            'default_graph_version' => 'v2.5',
            'default_access_token' => 'EAAUDo5ekHbQBAN5fa7ZAg06y1lMZA3Job66A6Ghfkktyd1jG4ZBD8roJsx4HkjQpv6ePQuOraqhV3WmcY9SVp2ZCStmChgp67wbdRgZBaxv1AvxCcGBZAATSXFBaWPhaCnB6KHB3ROHs8mPcnz0Exapv4MvZBdqqoxN1d82OpM4BAZDZD', // optional
        ]);

        $response = $fb->get('/352286651772611?fields=feed{likes,message,full_picture},country_page_likes,about,name,photos,posts{story,id,likes},talking_about_count,username');


        $this->body = json_decode($response->getBody());
    }

    /* handle the result */


//var_dump($body);

    /**
     *  Functions Api Facebook
     */


    function linkPost(){
        $pikachu = array();
        foreach(($this->body->posts->data) as $posts){

            $pikachu[] = array(
                'nb_like' => count($posts->likes->data), 'posts' => $posts
            );



//            $idPost = $posts->id;
//            $titlePost = $posts->story;
//            echo '<a href=http://www.facebook.com/'.$idPost.'> '.$titlePost.' </a> <br/>';
        }
        usort($pikachu, array($this, 'comparison'));
        $postTitle = $pikachu;
        var_dump($pikachu);

       // echo '<pre>' . print_r($pikachu,1).'</pre>';
        //echo '<p>'. $postTitle .'</p>';
    }

    function comparison($a, $b){
        return $a['nb_like'] < $b['nb_like'];
    }
}

//echo linkPost($body);


//die();



/**
 *  Translation Function
 */

load_plugin_textdomain( 'marketFb', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );


/**
 *  Creation du widget
 */

class popularFbPosts extends WP_Widget {
    /***** Register widget with Wordpress. ******/
    function __construct(){
        parent::__construct(
          'popularFbPosts',
          __('Popular Facebook Posts','marketFb'),
          array('description' => __('The ten most liked posts on the facebook page', 'marketFb'),
          )
        );
    }

    /**
     *	Fond-end display of widget.
     *	@see WP_Widget::widget()
     *
     *	@param array $args   Widget arguments.
     *	@param array $instance Saved values from database.
     */

   public function widget($args, $instance)
   {

       $title = apply_filters('widget_title', $instance['title']);
       echo $args['before_widget'];
       if (!empty($title)) {
           echo $args['before_title'] . $title . $args['after_title'];
       }



       $fb = new fb();


       $fb->linkPost();



       echo $args['after_widget'];
   }

    /**
     *	Back-end widget form.
     *	@see WP_Widget::form()
     *
     *	@param array $instance Previously saved values from database.
     */

   public function form($instance){
        if(isset($instance['title'])){
            $title = $instance['title'];
        }else{
            $title = __("Popular Facebook Post", "marketFB");
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title: ', 'marketFB'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']) ;?>"/>
        </p>
    <?php
   }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */

    public function updateTitle($new_instance, $old_instance){
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']): "";
        return $instance;
    }
}

function register_popularFbPosts_widget(){
    register_widget('popularFbPosts');
}

add_action('widgets_init', 'register_popularFbPosts_widget');
