<?php

class Products
{
    public $products;

    public function __construct($products)
    {
        $this->products = $products;
        // hook
        register_activation_hook(PLUGIN_WITH_CLASSES__FILE__,  [$this, 'init']);
        register_deactivation_hook(PLUGIN_WITH_CLASSES__FILE__,  [$this, 'destroy']);

        // script
        add_action('admin_enqueue_scripts', [$this, 'add_scripts']);

        // post type
        add_action('init', function () {
            register_post_type($this->products->slug, $this->products->posts->args);
        });

        // template archive
        add_filter('archive_template', [$this, 'set_archive_template']);

        // template single
        add_filter('single_template', [$this, 'set_single_template']);


        /**
         * save post data
         * params 
         * save_post_{$post_type}
         */
        add_action('save_post_products', [$this, 'save_product_metabox']);

        // taxonomies
        add_action('init', [$this, 'add_taxonomies']);
    }

    public function add_scripts()
    {
        wp_enqueue_style('ecommerce-admin', PLUGIN_URL . 'styles/admin/style.css');
        wp_enqueue_script('ecommerce-admin', PLUGIN_URL . 'scripts/admin/main.js', array(), '1.0.0', true);
        wp_enqueue_script('metabox-admin', PLUGIN_URL . 'scripts/admin/metabox-io.js', array(), '1.0.0', true);
    }

    public function set_archive_template($archive_template)
    {
        global $post;
        $plugin_root_dir = PLUGIN_DIR;

        if (is_archive() && get_post_type($post) == $this->products->slug) {
            $archive_template = $plugin_root_dir . $this->products->posts->templates->archive;
        }
        return $archive_template;
    }


    function set_single_template($template)
    {
        global $post;

        if ($this->products->slug === $post->post_type && locate_template(array('single-products.php')) !== $template) {
            return PLUGIN_DIR . $this->products->posts->templates->single;
        }

        return $template;
    }


    public function custom_metabox()
    {
        // custom metabox
        add_action('add_meta_boxes', [$this, 'add_product_detail_metabox']);
    }

    public function add_product_detail_metabox()
    {
        $field = $this->products->posts->custom_field;

        add_meta_box(
            $field['id'],
            $field['title'],
            [$this, 'add_product_detail_metabox_html'], #callback,
            $this->products->slug, #screen
            $field['context'],
            $field['priority'],
            $field['callback_args'],
        );
    }


    public function add_product_detail_metabox_html($post, $callback)
    {
        require_once(PLUGIN_DIR . $callback['args']['template']);
        ProductMetaboxHTML::html($post);
    }

    public function save_product_metabox($post_id)
    {

        if (array_key_exists('product_images', $_POST))
            update_post_meta(
                $post_id,
                '_product_images',
                $_POST['product_images']
            );


        if (array_key_exists('product_stock', $_POST))
            update_post_meta(
                $post_id,
                '_product_stock',
                $_POST['product_stock']
            );

        if (array_key_exists('product_price', $_POST))
            update_post_meta(
                $post_id,
                '_product_price',
                $_POST['product_price']
            );

        if (array_key_exists('product_rating', $_POST))
            update_post_meta(
                $post_id,
                '_product_rating',
                $_POST['product_rating']
            );
    }

    public function add_taxonomies()
    {
        register_taxonomy('collections', array($this->products->slug), $this->products->posts->custom_taxonomies);
    }

    public static function graphql_init()
    {
        add_filter('register_post_type_args', function ($args, $post_type) {

            if ('products' === $post_type) {
                $args['show_in_graphql'] = true;
                $args['graphql_single_name'] = 'product';
                $args['graphql_plural_name'] = 'products';
            }

            return $args;
        }, 10, 2);

        add_filter('register_taxonomy_args', function ($args, $taxonomy) {

            if ('doc_tag' === $taxonomy) {
                $args['show_in_graphql'] = true;
                $args['graphql_single_name'] = 'documentTag';
                $args['graphql_plural_name'] = 'documentTags';
            }

            return $args;
        }, 10, 2);
    }
}
