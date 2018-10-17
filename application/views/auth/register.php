<div class="form-auth">
    <h3 class="mb-1">Register New Account</h3>
    <p class="text-muted">Centralize single authentication</p>

    <?php $this->load->view('components/_alert') ?>

    <form action="<?= site_url('auth/register') ?>" method="post">
        <?= _csrf() ?>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name"
                   placeholder="Your full name" maxlength="50" value="<?= set_value('name') ?>">
            <?= form_error('name') ?>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username"
                   placeholder="Enter username" maxlength="50" value="<?= set_value('username') ?>">
            <?= form_error('username') ?>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email"
                   placeholder="Your email address" maxlength="50" value="<?= set_value('email') ?>">
            <?= form_error('email') ?>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password"
                   placeholder="Your secret password" minlength="6" maxlength="50">
            <?= form_error('password') ?>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                   placeholder="Repeat your password" minlength="6" maxlength="50">
            <?= form_error('confirm_password') ?>
        </div>
        <div class="form-group auth-control">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="terms" name="terms" value="1" required>
                <label class="custom-control-label" for="terms">I agree to the terms and condition.</label>
            </div>
        </div>
        <button type="submit" class="btn btn-block btn-primary mb-3">Sign Up</button>
        <div class="text-center small">
            Already have and account ?
            <a href="<?= site_url('auth/login') ?>">
                Sign In
            </a>
        </div>
    </form>
</div>
