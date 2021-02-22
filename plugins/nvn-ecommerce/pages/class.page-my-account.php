<?php
class MyAccout
{
    public $id = 9992;
    public $post_title = "My Account";

    public function __construct()
    {
        register_activation_hook(PLUGIN_WITH_CLASSES__FILE__,  [$this, 'init']);
        register_deactivation_hook(PLUGIN_WITH_CLASSES__FILE__,  [$this, 'destroy']);

        add_action('show_user_profile', [$this, 'extra_user_profile_fields']);
        add_action('edit_user_profile', [$this, 'extra_user_profile_fields']);

        add_action('personal_options_update', [$this, 'save_extra_user_profile_fields']);
        add_action('edit_user_profile_update', [$this, 'save_extra_user_profile_fields']);

        add_filter('page_template', [$this, 'set_single_template']);
    }

    public function init()
    {
        $args = array(
            'import_id'    => $this->id,
            'post_title' => $this->post_title,
            'post_type'    => 'page',
            'post_status'  => 'publish',
        );

        $id = wp_insert_post($args);
        $this->id = $id;
    }

    public function destroy()
    {
        wp_delete_post($this->id, true);
    }

    public function set_single_template($template)
    {
        global $post;

        if ($post->post_type = 'page' && $post->ID == 9992) {
            if (is_user_logged_in()) {
                return PLUGIN_DIR . 'templates/pages/my-account/my-account.php';
            }

            if ($_GET) {
                if ($_GET['action'] == 'signup')
                    return PLUGIN_DIR . 'templates/pages/my-account/signup.php';
                else
                    return PLUGIN_DIR . 'templates/pages/my-account/signin.php';
            }

            return PLUGIN_DIR . 'templates/pages/my-account/signin.php';
        }


        return $template;
    }

    function save_extra_user_profile_fields($user_id)
    {
        if (empty($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'update-user_' . $user_id)) {
            return;
        }

        if (!current_user_can('edit_user', $user_id)) {
            return false;
        }
        update_user_meta($user_id, 'phone', $_POST['phone']); 
        update_user_meta($user_id, 'address', $_POST['address']); 
        update_user_meta($user_id, 'city', $_POST['city']);
        update_user_meta($user_id, 'postalcode', $_POST['postalcode']);
    }

    function extra_user_profile_fields($user)
    { ?>
        <h3><?php _e("nvnCommerce profile information", "blank"); ?></h3>

        <table class="form-table">
            <tr>
                <th><label for="phone"><?php _e("Phone"); ?></label></th>
                <td>
                    <input type="tel" pattern="[08]-[0-9]{2}-[0-9]{3}" name="phone" id="phone" value="<?php echo esc_attr(get_the_author_meta('phone', $user->ID)); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("Please enter your phone."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="address"><?php _e("Address"); ?></label></th>
                <td>
                    <input type="text" name="address" id="address" value="<?php echo esc_attr(get_the_author_meta('address', $user->ID)); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("Please enter your address."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="city"><?php _e("City"); ?></label></th>
                <td>
                    <input type="text" name="city" id="city" value="<?php echo esc_attr(get_the_author_meta('city', $user->ID)); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("Please enter your city."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="postalcode"><?php _e("Postal Code"); ?></label></th>
                <td>
                    <input type="text" name="postalcode" id="postalcode" value="<?php echo esc_attr(get_the_author_meta('postalcode', $user->ID)); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("Please enter your postal code."); ?></span>
                </td>
            </tr>
        </table>
<?php
    }
}
