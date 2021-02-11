<?php

/**
 * configureable field in our plugins
 * 
 * 
 * how it work
 * 
 * 1. we make setting option in sidebar 
 * add_action('admin_menu')
 * callback show html form
 * 
 * The settings_fields function is basically a reference for the rest of our fields. 
 * The string argument you put in that function should match the $slug variable we set up earlier
 * it will be in all of the fields we register later in the plugin. 
 * This function also outputs a few hidden inputs for the nonce,
 * form action and a few other fields for the options page.
 * 
 * do_settings_sections, is a placeholder for the sections and fields 
 * we will register elsewhere in our plugin.
 * 
 * submit_button, will output the submit input, 
 * but it will also add some classes based on the status of the page. 
 * There may be other arguments you will want to pass into the submit_button function; 
 * they are outlined in the codex.
 * 
 * 2. add settings section
 * wp separates its option page into sectins,
 * Each section can have a list of fields associated to it
 * We need to register a section in our plugin before we can start adding our fields
 * in our case wee add with add_action('admin_init') with 'setup_section' callback.
 * in setup_section callback we use same callback, 
 * beacause 'add_setting_section' function 
 * 
 * 
 * ...
 */


class PluginConfig
{
    public function __construct()
    {
        // Hook into the admin menu
        add_action('admin_menu', array($this, 'create_plugin_settings_page'));
        add_action('admin_init', array($this, 'setup_sections'));
        add_action('admin_init', array($this, 'setup_fields'));
    }

    public function create_plugin_settings_page()
    {
        // Add the menu item and page
        $page_title = 'Ecommerce Options';
        $menu_title = 'Ecommerce Opt';
        $capability = 'manage_options';
        $slug = 'ecommerce_opt';
        $callback = array($this, 'plugin_settings_page_content');
        $icon = 'dashicons-admin-plugins';
        $position = 100;

        add_menu_page($page_title, $menu_title, $capability, $slug, $callback, $icon, $position);
    }

    public function plugin_settings_page_content()
    { ?>
        <div class="wrap">
            <h2>Ecommerce Options</h2>
            <form method="post" action="options.php">
                <?php
                settings_fields('ecommerce_opt');
                do_settings_sections('ecommerce_opt');
                submit_button();
                ?>
            </form>
        </div> <?php
            }

            public function setup_sections()
            {
                /** 
                 * same callback but will run different thing
                 * cause callback assigned to params $arguments array
                 * with $arguments['id'] as unique key
                 * 
                 */


                add_settings_section('products', 'Products Settings', array($this, 'section_callback'), 'ecommerce_opt');
                // add_settings_section('our_second_section', 'My Second Section Title', array($this, 'section_callback'), 'ecommerce_opt');
                // add_settings_section('our_third_section', 'My Third Section Title', array($this, 'section_callback'), 'ecommerce_opt');
            }

            public function section_callback($arguments)
            {
                // switch ($arguments['id']) {
                //     case 'products':
                //         echo 'Enable Comments for ';
                //         break;
                //     case 'our_second_section':
                //         echo 'This one is number two';
                //         break;
                //     case 'our_third_section':
                //         echo 'Third time is the charm!';
                //         break;
                // }
            }


            public function setup_fields()
            {
                $fields = array(
                    array(
                        'uid' => 'product_review',
                        'label' => 'Product Review',
                        'section' => 'products',
                        'type' => 'option',
                        'input_label' => '',
                        'placeholder' => '',
                        'options' => array('disable', 'enable'),
                        'description' => 'Allow Visitor to Comments and Review Product',
                        'default' => 'enable'
                    ),
                    array(
                        'uid' => 'product_review_rating',
                        'label' => 'Product Ratings',
                        'section' => 'products',
                        'type' => 'option',
                        'input_label' => '',
                        'placeholder' => '',
                        'options' => array('disable', 'enable'),
                        'description' => 'Allow Visitor to Rate Product',
                        'default' => 'enable'
                    ),
                    array(
                        'uid' => 'our_third_fie ld',
                        'label' => 'Awesome Select',
                        'section' => 'products  ',
                        'type' => 'select',
                        'input_label' => '',
                        'options' => array(
                            'yes' => 'Yeppers',
                            'no' => 'No way dude!',
                            'maybe' => 'Meh, whatever.'
                        ),
                        'placeholder' => 'Text goes here',
                        'default' => 'enable'
                    )
                );
                foreach ($fields as $field) {
                    add_settings_field($field['uid'], $field['label'], array($this, 'field_callback'), 'ecommerce_opt', $field['section'], $field);
                    register_setting('ecommerce_opt', $field['uid']);
                }
            }

            public function field_callback($arguments)
            {
                $value = get_option($arguments['uid']); // Get the current value, if there is one
                if (!$value) { // If no value exists
                    $value = $arguments['default']; // Set to our default
                }

                // Check which type of field we want
                switch ($arguments['uid']):
                    case 'product_review': // If it is a text field
                        if (!empty($arguments['options']) && is_array($arguments['options'])) {
                            $options_markup = '';
                            foreach ($arguments['options'] as $key => $label) {
                                $options_markup .= sprintf('<option value="%s" %s>%s</option>', $key, selected($value, $key, false), $label);
                            }
                            printf('<select name="%1$s" id="%1$s">%2$s</select>', $arguments['uid'], $options_markup);
                        }

                        break;
                    case 'product_review_rating': // If it is a text field
                        if (!empty($arguments['options']) && is_array($arguments['options'])) {
                            $options_markup = '';
                            foreach ($arguments['options'] as $key => $label) {
                                $options_markup .= sprintf('<option value="%s" %s>%s</option>', $key, selected($value, $key, false), $label);
                            }
                            printf('<select name="%1$s" id="%1$s">%2$s</select>', $arguments['uid'], $options_markup);
                        }
                        break;
                endswitch;

                if ($input_label = $arguments['input_label']) {
                    printf('<label for="%1$s">%2$s</label>', $arguments['uid'], $input_label);
                }

                if ($supplimental = $arguments['description']) {
                    printf('<p class="description">%s</p>', $supplimental); // Show it
                }
            }
        }



        new PluginConfig();
