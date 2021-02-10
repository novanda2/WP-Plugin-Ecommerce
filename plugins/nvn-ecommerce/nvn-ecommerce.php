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
            'rewrite' => array('slug' => '%collections%/products', 'with_front' => false)

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
        'custom_taxonomies' => array(
            'labels' => array(
                'name' => 'Product Category',
                'singular_name' => 'Product Categories'
            ),
            // 'hierarchical' => true,
            'rewrite' => array('slug' => 'collection')
        )
    ),
];

// products
new Products($products_params);

// comments
ProductComments::init();

// graphql
add_filter('register_post_type_args', function ($args, $post_type) {

    if ('products' === $post_type) {
        $args['show_in_graphql'] = true;
        $args['graphql_single_name'] = 'product';
        $args['graphql_plural_name'] = 'products';
    }

    return $args;
}, 10, 2);


function wpa_show_permalinks($post_link, $post)
{
    if (is_object($post) && $post->post_type == 'products') {
        $terms = wp_get_object_terms($post->ID, 'collections');
        if ($terms) {
            return str_replace('%collections%', $terms[0]->slug, $post_link);
        }
    }
    return $post_link;
}


add_filter('post_type_link', 'wpa_show_permalinks', 1, 2);


add_action('init', 'function_to_add');

function function_to_add()
{

    global $wp_rewrite;

    //Write the rule
    $wp_rewrite->set_permalink_structure('%collections%/%postname%/');

    //Set the option
    update_option("rewrite_rules", FALSE);

    //Flush the rules and tell it to write htaccess
    $wp_rewrite->flush_rules(true);
}