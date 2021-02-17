<?php
class Login
{
    public $user_login;
    public $user_password;
    public $remember_me;
    public $error = [];

    public function __construct()
    {
        $this->form();
        $this->html();
    }

    public function login()
    {

        $creds = array(
            'user_login' => $this->user_login,
            'user_password' => $this->user_password,
            'remember' => $this->remember_me ? true : false,
        );

        $user = wp_signon($creds);

        if (is_wp_error($user)) {
            echo $user->get_error_message();
        }

        if (!is_wp_error($user))
            wp_redirect('/my-account');
        exit();
    }

    public function form()
    {
        if ($_POST) {
            $this->user_login = $_POST['user_login'];
            $this->user_password = $_POST['user_password'];
            $this->remember_me = $_POST['remember_me'];
            $this->validate();
        }
    }

    public function validate()
    {
        $this->login();

        return true;
    }

    public function error()
    {
    }

    public function html()
    { ?>

        <head>
            <title>Sign In</title>
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
                            Sign In
                        </div>

                        <div class="col-lg-12 auth-form">
                            <div class="col-lg-12 auth-form">
                                <form action="/my-account?action=signin" method="post">
                                    <div class="form-group">
                                        <label class="form-control-label">USERNAME</label>
                                        <input type="text" name="user_login" value="<?= $this->user_login ? $this->user_login : '' ?>" class="form-control" autocomplete="on" required>
                                        <!-- <span class="text-warning"><?= $this->error['ecom-username'] ?></span> -->
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">PASSWORD</label>
                                        <input type="password" name="user_password" <?= $this->user_password ?> class="form-control" autocomplete="on" required>
                                        <!-- <span class="text-warning"><?= $this->error['ecom-password'] ?></span> -->
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember_me" value="remember_me" id="rememberme" checked>
                                        <label class="form-check-label text-white" for="rememberme">
                                            Remember Me
                                        </label>
                                    </div>

                                    <div class="col-lg-12 authbttm">
                                        <div class="col-lg-12 auth-btm auth-text">
                                            <!-- Error Message -->
                                        </div>
                                        <div class="col-lg-12 auth-btm auth-button">
                                            <a href="/my-account?action=signup" class="btn text-white">REGISTER</a>
                                            <button type="submit" class="btn btn-outline-primary">LOGIN</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-2"></div>
                    </div>
                </div>
            </div>
        </body>
<?php }
}


new Login;
