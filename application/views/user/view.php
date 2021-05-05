<?php $this->load->view('components/_banner_control') ?>

<div class="container content-wrapper">
	<div class="row">
		<div class="col-md-3 col-lg-2">
			<?php $this->load->view('components/_sidebar_nav') ?>
		</div>
		<div class="col-md-9 col-lg-10">
			<h4 class="card-title"><?= $title ?></h4>
			<div class="form-plaintext">
				<div class="row">
					<div class="col-lg-2">
						<div class="rounded my-3" style="height:100px; width: 100px; background: url('<?= asset_url(if_empty($user['avatar'], base_url('assets/dist/img/no-avatar.png'))) ?>') center center / cover"></div>
					</div>
					<div class="col-lg-10">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="name">Name</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="name">
                                    <?= $user['name'] ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="email">Email</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="email">
                                    <?= $user['email'] ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="user_type">Type</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="user_type">
                                    <?= $user['user_type'] ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="created_at">Created At</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="created_at">
                                    <?= format_date($user['created_at'], 'd F Y H:i') ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="username">Username</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="username">
                                    <?= $user['username'] ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="status">Status</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="status">
                                    <?php
                                    $statuses = [
                                        UserModel::STATUS_ACTIVATED => 'success',
                                        UserModel::STATUS_PENDING => 'primary',
                                        UserModel::STATUS_SUSPENDED => 'danger',
                                    ]
                                    ?>
                                    <span class="badge badge-<?= $statuses[$user['status']] ?>">
                                                <?= $user['status'] ?>
                                            </span>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="parent_user">Parent User</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="parent_user">
                                    <?= if_empty($user['parent_user'], 'No parent') ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="last_logged_in">Last Logged In</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="last_logged_in">
                                    <?= if_empty(format_date($user['last_logged_in'], 'd F Y H:i:s'), '-') ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="password_never_expired">Password Never Expired</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="password_never_expired">
                                    <?= $user['password_never_expired'] ? 'YES' : 'NO' ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="password_expired_at">Password Expired At</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="password_expired_at">
                                    <?= if_empty(format_date($user['password_expired_at'], 'd F Y H:i:s'), '-') ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="updated_at">Updated At</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="updated_at">
                                    <?= if_empty(format_date($user['updated_at'], 'd F Y H:i'), '-') ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="subordinate">Subordinates</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="subordinate">
                                    <?php foreach ($userSubordinates as $subordinate): ?>
                                        <a href="master/users/view/<?= $subordinate['id'] ?>" target="_blank" class="d-block">
                                            <?= $subordinate['name'] ?>
                                        </a>
                                    <?php endforeach; ?>
                                    <?php if(empty($userSubordinates)): ?>
                                        No subordinates
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="role">Roles</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="role">
                                    <?php foreach ($roles as $role): ?>
                                        <?= $role['role'] ?>
                                    <?php endforeach; ?>
                                    <?php if(empty($roles)): ?>
                                        No role access
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="application">Applications</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="application">
                                    <?php foreach ($userApplications as $application): ?>
                                        <a href="<?= $application['url'] ?>" target="_blank" class="d-block">
                                            <?= $application['title'] ?>
                                        </a>
                                    <?php endforeach; ?>
                                    <?php if(empty($userApplications)): ?>
                                        No applications access
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
					</div>
				</div>

				<div class="d-flex justify-content-between mt-3">
					<a href="javascript:void(0)" onclick="history.back()" class="btn btn-secondary">Back</a>
                    <?php if(AuthorizationModel::isAuthorized(PERMISSION_USER_EDIT)): ?>
                        <a href="<?= site_url('manage/user/edit/' . $user['id']) ?>" class="btn btn-primary">
                            Edit User
                        </a>
                    <?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
