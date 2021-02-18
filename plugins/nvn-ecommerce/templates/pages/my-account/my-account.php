<?php

class MyAccoutView
{
    public $first_name;
    public $last_name;
    public $display_name;
    public $email;
    public $address;
    public $city;
    public $postalcode;

    public $status = [];

    public function __construct()
    {
        $current_user = wp_get_current_user();

        $this->first_name = $current_user->first_name;
        $this->last_name = $current_user->last_name;
        $this->display_name = $current_user->display_name;
        $this->email = $current_user->user_email;
        $this->address = get_the_author_meta('address', $current_user->ID);
        $this->city = get_the_author_meta('city', $current_user->ID);
        $this->postalcode = get_the_author_meta('postalcode', $current_user->ID);


        if (!is_user_logged_in()) {
            wp_redirect('/');
            exit();
        }

        if (isset($_POST['signout'])) {
            $this->logout();
        }

        if (isset($_POST['save']))
            $this->save();


        $this->html();
    }

    public function save()
    {
        if (isset($_POST['first_name'])) {

            $user_id = (int) wp_get_current_user()->ID; // correct ID
            $first_name = $_POST['first_name'] ?? $this->first_name;
            $last_name = $_POST['last_name'] ?? $this->last_name;
            $user_email = $_POST['user_email'] ?? $this->email;
            $address = $_POST['address'] ?? $this->address;
            $city = $_POST['city'] ?? $this->city;
            $postalcode = $_POST['postalcode'] ?? $this->postalcode;


            $user = wp_update_user(array(
                'ID' => $user_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'user_email' => $user_email,
            ));

            update_user_meta($user_id, 'address', $address);
            update_user_meta($user_id, 'city', $city);
            update_user_meta($user_id, 'postalcode', $postalcode);

            if (is_wp_error($user))
                echo $user->get_error_message();
            else {
                wp_redirect('/my-account');
                exit();
            }
        }
    }

    public function logout()
    {
        wp_logout();
        wp_redirect('/');
        exit();
    }

    public function html()
    { ?>

        <head>
            <link rel="stylesheet" href="<?= PLUGIN_URL . 'styles/site/bootstrap.css' ?>">
            <link rel="stylesheet" href="<?= PLUGIN_URL . 'styles/site/my-account.css' ?>">
        </head>

        <body>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-2"></div>
                    <div class="col-lg-6 col-md-8 auth-box">
                        <div class="col-lg-12 auth-key">
                            <i class="fa fa-key" aria-hidden="true"></i>
                        </div>
                        <div class="col-lg-12 auth-title">
                            My Account
                        </div>

                        <div class="col-lg-12 auth-form">
                            <div class="col-lg-12 auth-form">
                                <form action="/my-account?action=signup" method="post">
                                    <div class="form-group">
                                        <label class="form-control-label">FIRSTNAME</label>
                                        <input type="text" name="first_name" value="<?= $this->first_name ?>" class="form-control" autocomplete="on">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">LASTNAME</label>
                                        <input type="text" name="last_name" value="<?= $this->last_name ?>" class="form-control" autocomplete="on">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">EMAIL</label>
                                        <input type="email" name="user_email" value="<?= $this->email ?>" class="form-control" autocomplete="on">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">ADDRESS</label>
                                        <input type="text" name="address" value="<?= $this->address ?>" class="form-control" autocomplete="on">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">CITY</label>
                                        <input type="text" name="city" value="<?= $this->city ?>" class="form-control" autocomplete="on">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">POSTAL CODE</label>
                                        <input type="number" name="postalcode" value="<?= $this->postalcode ?>" class="form-control" autocomplete="on">
                                    </div>

                                    <div class="col-lg-12 authbttm">
                                        <div class="col-lg-12 auth-btm auth-text">
                                            <span class="text-warning"><?= $this->status['save'] ?? '' ?></span>
                                            <input type="hidden" name="save">
                                        </div>
                                        <div class="col-lg-12 auth-btm auth-button">
                                            <button type="submit" class="btn btn-outline-primary">SAVE</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-2">
                            <form action="/my-account" method="post"><input type="submit" name="signout" value="SIGN OUT" /></form>
                        </div>
                    </div>
                </div>
            </div>
        </body>
<?php }
}


new MyAccoutView;
