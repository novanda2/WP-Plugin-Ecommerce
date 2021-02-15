<?php

class CheckoutPage
{
    public $post_title = "Checkout";

    public function __construct()
    {
        $this->init();

        add_filter('page_template', [$this, 'set_single_template']);
    }

    public function init()
    {
        register_activation_hook(PLUGIN_WITH_CLASSES__FILE__,  function () {
            wp_insert_post(array('post_type' => 'page', 'post_title' => $this->post_title, 'post_status' => 'publish'));
        });
    }

    function set_single_template($template)
    {
        global $post;

        if ($post->post_type = 'page' && $post->post_title == $this->post_title)
            return PLUGIN_DIR . 'templates/pages/page-checkout.php';

        return $template;
    }
}


// delete post
 // function delete_all_posts_from_author($post)
        // {


        //     global $post;
        //     $id = $post->ID;
        //     if (get_post_type($id) == "page") {

        //         $posts = get_posts(
        //             array(
        //                 'posts_per_page'    => -1,
        //                 'post_status'       => 'publish',
        //                 'post_type'         => 'page',
        //             )
        //         );

        //         foreach ($posts as $post) {
        //             if ($post->post_title === "Checkout")
        //                 wp_delete_post($post->ID, true);
        //         }
        //     }
        // }

        // add_action('the_post',  'delete_all_posts_from_author', 10, 1);