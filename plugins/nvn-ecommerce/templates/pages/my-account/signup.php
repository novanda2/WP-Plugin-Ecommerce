<?php

class SignUp
{
    public $nickname = '';
    public $email = '';
    public $password = '';
    public $confirm_password = '';
    public $error = [
        'ecom-username' => '',
        'ecom-email' => '',
        'ecom-password' => '',
        'ecom-confirm-password' => '',
    ];
    public $valid = false;

    public function __construct()
    {
        $this->form();

        if ($this->validation())
            $this->create_user();
    }

    public function form()
    {
        if ($_POST) {
            $this->nickname = $_POST['ecom-username'];
            $this->email = $_POST['ecom-email'];
            $this->password = $_POST['ecom-password'];
            $this->confirm_password = $_POST['ecom-confirm-password'];
            $this->validation();
        }

        $this->html();
    }

    public function validation()
    {
        if (!preg_match('/^[ \w]+$/', $this->nickname)) {
            $this->error['ecom-username'] = 'please fill with valid name';
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

        return true;
    }

    public function create_user()
    {
        var_dump('yey');
        wp_create_user($this->nickname, $this->password, $this->email);
        if (wp_redirect($url)) {
            exit;
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
                                        <label class="form-control-label">USERNAME</label>
                                        <input type="text" name="ecom-username" value="<?= $this->nickname ? $this->nickname : '' ?>" class="form-control" autocomplete="on" required>
                                        <span class="text-warning"><?= $this->error['ecom-username'] ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">EMAIL</label>
                                        <input type="email" name="ecom-email" value="<?= $this->email ? $this->email : '' ?>" class="form-control" autocomplete="on" required>
                                        <span class="text-warning"><?= $this->error['ecom-email'] ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">PASSWORD</label>
                                        <input type="password" name="ecom-password" <?= $this->password ?> class="form-control" autocomplete="on" required>
                                        <span class="text-warning"><?= $this->error['ecom-password'] ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">CONFIRM PASSWORD</label>
                                        <input type="password" name="ecom-confirm-password" class="form-control" autocomplete="on" required>
                                        <span class="text-warning"><?= $this->error['ecom-confirm-password'] ?></span>
                                    </div>

                                    <div class="col-lg-12 authbttm">
                                        <div class="col-lg-12 auth-btm auth-text">
                                            <!-- Error Message -->
                                        </div>
                                        <div class="col-lg-12 auth-btm auth-button">
                                            <button type="submit" class="btn btn-outline-primary">LOGIN</button>
                                            <button type="submit" class="btn btn-outline-primary"><?php var_dump($this->validation()) ?></button>
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
