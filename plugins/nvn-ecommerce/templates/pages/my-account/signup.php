<?php

class SignUp
{
    public $nickname = '';
    public $email = '';
    public $password = '';
    public $confirm_password = '';
    public $error = [];
    public $valid = false;

    public function __construct()
    {
        $this->form();

        $this->html();
    }

    public function form()
    {
        if ($_POST) {
            $this->nickname = $_POST['ecom-nickname'] ?? '';
            $this->email = $_POST['ecom-email'] ?? '';
            $this->password = $_POST['ecom-password'] ?? '';
            $this->confirm_password = $_POST['ecom-confirm-password'] ?? '';

            $this->validate();
        }
    }

    public function validate()
    {
        if (!preg_match('/^[ \w]+$/', $this->nickname)) {
            $this->error['ecom-nickname'] = 'please fill with valid name';
            return;
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->error['ecom-email'] = 'please fill with valid email';
            return;
        }

        if (!empty($this->password) && $this->password == $this->confirm_password) {
            if (strlen($this->password) < 8) {
                $this->error['ecom-password'] = 'Your Password Must Contain At Least 8 Characters!';
                return;
            }
        } else {
            $this->error['ecom-confirm-password'] = 'Your Password did\'nt Match';
            $this->error['ecom-password'] = 'Your Password did\'nt Match';
            return;
        }

        $this->create_user();
    }

    public function create_user()
    {
        $user_data = array(
            'user_login' => $this->nickname,
            'user_pass' => $this->password,
            'user_email' => $this->email,
            'show_admin_bar_front' => 'false',
            'roles' => 'contributor',
        );

        $user = wp_insert_user($user_data);

        if (is_wp_error($user))
            $this->error['register'] = $user->get_error_message();
        else {
            wp_update_user(array('ID' => $user, 'role' => 'contributor'));
            wp_redirect('/my-account');
            exit();
        }
    }

    public function html()
    { ?>

        <head>
            <title>Sign Up</title>
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
                            Sign Up
                        </div>

                        <div class="col-lg-12 auth-form">
                            <div class="col-lg-12 auth-form">
                                <form action="/my-account?action=signup" method="post">
                                    <div class="form-group">
                                        <label class="form-control-label">NICKNAME</label>
                                        <input type="text" name="ecom-nickname" value="<?= $this->nickname ?? '' ?>" class="form-control" autocomplete="on" required>
                                        <span class="auth-form__info warning"><?= $this->error['ecom-nickname'] ?? '' ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">EMAIL</label>
                                        <input type="email" name="ecom-email" value="<?= $this->email ?? '' ?>" class="form-control" autocomplete="on" required>
                                        <span class="auth-form__info warning"><?= $this->error['ecom-email'] ?? '' ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">PASSWORD</label>
                                        <input type="password" name="ecom-password" <?= $this->password ?? '' ?> class="form-control" autocomplete="on" required>
                                        <span class="auth-form__info warning"><?= $this->error['ecom-password'] ?? '' ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">CONFIRM PASSWORD</label>
                                        <input type="password" name="ecom-confirm-password" class="form-control" autocomplete="on" required>
                                        <span class="auth-form__info warning"><?= $this->error['ecom-confirm-password'] ?? '' ?></span>
                                    </div>

                                    <div class="col-lg-12 authbttm">
                                        <div class="col-lg-12 auth-btm auth-text">
                                            <span class="auth-form__info warning"><?= $this->error['register'] ?? '' ?></span>
                                        </div>
                                        <div class="col-lg-12 auth-btm auth-button">
                                            <a href="/my-account?action=signin" class="btn text-white">SIGNIN</a>
                                            <button type="submit" class="btn btn-outline-primary">SIGNUP</button>
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


$signup = new SignUp;
