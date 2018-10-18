<div class="form-auth mt-0 mt-sm-4">
    <h3 class="mb-1">SSO Gateway</h3>
    <p class="text-muted">Centralize single authentication</p>

    <?php $this->load->view('components/_alert') ?>

    <form action="<?= site_url('auth/login') . if_empty($_SERVER['QUERY_STRING'], '', '?') ?>" method="post">
        <?= _csrf() ?>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username"
                   placeholder="Enter username or email" maxlength="50" value="<?= set_value('username') ?>">
            <?= form_error('username') ?>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password"
                   placeholder="Your secret password" maxlength="50">
            <?= form_error('password') ?>
        </div>
        <div class="form-group auth-control">
            <div class="row">
                <div class="col">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="remember" name="remember" value="1">
                        <label class="custom-control-label" for="remember">Remember me</label>
                    </div>
                </div>
                <div class="col text-right">
                    <a href="<?= site_url('auth/password/forgot-password') ?>">
                        Forgot password?
                    </a>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-block btn-primary mb-3">Sign In</button>
        <div class="text-center">
            Not a member ?
            <a href="<?= site_url('auth/register') ?>">
                Create new account
            </a>
        </div>
    </form>
</div>
