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
    'default_access_token' => 'EAAUDo5ekHbQBAEbMuqLFK1ZASnRG3L6waa3AWDwZCIMdxfBcWogS4NPkLtLddZCUmZBCV52jAixQZA2rbZCb7nJSHF1zZAcb4YmqODEvfr8iYcgVxlqkXZBmrQ2Ry9LJa5GWh3xy6dEBPYldLjBYZAMnmZCrlvWC3A0WuOlJPuhVLDSwZDZD', // optional
]);

$response = $fb->get('/352286651772611?fields=feed{likes,message,full_picture},country_page_likes,about,name,photos,posts{story,id,likes},talking_about_count,username');
//$response = $fb->get('/352286651772611?fields=feed{likes,message,full_picture},country_page_likes');

$body = json_decode($response->getBody());

/* handle the result */


//var_dump($body);

/**
 *  Functions Api Facebook
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

       // query arguments

       $query_args = array(
           'post_type' => 'post',
           'post_per_list' => 10,
           'order' => 'DESC' //orderby : countlikePosts
       );

       // query

       $the_query = new WP_Query($query_args);

       // query loop

       if ($the_query->have_post()) {
           echo '<ul>';
           while ($the_query->have_post()) {
               $the_query->the_post();
               echo '<li>';
               echo 'test';  // doit afficher la function linkPost
               echo '</li>';
           }
           wp_reset_postdata();
           echo '</ul>';
       } else {
           echo __(" You don't have any post on your Facebook Page", "marketFB");
       }
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
