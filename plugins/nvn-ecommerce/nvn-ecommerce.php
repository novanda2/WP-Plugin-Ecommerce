<?php

/**
 * @package nvn ecommerce
 */
/*
Plugin Name: nvn ecommerce
Plugin URI: https://akismet.com/
Description: Used by millions, Akismet is quite possibly the best way in the world to <strong>protect your blog from spam</strong>. It keeps your site protected even while you sleep. To get started: activate the Akismet plugin and then go to your Akismet Settings page to set up your API key.
Version: 0.0.1
Author: Automattic
Author URI: https://automattic.com/wordpress-plugins/
License: GPLv2 or later
Text Domain: akismet
*/

define('PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PLUGIN_URL', plugin_dir_url(__FILE__));
define('PLUGIN_WITH_CLASSES__FILE__', __FILE__);



require_once(PLUGIN_DIR . 'class.ecommerce-option.php');
require_once(PLUGIN_DIR . 'class.products.php');
require_once(PLUGIN_DIR . 'class.product-comments.php');
require_once(PLUGIN_DIR . 'class.permalink.php');
require_once(PLUGIN_DIR . 'class.metaboxio.php');


$allow_rating = get_option('product_review_rating');


$products_params = (object)[
    'slug' => 'products',
    'posts' => (object)array(
        'templates' => (object)[
            'single' => 'templates/single-products.php',
            'archive' => 'templates/archive-products.php'
        ],
        'args' => [
            'labels' => array(
                'name' => __('Products'),
                'singular_name' => __('Product')
            ),
            'public' => true,
            'has_archive' => true,
            'hierarchical' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'comments'),
            'graphql_single_name' => 'product',
            'graphql_plural_name' => 'products',
            'rewrite' => array('slug' => 'collections/%collections%/products', 'with_front' => false)

        ],
        'custom_field' => array(
            'name' => 'product detail',
            'id' => 'products_detail_fields',
            'title' =>  __('Product Detail', 'product custom field'),
            'context' => 'normal',
            'priority' => 'core',
            'callback_args' => array(
                'template' => '/templates/metabox/class.product-detail.php'
            ),
        ),
        'custom_field_metaboxio', array(),
        'custom_taxonomies' => array(
            'labels' => array(
                'name' => 'Product Category',
                'singular_name' => 'Product Categories'
            ),
            // 'hierarchical' => true,
            'rewrite' => array('slug' => 'collection', 'with_front' => false),
            'show_in_graphql' => true,
            'graphql_single_name' => 'documentTag',
            'graphql_plural_name' => 'documentTags',
        )
    ),
];

// products
$produtcs = new Products($products_params);

// metabox
// $produtcs->custom_metabox();
MetaboxIO::init();

// comments
if ($allow_rating)
    ProductComments::init();
else
    ProductComments::destroy();

// custom permalink
CustomPermalink::init();

// graphql
Products::graphql_init();

// $PageGuid = site_url() . "/my-page-req1";
// $my_post  = array(
//     'post_title'     => 'My page Reql',
//     'post_type'      => 'page',
//     'post_name'      => 'my-page',
//     'post_content'   => 'This is my page reql.',
//     'post_status'    => 'publish',
//     'comment_status' => 'closed',
//     'ping_status'    => 'closed',
//     'post_author'    => 1,
//     'menu_order'     => 0,
//     'guid'           => $PageGuid
// );

// $PageID = wp_insert_post($my_post, FALSE); // Get Post ID - FALSE to return 0 instead of wp_error.

register_activation_hook(PLUGIN_WITH_CLASSES__FILE__,  function(){
    wp_insert_post(array('post_type' => 'page', 'post_title' => 'checkout'));
});