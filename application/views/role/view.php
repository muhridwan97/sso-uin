<?php $this->load->view('components/_banner_control') ?>

<div class="container content-wrapper">
	<div class="row">
		<div class="col-md-3 col-lg-2">
			<?php $this->load->view('components/_sidebar_nav') ?>
		</div>
		<div class="col-md-9 col-lg-10">
			<h4 class="card-title"><?= $title ?></h4>
			<div class="form-plaintext">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="role">Role</label>
                    <div class="col-sm-8">
                        <p class="form-control-plaintext" id="role">
                            <?= $role['role'] ?>
                        </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="description">Description</label>
                    <div class="col-sm-8">
                        <p class="form-control-plaintext" id="description">
                            <?= $role['description'] ?>
                        </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="created_at">Created At</label>
                    <div class="col-sm-8">
                        <p class="form-control-plaintext" id="created_at">
                            <?= format_date($role['created_at'], 'd F Y H:i') ?>
                        </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="updated_at">Updated At</label>
                    <div class="col-sm-8">
                        <p class="form-control-plaintext" id="updated_at">
                            <?= if_empty(format_date($role['updated_at'], 'd F Y H:i'), '-') ?>
                        </p>
                    </div>
                </div>

                <p class="form-section-title">Role Access</p>

                <div class="form-group">
                    <div class="row">
                        <?php $lastGroup = '' ?>
                        <?php $lastSubGroup = '' ?>
                        <?php foreach ($permissions as $permission): ?>
                            <?php
                            $module = $permission['module'];
                            $submodule = $permission['submodule'];
                            ?>

                            <?php if($lastGroup != $module): ?>
                                <?php
                                $lastGroup = $module;
                                $lastGroupName = preg_replace('/ /', '_', $lastGroup);
                                ?>
                                <div class="col-12 mt-2">
                                    <hr>
                                    <h5 class="mt-2">
                                        Module <?= ucwords($lastGroup) ?>
                                    </h5>
                                    <hr class="mb-0">
                                </div>
                            <?php endif; ?>

                            <?php if($lastSubGroup != $submodule): ?>
                                <?php $lastSubGroup = $submodule; ?>
                                <div class="col-12">
                                    <div class="mb-2 mt-3">
                                        <h6 class="pl-3">
                                            <?= ucwords(preg_replace('/\-/', ' ', $lastSubGroup)) ?>
                                        </h6>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="col-sm-4">
                                <p class="mb-0 pl-3 text-muted">
                                    <?= ucwords(preg_replace('/(_|\-)/', ' ', $permission['permission'])) ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

				<div class="d-flex justify-content-between mt-3">
					<a href="javascript:void(0)" onclick="history.back()" class="btn btn-secondary">Back</a>
                    <?php if(AuthorizationModel::isAuthorized(PERMISSION_ROLE_EDIT)): ?>
                        <a href="<?= site_url('manage/role/edit/' . $role['id']) ?>" class="btn btn-primary">
                            Edit Role
                        </a>
                    <?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
