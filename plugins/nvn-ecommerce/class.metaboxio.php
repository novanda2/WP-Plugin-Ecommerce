<?php

/**
 * 
 * reaseon use metabox io intead wp metabox
 * doesnt support wordpress graphql 
 * save huge development time 
 * 
 */



class MetaboxIO
{
    public static function init()
    {
        add_filter('rwmb_meta_boxes', function ($meta_boxes) {
            /** hidden */
            // products images
            $meta_boxes[] = [
                'title'      => 'Images Arr',
                'post_types' => 'products',
                'fields'     => [
                    [
                        'id'       => 'images_Arr',
                        'type'     => 'textarea',
                        'class' => 'nvn-uploader__input-images',
                        'std' => '',
                        'graphql_name' => 'ArrayimagesShow',
                    ],
                ],
            ];

            // products price
            $meta_boxes[] = [
                'title'      => 'Price Hidden',
                'post_types' => 'products',
                'fields'     => [
                    [
                        'id'       => 'product_price',
                        'type'     => 'text',
                        'class' => 'nvn-metabox__product-price__input-value',
                        'std' => '',
                        'graphql_name' => 'ProductPrice',
                    ],
                ],
            ];

            /** show */
            $meta_boxes[] = [
                'title'      => 'Product Images',
                'post_types' => 'products',
                'before' => 'asd',
                'fields'     => [
                    [
                        'id'       => 'images_show',
                        'type'     => 'custom_html',
                        'callback' => 'multiple_image_uploader',
                    ],
                ],
            ];

            $meta_boxes[] = [
                'title'      => 'Product Price',
                'post_types' => 'products',
                'before' => 'asd',
                'fields'     => [
                    [
                        'id'       => 'product_price_show',
                        'type'     => 'text',
                        'class'    => 'nvn-metabox__product-price__input'
                        // 'callback' => 'product',
                    ],
                ],
            ];

            /** 
             * order 
             * page
             */

            $meta_boxes[] = array(
                'title'      => 'Personal Information',
                'post_types' => 'orders',

                'fields' => array(
                    array(
                        'name'  => 'Order ID',
                        'id'    => 'order_id',
                        'type'  => 'text',
                    ),
                    array(
                        'name'  => 'Full name',
                        'id'    => 'order_name',
                        'type'  => 'text',
                    ),
                    array(
                        'name'  => 'Email',
                        'id'    => 'order_email',
                        'type'  => 'email',
                    ),
                    array(
                        'name'  => 'Phone Number',
                        'id'    => 'order_phone',
                        'type'  => 'text',
                    ),
                    array(
                        'name'  => 'Address',
                        'id'    => 'order_address',
                        'type'  => 'text',
                    ),
                    array(
                        'name'  => 'City',
                        'id'    => 'order_city',
                        'type'  => 'text',
                    ),
                    array(
                        'name'  => 'Postal Code',
                        'id'    => 'order_postalcode',
                        'type'  => 'text',
                    ),
                )
            );

            $meta_boxes[] = array(
                'title'      => 'Product Information',
                'post_types' => 'orders',

                'fields' => array(
                    array(
                        'name'  => 'Products ID',
                        'id'    => 'order_products_id',
                        'type'  => 'text',
                    ),
                    array(
                        'name'  => 'Products Amount',
                        'id'    => 'order_products_amount',
                        'type'  => 'text',
                    ),
                )
            );

            $meta_boxes[] = array(
                'title'      => 'Payment Information',
                'post_types' => 'orders',

                'fields' => array(
                    array(
                        'name'  => 'Payment ID',
                        'id'    => 'order_payment_id',
                        'type'  => 'text',
                    ),
                    array(
                        'name'  => 'Payment Amount',
                        'id'    => 'order_payment_amount',
                        'type'  => 'number',
                    ),
                    array(
                        'name'  => 'Payment Type',
                        'id'    => 'order_payment_type',
                        'type'  => 'text',
                    ),
                    array(
                        'name'  => 'Payment Status',
                        'id'    => 'order_payment_status',
                        'type'  => 'text',
                        'std'   => 'unpaid'
                    ),
                )
            );

            /** 
             * payments
             * page
             */

            $meta_boxes[] = array(
                'title'      => 'Payment Information',
                'post_types' => 'payments',

                'fields' => array(
                    array(
                        'name'  => 'Payment ID',
                        'id'    => 'payment_id',
                        'type'  => 'text'
                    ),
                    array(
                        'name'  => 'Payment Type',
                        'id'    => 'payment_type',
                        'type'  => 'text'
                    ),
                    array(
                        'name'  => 'Payment Amount',
                        'id'    => 'payment_amount',
                        'type'  => 'number',
                    ),
                )
            );

            return $meta_boxes;
        });

        function multiple_image_uploader($post)
        {
            require_once(PLUGIN_DIR . '/templates/metabox-io/class.product-detail.php');
            ProductMetaboxHTML::html($post);
        }
    }
}
