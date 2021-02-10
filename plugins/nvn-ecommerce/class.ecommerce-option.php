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


class PluginConfig {
    public function __construct() {
        // Hook into the admin menu
        add_action( 'admin_menu', array( $this, 'create_plugin_settings_page' ) );
        add_action( 'admin_init', array( $this, 'setup_sections' ) );
        add_action( 'admin_init', array( $this, 'setup_fields' ) );
    }

    public function create_plugin_settings_page() {
        // Add the menu item and page
        $page_title = 'My Awesome Settings Page';
        $menu_title = 'Ecommerce Opt';
        $capability = 'manage_options';
        $slug = 'smashing_fields';
        $callback = array( $this, 'plugin_settings_page_content' );
        $icon = 'dashicons-admin-plugins';
        $position = 100;
    
        add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );
    }

    public function plugin_settings_page_content() { ?>
        <div class="wrap">
        <h2>My Awesome Settings Page</h2>
            <form method="post" action="options.php">
                <?php
                    settings_fields( 'smashing_fields' );
                    do_settings_sections( 'smashing_fields' );
                    submit_button();
                ?>
            </form>
        </div> <?php
    }

    public function setup_sections() {
        /** 
         * same callback but will run different thing
         * cause callback assigned to params $arguments array
         * with $arguments['id'] as unique key
         * 
         */


        add_settings_section( 'our_first_section', 'My First Section Title', array( $this, 'section_callback' ), 'smashing_fields' );
        add_settings_section( 'our_second_section', 'My Second Section Title', array( $this, 'section_callback' ), 'smashing_fields' );
        add_settings_section( 'our_third_section', 'My Third Section Title', array( $this, 'section_callback' ), 'smashing_fields' );
    }

    public function section_callback( $arguments ) {
        switch( $arguments['id'] ){
            case 'our_first_section':
                echo 'This is the first description here!';
                break;
            case 'our_second_section':
                echo 'This one is number two';
                break;
            case 'our_third_section':
                echo 'Third time is the charm!';
                break;
        }
    }

    
    public function setup_fields() {
        $fields = array(
            array(
                'uid' => 'our_first_field',
                'label' => 'Awesome Date',
                'section' => 'our_first_section',
                'type' => 'text',
                'options' => false,
                'placeholder' => 'DD/MM/YYYY',
                'helper' => 'Does this help?',
                'supplemental' => 'I am underneath!',
                'default' => '01/01/2015'
            )
        );
        foreach( $fields as $field ){
            add_settings_field( $field['uid'], $field['label'], array( $this, 'field_callback' ), 'smashing_fields', $field['section'], $field );
            register_setting( 'smashing_fields', $field['uid'] );
        }
    }
    

    public function field_callback( $arguments ) {
        echo '<input name="our_first_field" id="our_first_field" type="text" value="' . get_option( 'our_first_field' ) . '" />';
        register_setting( 'smashing_fields', 'our_first_field' );
    }
}
new PluginConfig();
