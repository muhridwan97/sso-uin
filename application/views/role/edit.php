<?php $this->load->view('components/_banner_control') ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-md-3 col-lg-2">
            <?php $this->load->view('components/_sidebar_nav') ?>
        </div>
        <div class="col-md-9 col-lg-10">
            <h4 class="card-title"><?= $title ?></h4>
            <form action="<?= site_url('manage/role/update/' . $role['id']) ?>" method="post" id="form-role" class="edit">
                <?= _csrf() ?>
                <?= _method('put') ?>
                <p class="form-section-title">Role Access</p>
                <div class="form-group">
                    <label for="role">Role</label>
                    <input type="text" class="form-control" id="role" name="role"
                           placeholder="Role name" maxlength="50" value="<?= set_value('role', $role['role']) ?>">
                    <?= form_error('role') ?>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" maxlength="500"
                              placeholder="Enter role description"><?= set_value('description', $role['description']) ?></textarea>
                    <?= form_error('description') ?>
                </div>

                <p class="form-section-title">Role Access</p>
                <div class="form-group">
                    <div class="row">
                        <?php $lastGroup = '' ?>
                        <?php $lastSubGroup = '' ?>
                        <?php foreach ($permissions as $permission): ?>
                            <?php
                            $hasPermission = false;
                            foreach ($rolePermissions as $rolePermission) {
                                if ($permission['id'] == $rolePermission['id_permission']) {
                                    $hasPermission = true;
                                    break;
                                }
                            }
                            ?>

                            <?php
                            $module = $permission['module'];
                            $submodule = $permission['submodule'];
                            ?>

                            <?php if($lastGroup != $module): ?>
                                <?php
                                $lastGroup = $module;
                                $lastGroupName = preg_replace('/ /', '_', $lastGroup);
                                ?>
                                <div class="col-12">
                                    <hr>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input check_all" id="check_all_<?= $lastGroupName ?>" value="<?= $lastGroupName ?>" <?= set_checkbox('check_all_' . $lastGroupName, $lastGroupName) ?>>
                                        <label class="custom-control-label" for="check_all_<?= $lastGroupName ?>">
                                            Module <?= ucwords($lastGroup) ?> (Check All)
                                        </label>
                                    </div>
                                    <hr class="mb-1">
                                </div>
                            <?php endif; ?>

                            <?php if($lastSubGroup != $submodule): ?>
                                <?php $lastSubGroup = $submodule; ?>
                                <div class="col-12">
                                    <div class="mb-2 mt-3">
                                        <h6>
                                            <?= ucwords(preg_replace('/\-/', ' ', $lastSubGroup)) ?>
                                        </h6>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="col-sm-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input <?= $lastGroupName ?>" id="permission_<?= $permission['id'] ?>" name="permissions[]" value="<?= $permission['id'] ?>" <?= set_checkbox('permissions', $permission['id'], $hasPermission) ?>>
                                    <label class="custom-control-label" style="font-weight: 400" for="permission_<?= $permission['id'] ?>">
                                        <?= ucwords(preg_replace('/(_|\-)/', ' ', $permission['permission'])) ?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?= form_error('permissions[]'); ?>
                </div>

                <button type="submit" class="btn btn-success my-4" data-toggle="one-touch" data-touch-message="Updating...">Update Role</button>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('components/modals/_alert') ?>