<?php

class CustomPermalink
{
    public static function init()
    {
        /**
         * in url of single product
         * change %collection% 
         * to taxononomies
         * return the first taxonomies
         */

        add_filter('post_type_link', 'change_dynamic_url_to_tax', 1, 2);
        function change_dynamic_url_to_tax($post_link, $post)
        {
            if (is_object($post) && $post->post_type == 'products') {
                $terms = wp_get_object_terms($post->ID, 'collections');
                if ($terms) {
                    return str_replace('%collections%', $terms[0]->slug, $post_link);
                }
            }
            return $post_link;
        }




        /**
         * 
         * change permalink sturcture in settings
         * and flush
         * 
         */


        add_action('init', 'set_custom_permalink_structure');
        function set_custom_permalink_structure()
        {

            global $wp_rewrite;

            //Write the rule
            $wp_rewrite->set_permalink_structure('blog/%postname%/');

            //Set the option
            update_option("rewrite_rules", FALSE);

            //Flush the rules and tell it to write htaccess
            $wp_rewrite->flush_rules(true);
        }
    }
}
