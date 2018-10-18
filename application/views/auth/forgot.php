<div class="form-auth mt-0 mt-sm-4">
    <h3 class="mb-1">Reset Password</h3>
    <p class="text-muted">
        Enter your email address that you used to register. We'll send you an email with your username and a
        link to reset your password.
    </p>

    <?php $this->load->view('components/_alert') ?>

    <form action="<?= site_url('auth/password/forgot-password') ?>" method="post">
        <?= _csrf() ?>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Registered email address">
            <?= form_error('email') ?>
        </div>
        <button type="submit" class="btn btn-block btn-primary mb-3">Request Reset Password</button>
        <div class="text-center">
            Remember password ?
            <a href="<?= site_url('auth/login') ?>">
                Sign In
            </a>
        </div>
    </form>
</div>
