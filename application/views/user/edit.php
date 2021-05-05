<?php $this->load->view('components/_banner_control') ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-md-3 col-lg-2">
            <?php $this->load->view('components/_sidebar_nav') ?>
        </div>
        <div class="col-md-9 col-lg-10">
            <h4 class="card-title"><?= $title ?></h4>
            <form action="<?= site_url('manage/user/update/' . $user['id']) ?>" method="post"
                  enctype="multipart/form-data" id="form-user">
                <?= _csrf() ?>
                <?= _method('put') ?>
                <p class="form-section-title">Profile Info</p>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Your full name" maxlength="50"
                                   value="<?= set_value('name', $user['name']) ?>">
                            <?= form_error('name') ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                   placeholder="Enter username" maxlength="50"
                                   value="<?= set_value('username', $user['username']) ?>">
                            <?= form_error('username') ?>
                        </div>
                    </div>
                </div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="email">Email Address</label>
							<input type="email" class="form-control" id="email" name="email"
								   placeholder="Your email address" maxlength="50"
								   value="<?= set_value('email', $user['email']) ?>">
							<?= form_error('email') ?>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="user_type">User Type</label>
							<select class="custom-select" name="user_type" id="user_type">
								<option value="INTERNAL"<?= set_select('user_type', 'INTERNAL', $user['user_type'] == 'INTERNAL') ?>>
									INTERNAL
								</option>
								<option value="EXTERNAL"<?= set_select('user_type', 'EXTERNAL', $user['user_type'] == 'EXTERNAL') ?>>
									EXTERNAL
								</option>
							</select>
							<?= form_error('user_type'); ?>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="avatar">Photo</label>
                            <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png"
                                   class="file-upload-default" data-max-size="2000000">
                            <div class="input-group">
                                <input type="text" class="form-control file-upload-info" disabled
                                       placeholder="Upload photo" value="<?= $user['avatar'] ?>">
                                <div class="input-group-append">
                                    <button class="file-upload-browse btn btn-default btn-simple-upload" type="button">
                                        Select Photo
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="custom-select" name="status" id="status" required>
                                <option value="<?= UserModel::STATUS_PENDING ?>"
                                    <?= set_select('status', UserModel::STATUS_PENDING, $user['status'] == UserModel::STATUS_PENDING) ?>>
                                    <?= UserModel::STATUS_PENDING ?>
                                </option>
                                <option value="<?= UserModel::STATUS_ACTIVATED ?>"
                                    <?= set_select('status', UserModel::STATUS_ACTIVATED, $user['status'] == UserModel::STATUS_ACTIVATED) ?>>
                                    <?= UserModel::STATUS_ACTIVATED ?>
                                </option>
                                <option value="<?= UserModel::STATUS_SUSPENDED ?>"
                                    <?= set_select('status', UserModel::STATUS_SUSPENDED, $user['status'] == UserModel::STATUS_SUSPENDED) ?>>
                                    <?= UserModel::STATUS_SUSPENDED ?>
                                </option>
                            </select>
                            <?= form_error('status'); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Pick a password" minlength="6" maxlength="50">
                            <span class="form-text">Leave it blank if you don't intended to change the password.</span>
                            <?= form_error('password') ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password"
                                   name="confirm_password"
                                   placeholder="Repeat your password" minlength="6" maxlength="50">
                            <?= form_error('confirm_password') ?>
                        </div>
                    </div>
                </div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group border border-danger rounded mb-0 py-2 px-3">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" <?= set_checkbox('password_never_expired', 1, $user['password_never_expired'] == 1) ?>
									   id="password_never_expired" name="password_never_expired" value="1">
								<label class="custom-control-label" for="password_never_expired">
									<span class="text-danger">Password Never Expired</span>
									<small class="text-muted d-block">
										User never forced to change their password
									</small>
								</label>
							</div>
						</div>
					</div>
				</div>

                <p class="form-section-title">Role Access</p>
                <div class="form-group">
                    <div class="row">
                        <?php foreach ($roles as $role): ?>
                            <?php
                            $hasRole = false;
                            foreach ($userRoles as $userRole) {
                                if ($role['id'] == $userRole['id_role']) {
                                    $hasRole = true;
                                    break;
                                }
                            }
                            ?>
                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input"<?= set_checkbox('roles', $role['id'], $hasRole); ?>
                                           id="role_<?= $role['id'] ?>" name="roles[]" value="<?= $role['id'] ?>">
                                    <label class="custom-control-label" for="role_<?= $role['id'] ?>">
                                        <?= strtoupper($role['role']) ?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?= form_error('roles[]'); ?>
                </div>

                <p class="form-section-title">Application Access</p>
                <div class="row">
                    <?php foreach ($applications as $application): ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input"
                                           id="application_<?= $application['id'] ?>" name="applications[]"
                                           value="<?= $application['id'] ?>"<?= set_checkbox('applications[]', $application['id'], $application['_selected']) ?>>
                                    <label class="custom-control-label" for="application_<?= $application['id'] ?>">
                                        <?= $application['title'] ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <p class="form-section-title">Default Application</p>
                <div class="form-group">
                    <select class="custom-select" name="default_application" id="default_application">
                        <option value="">-- No default application --</option>
                        <?php foreach ($applications as $application): ?>
                            <option value="<?= $application['id'] ?>" style="<?= $application['_selected'] ? '' : 'display: none' ?>"
                                <?= set_select('default_application', $application['id'], $application['id'] == $defaultApp) ?>>
                                <?= $application['title'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <span class="form-text">Redirect to default application after login.</span>
                    <?= form_error('default_application') ?>
                </div>

                <button type="submit" class="btn btn-success my-4" data-toggle="one-touch" data-touch-message="Updating...">Update User</button>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('components/modals/_alert') ?>
