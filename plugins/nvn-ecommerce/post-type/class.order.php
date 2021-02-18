<?php

require_once(PLUGIN_DIR . 'pages/class.page-order.php');
new OrderPage;

class Order
{
    public $slug = 'orders';
    public $args;

    public function __construct()
    {
        $this->args = [
            'labels' => array(
                'name' => __('Orders'),
                'singular_name' => __('Order')
            ),
            'public' => true,
            'supports' => array('title'),
            'graphql_single_name' => 'order',
            'graphql_plural_name' => 'orders',
            'rewrite' => array('slug' => 'orders', 'with_front' => false)
        ];

        add_action('init',  [$this, 'init']);


        add_action('admin_menu', function () {
            add_submenu_page('ecommerce_opt', 'Order', 'Order', 'manage_options', 'order-page', 'f');
            function f()
            {
            };
        });

        add_action('wp_print_styles', function () {
            if (is_page(9993)) {
                wp_dequeue_style('twenty-twenty-one-style');
                wp_deregister_style('twenty-twenty-one-style');
            }
        });

        add_action('wp_enqueue_scripts', function () {
            if (is_page(9993)) {

                $args = array(
                    'post_type' => 'orders',
                    'post_status' => 'publish',
                );

                $query = new WP_Query($args);

                $orders = [];

                while ($query->have_posts()) : $query->the_post();
                    $data = array(
                        'userId' => rwmb_get_value('order_user_id'),
                        'products' => rwmb_get_value('order_products'),
                        'name' => rwmb_get_value('order_name'),
                        'email' => rwmb_get_value('order_email'),
                        'phone' => rwmb_get_value('order_phone'),
                        'address' => rwmb_get_value('order_address'),
                        'city' => rwmb_get_value('order_city'),
                        'postalcode' => rwmb_get_value('order_postalcode'),
                    );

                    array_push($orders, $data);
                endwhile;

                wp_reset_postdata();


                wp_enqueue_script('orders', PLUGIN_URL . 'scripts/admin/orders.js', array(), '1.0.0', true);
                wp_localize_script(
                    'orders',
                    'orders_data',
                    array(
                        'orders' => $orders,
                    )
                );
            }
        });


        add_action('admin_init', function () {
            if (isset($_GET['page']) && $_GET['page'] == 'order-page') {
                wp_redirect(home_url() . '/orders');
                exit();
            }
        });
    }

    public function init()
    {
        register_post_type($this->slug, $this->args);
    }
}
