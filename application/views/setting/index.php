<?php $this->load->view('components/_banner_control') ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-md-3 col-lg-2">
            <?php $this->load->view('components/_sidebar_nav') ?>
        </div>
        <div class="col-md-9 col-lg-10">
            <h4 class="card-title">Settings</h4>
            <form action="<?= site_url('manage/setting') ?>" method="post" id="form-setting">
                <?= _csrf() ?>
                <?= _method('put') ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="email_bug_report">Bug Report</label>
                            <input type="email" class="form-control" id="email_bug_report" name="email_bug_report"
                                   placeholder="Enter email bug reports" maxlength="50" value="<?= set_value('email_bug_report', get_if_exist($setting, 'email_bug_report', 'bug@sso.app')) ?>">
                            <?= form_error('email_bug_report') ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="email_support">Support</label>
                            <input type="email" class="form-control" id="email_support" name="email_support"
                                   placeholder="Enter email bug reports" maxlength="50" value="<?= set_value('email_support', get_if_exist($setting, 'email_support', 'support@sso.app')) ?>">
                            <?= form_error('email_support') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="meta_keywords">Keywords</label>
                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                           placeholder="Enter application keywords" maxlength="300" value="<?= set_value('meta_keywords', get_if_exist($setting, 'meta_keywords', 'sso,auth,multi-app,login,credential')) ?>">
                    <?= form_error('meta_keywords') ?>
                </div>
				<div class="form-group">
					<label for="default_application">Default Application</label>
					<select class="custom-select" name="default_application" id="default_application">
						<option value="">-- No default --</option>
						<?php foreach ($applications as $application): ?>
							<option value="<?= $application['url'] ?>"<?= set_select('default_application', $application['url'], $application['url'] == get_if_exist($setting, 'default_application')) ?>>
								<?= $application['title'] ?>
							</option>
						<?php endforeach; ?>
					</select>
					<span class="form-text">Default application url redirection after login SSO.</span>
					<?= form_error('default_application') ?>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label for="password_expiration_days">Password will expired in days</label>
							<input type="number" class="form-control" id="password_expiration_days" name="password_expiration_days"
								   placeholder="Expired after last changing" min="0" maxlength="365" value="<?= set_value('password_expiration_days', get_if_exist($setting, 'password_expiration_days', '0')) ?>">
							<span class="form-text">Set 0 to disable expiration password.</span>
							<?= form_error('password_expiration_days') ?>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="email_verification_after_password_expired_days">Email validation for expired password</label>
							<input type="number" class="form-control" id="email_verification_after_password_expired_days" name="email_verification_after_password_expired_days"
								   placeholder="Expired after last changing" min="0" maxlength="365" value="<?= set_value('email_verification_after_password_expired_days', get_if_exist($setting, 'email_verification_after_password_expired_days', '0')) ?>">
							<span class="form-text">Set 0 to disable email validation for reset.</span>
							<?= form_error('email_verification_after_password_expired_days') ?>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="auto_suspended_inactive_days">Auto suspended inactive user</label>
							<input type="number" class="form-control" id="auto_suspended_inactive_days" name="auto_suspended_inactive_days"
								   placeholder="Auto suspension in days" min="0" maxlength="365" value="<?= set_value('auto_suspended_inactive_days', get_if_exist($setting, 'auto_suspended_inactive_days', '0')) ?>">
							<span class="form-text">Set 0 to disable suspension for inactive users.</span>
							<?= form_error('auto_suspended_inactive_days') ?>
						</div>
					</div>
				</div>
                <div class="form-group">
                    <label for="meta_description">Description</label>
                    <textarea class="form-control" id="meta_description" name="meta_description"
                              placeholder="Application description"
                              maxlength="300"><?= set_value('meta_description', get_if_exist($setting, 'meta_description', 'Single sign-on (SSO) a gate for user authentication service that permits to access system use one set of login credentials')) ?></textarea>
                    <?= form_error('meta_description') ?>
                </div>

                <button type="submit" class="btn btn-success my-4">Update Settings</button>
            </form>
        </div>
    </div>
</div>
