<?php

/**
 * 
 * aftter checkout, user payment goes here
 */

class PaymentPost
{
    public $slug = 'payments';
    public $args;

    public function __construct()
    {
        $this->args = [
            'labels' => array(
                'name' => __('Payments'),
                'singular_name' => __('Payment')
            ),
            'public' => true,
            'supports' => array('title'),
            'graphql_single_name' => 'payment',
            'graphql_plural_name' => 'payments',
            'rewrite' => array('slug' => 'payment', 'with_front' => false)
        ];

        add_action('init',  [$this, 'init']);
    }

    public function init()
    {
        register_post_type($this->slug, $this->args);
    }
}
