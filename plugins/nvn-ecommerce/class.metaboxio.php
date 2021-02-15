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

            return $meta_boxes;
        });

        function multiple_image_uploader($post)
        {
            require_once(PLUGIN_DIR . '/templates/metabox-io/class.product-detail.php');
            ProductMetaboxHTML::html($post);
        }
    }
}
