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
            $meta_boxes[] = [
                'title' => 'Extra Fields',
                'id' => 'extra-fields',
                'post_types' => [
                    0 => 'post',
                ],
                'context' => 'after_title',
                'priority' => 'high',
                'autosave' => true,
                'fields' => [
                    [
                        'id' => 'a_random_number',
                        'name' => 'A Random Number',
                        'type' => 'number',
                        'std' => 5,
                        'columns' => 2,
                        'size' => 3,
                        'graphql_name' => 'zzzzzzzzzzimagesShow',
                    ],
                ],
            ];
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
            // end products images

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

            return $meta_boxes;
        });

        function multiple_image_uploader($post)
        {
            require_once(PLUGIN_DIR . '/templates/metabox-io/class.product-detail.php');
            ProductMetaboxHTML::html($post);
        }
    }
}
