<?php $this->load->view('components/_banner_control') ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-md-3 col-lg-2">
            <?php $this->load->view('components/_sidebar_nav') ?>
        </div>
        <div class="col-md-9 col-lg-10">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-1">Roles</h4>
                <span class="text-muted d-none d-sm-block ml-2 mr-auto text-light-gray">a list of group access</span>
                <div>
                    <a href="#modal-filter" data-toggle="modal" class="btn btn-outline-primary btn-sm pr-2 pl-2">
                        <i class="mdi mdi-filter-variant"></i>
                    </a>
                    <a href="<?= base_url(uri_string()) ?>?<?= $_SERVER['QUERY_STRING'] ?>&export=true" class="btn btn-outline-primary btn-sm pr-2 pl-2">
                        <i class="mdi mdi-file-download-outline"></i>
                    </a>
                    <?php if(AuthorizationModel::isAuthorized(PERMISSION_ROLE_CREATE)): ?>
                        <a href="<?= site_url('manage/role/create') ?>" class="btn btn-sm btn-primary">
                            <i class="mdi mdi-plus-box-outline mr-1"></i>Create
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <table class="table table-sm table-hover mt-3 responsive" id="table-user">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Role</th>
                    <th>Permission</th>
                    <th>User</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th class="text-md-right">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = isset($roles) ? ($roles['current_page'] - 1) * $roles['per_page'] : 0 ?>
                <?php foreach ($roles['data'] as $role): ?>
                    <tr>
                        <td class="text-md-center"><?= ++$no ?></td>
                        <td><?= $role['role'] ?></td>
                        <td><?= numerical($role['total_permission']) ?></td>
                        <td>
                            <a href="<?= site_url('manage/user?role=' . $role['id']) ?>">
                                <?= numerical($role['total_user']) ?>
                            </a>
                        </td>
                        <td><?= if_empty($role['description'], '-') ?></td>
                        <td><?= format_date($role['created_at'], 'd F Y H:i') ?></td>
                        <td class="text-md-right">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle btn-action" type="button" data-toggle="dropdown">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?php if(AuthorizationModel::isAuthorized(PERMISSION_ROLE_VIEW)): ?>
                                        <a class="dropdown-item" href="<?= site_url('manage/role/view/' . $role['id']) ?>">
                                            <i class="mdi mdi-eye-outline mr-2"></i> View
                                        </a>
                                    <?php endif; ?>
                                    <?php if(AuthorizationModel::isAuthorized(PERMISSION_ROLE_EDIT)): ?>
                                        <a class="dropdown-item" href="<?= site_url('manage/role/edit/' . $role['id']) ?>">
                                            <i class="mdi mdi-square-edit-outline mr-2"></i> Edit
                                        </a>
                                    <?php endif; ?>
                                    <?php if(AuthorizationModel::isAuthorized(PERMISSION_ROLE_DELETE)): ?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item btn-delete" href="#modal-delete" data-toggle="modal"
                                           data-id="<?= $role['id'] ?>" data-label="<?= $role['role'] ?>" data-title="Role"
                                           data-url="<?= site_url('manage/role/delete/' . $role['id']) ?>">
                                            <i class="mdi mdi-trash-can-outline mr-2"></i> Delete
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if(empty($roles['data'])): ?>
                    <tr>
                        <td colspan="7">No roles data available</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
            <?php $this->load->view('components/_pagination', ['pagination' => $roles]) ?>
        </div>
    </div>
</div>

<?php $this->load->view('role/_modal_filter') ?>
<?php $this->load->view('components/modals/_delete') ?>