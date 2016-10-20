<?php

class PopularFbPosts extends WP_Widget {
    /***** Register widget with Wordpress. ******/
    function __construct() {
        parent::__construct(
            'popularFbPosts',
            __( 'Popular Facebook Posts', 'marketFb' ),
                array( 'description' => __( 'The ten most liked posts on the facebook page', 'marketFb' ),
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

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $args['before_widget'];

        if ( !empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $fb = new Fb();
        $fb->linkPost();

        echo $args['after_widget'];
    }

    /**
    *	Back-end widget form.
    *	@see WP_Widget::form()
    *
    *	@param array $instance Previously saved values from database.
    */

    public function form( $instance ) {
        if ( isset( $instance['title'] ) ) {
            $title = $instance['title'];
        } else {
            $title = __( "Popular Facebook Posts", "marketFB" );
        }

        ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'marketFb' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
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

    public function updateTitle( $new_instance ) {
        $instance          = array();
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : "";
        return $instance;
    }
}