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

    public function __construct()
    {
        $current_user = wp_get_current_user();

        $this->first_name = $current_user->first_name;
        $this->last_name = $current_user->last_name;
        $this->last_name = $current_user->last_name;
        $this->display_name = $current_user->display_name;
        $this->email = $current_user->user_email;
        $this->address = get_the_author_meta('address', $current_user->ID);
        $this->city = get_the_author_meta('city', $current_user->ID);
        $this->postalcode = get_the_author_meta('postalcode', $current_user->ID);


        // update_user_meta(wp_get_current_user()->ID, 'postalcode', 123);



        if ($_POST) {
            if ($_POST['signout'] != '') {
                $this->logout();
            }
        }

        if (!is_user_logged_in()) {
            wp_redirect('/');
            exit();
        }


        $this->html();
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
                                        <label class="form-control-label">NAMA</label>
                                        <input type="text" name="ecom-name" value="<?= $this->display_name ?>" class="form-control" autocomplete="on" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">EMAIL</label>
                                        <input type="email" name="ecom-email" value="<?= $this->email ?>" class="form-control" autocomplete="on" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">ADDRESS</label>
                                        <input type="text" name="ecom-address" value="<?= $this->address ?>" class="form-control" autocomplete="on" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">CITY</label>
                                        <input type="text" name="ecom-city" value="<?= $this->city ?>" class="form-control" autocomplete="on" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">POSTAL CODE</label>
                                        <input type="number" name="ecom-postalcode" value="<?= $this->postalcode ?>" class="form-control" autocomplete="on" required>
                                    </div>

                                    <div class="col-lg-12 authbttm">
                                        <div class="col-lg-12 auth-btm auth-text">
                                            <!-- Error Message -->
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
