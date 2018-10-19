<div class="form-auth mt-0 mt-sm-4">
    <h3 class="mb-1">Password Recovery</h3>
    <p class="text-muted">Resetting your credentials</p>

    <?php $this->load->view('components/_alert') ?>

    <form action="<?= site_url('auth/password/reset/' . $token) ?>" method="post">
        <?= _csrf() ?>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email', $email) ?>"
                   placeholder="Registered email address" required readonly maxlength="50">
            <?= form_error('email') ?>
        </div>
        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" class="form-control" id="new_password" name="new_password"
                   placeholder="Set new password" minlength="6" maxlength="50">
            <?= form_error('new_password') ?>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                   placeholder="Repeat your password" minlength="6" maxlength="50">
            <?= form_error('confirm_password') ?>
        </div>
        <button type="submit" class="btn btn-block btn-primary mb-3">Reset My Password</button>
        <div class="text-center auth-control">
            Remember password ?
            <a href="<?= site_url('auth/login') ?>">
                Sign In
            </a>
        </div>
    </form>
</div>
