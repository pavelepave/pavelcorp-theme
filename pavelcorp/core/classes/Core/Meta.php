<?php
Namespace PavelcorpCore;
/**
* Meta
*/
class Meta
{
    
    function __construct($name, $description, $post_type, $options = array())
    {
        $this->name = $name;
        $this->description = $description;
        $this->post_type = $post_type;
        $this->options = $options;
        $this->nonce = str_replace('_meta', '', $this->name) . '_nonce';

        $this->init();

    }

    private function init()
    {
        add_action( 'add_meta_boxes', array( $this, 'exec'));
        add_action( 'save_post', array( $this, 'save' ) );
        add_filter( 'rest_prepare_' . $this->post_type, array( $this, 'register_meta' ), 10, 3 );
    }

    public function register_meta($response, $post) {
        $response->data[$this->name] = '';
        $meta = get_post_meta($post->ID, $this->name, true);

        if ($meta) {
            $response->data[$this->name] = $meta;
        }
        return $response;
        // register_meta($this->post_type, $this->name, array(
        //     'show_in_rest' => true,
        // ));
    }

    private function save_meta( $post_id, $meta_name, $nonce )
    {
        // verify nonce
        /*if ( !wp_verify_nonce( $_POST[$nonce], 'my-action_'.$post_id ) ) {
            return $post_id; 
        }*/
        // check autosave
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
        // check permissions
        if ( isset($_POST['post_type']) && 'page' === $_POST['post_type'] ) {
            if ( !current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            } elseif ( !current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }  
        }
        $old = get_post_meta( $post_id, $meta_name, true );
        $new = (isset($_POST[$meta_name]) && !empty($_POST[$meta_name])) ? $_POST[$meta_name] : '';

        if ( $new && $new !== $old ) {
            update_post_meta( $post_id, $meta_name, $new );
        } elseif ( '' === $new && $old ) {
            delete_post_meta( $post_id, $meta_name, $old );
        }
    }

    public function save($post_id) {
        return $this->save_meta($post_id, $this->name, $this->nonce);
    }

    public function exec() 
    {
        global $post;

        if ( $this->post_type == 'page') {

            $page_template = get_post_meta($post->ID, '_wp_page_template', true);

            if ( is_array( $this->options ) && isset( $this->options['template'] )  ) 
            {
                if ($page_template == $this->options['template']) {
                    add_meta_box(
                        $this->name, // $id
                        $this->description, // $title
                        array( $this, 'show_meta' ), // $callback
                        $this->post_type, // $screen
                        'normal', // $context
                        'high' // $priority
                    );
                }
            } else {
                add_meta_box(
                    $this->name, // $id
                    $this->description, // $title
                    array( $this, 'show_meta' ), // $callback
                    $this->post_type, // $screen
                    'normal', // $context
                    'high' // $priority
                );
            }
        } else {
            add_meta_box(
                $this->name, // $id
                $this->description, // $title
                array( $this, 'show_meta' ), // $callback
                $this->post_type, // $screen
                'normal', // $context
                'high' // $priority
            );
        }
        
    }

}