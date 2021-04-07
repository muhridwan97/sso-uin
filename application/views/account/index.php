<div class="container content-wrapper">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)" onclick="history.back()">
                    <span class="mdi mdi-arrow-left"></span> Application
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                My Account
            </li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-lg-4">
            <h4 class="mb-1">My Account</h4>
            <p class="text-muted">Update your profile and password</p>
        </div>
        <div class="col-lg-8">
            <form action="<?= site_url('account') ?>" method="post" enctype="multipart/form-data">
                <?= _method('put') ?>
                <?= _csrf() ?>
                <p class="form-section-title">Basic Profile</p>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" class="form-control" id="name" name="name" <?= AuthorizationModel::isAuthorized(PERMISSION_ACCOUNT_EDIT) ? '' : 'readonly' ?>
								   placeholder="Your full name" maxlength="50" value="<?= set_value('name', $user['name']) ?>">
							<?= form_error('name') ?>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control" id="username" name="username" <?= AuthorizationModel::isAuthorized(PERMISSION_ACCOUNT_EDIT) ? '' : 'readonly' ?>
								   placeholder="Enter username" maxlength="50" value="<?= set_value('username', $user['username']) ?>">
							<?= form_error('username') ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="email">Email Address</label>
					<input type="email" class="form-control" id="email" name="email" <?= AuthorizationModel::isAuthorized(PERMISSION_ACCOUNT_EDIT) ? '' : 'readonly' ?>
						   placeholder="Your email address" maxlength="50" value="<?= set_value('email', $user['email']) ?>">
					<?= form_error('email') ?>
				</div>

                <p class="form-section-title">Avatar</p>
                <div class="form-group">
                    <div class="d-flex flex-column flex-sm-row align-items-center">
                        <div class="rounded mb-2 mb-sm-0" style="height:140px; width: 140px; background: url('<?= asset_url(if_empty($user['avatar'], base_url('assets/dist/img/no-avatar.png'))) ?>') center center / cover"></div>

                        <div class="mr-lg-3 ml-sm-4">
                            <label for="avatar">Photo</label>
                            <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png" class="file-upload-default" data-max-size="2000000">
                            <div class="input-group">
                                <input type="text" class="form-control file-upload-info" disabled placeholder="Upload photo">
                                <span class="input-group-append">
                                <button class="file-upload-browse btn btn-default btn-simple-upload" type="button">
                                    Select Photo
                                </button>
                            </span>
                            </div>
                            <span class="form-text">Leave it unselected if you don't change avatar.</span>
                            <?= form_error('avatar') ?>
                        </div>
                    </div>
                </div>

                <p class="form-section-title">Change Password</p>
                <div class="form-group">
                    <label for="password">Current Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                           placeholder="Your current password" required maxlength="50">
                    <span class="form-text">Password is required for update to make sure it's really you.</span>
                    <?= form_error('password') ?>
                </div>
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" class="form-control" id="new_password" name="new_password"
                           placeholder="Pick new password" minlength="6" maxlength="50">
                    <?= form_error('new_password') ?>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                           placeholder="Repeat your password" minlength="6" maxlength="50">
                    <?= form_error('confirm_password') ?>
                </div>
                <button type="submit" class="btn btn-primary my-4" data-toggle="one-touch" data-touch-message="Updating...">Update Account</button>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('components/modals/_alert') ?>
