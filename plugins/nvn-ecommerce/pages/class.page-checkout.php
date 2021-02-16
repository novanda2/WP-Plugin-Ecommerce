<?php

class CheckoutPage
{
    public $id = 9991;
    public $post_title = "Checkout";

    public function __construct()
    {
        register_activation_hook(PLUGIN_WITH_CLASSES__FILE__, [$this, 'init']);
        register_deactivation_hook(PLUGIN_WITH_CLASSES__FILE__, [$this, 'destroy']);
        add_filter('page_template', [$this, 'set_single_template']);
    }

    public function init()
    {
        $id = wp_insert_post(array('import_id' => $this->id, 'post_type' => 'page', 'post_title' => $this->post_title, 'post_status' => 'publish'));
        $this->id = $id;
    }

    public function destroy()
    {
        wp_delete_post($this->id, true);
    }

    function set_single_template($template)
    {
        global $post;

        if ($post->post_type = 'page' && $post->post_title == $this->post_title)
            return PLUGIN_DIR . 'templates/pages/page-checkout.php';

        return $template;
    }
}
