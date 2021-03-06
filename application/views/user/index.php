<?php $this->load->view('components/_banner_control') ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-md-3 col-lg-2">
            <?php $this->load->view('components/_sidebar_nav') ?>
        </div>
        <div class="col-md-9 col-lg-10">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-1">Users</h4>
                <span class="text-muted d-none d-sm-block ml-2 mr-auto text-light-gray">a list of accounts and editor</span>
                <div>
                    <a href="#modal-filter" data-toggle="modal" class="btn btn-outline-primary btn-sm pr-2 pl-2">
                        <i class="mdi mdi-filter-variant"></i>
                    </a>
                    <a href="<?= base_url(uri_string()) ?>?<?= $_SERVER['QUERY_STRING'] ?>&export=true" class="btn btn-outline-primary btn-sm pr-2 pl-2">
                        <i class="mdi mdi-file-download-outline"></i>
                    </a>
                    <?php if(AuthorizationModel::isAuthorized(PERMISSION_USER_CREATE)): ?>
                        <a href="<?= site_url('manage/user/create') ?>" class="btn btn-sm btn-primary">
                            <i class="mdi mdi-plus-box-outline mr-1"></i>Create
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <table class="table table-sm table-hover mt-3 responsive" id="table-user">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th class="text-md-right">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $statuses = [
                    UserModel::STATUS_ACTIVATED => 'success',
                    UserModel::STATUS_PENDING => 'primary',
                    UserModel::STATUS_SUSPENDED => 'danger',
                ]
                ?>
                <?php $no = isset($users) ? ($users['current_page'] - 1) * $users['per_page'] : 0 ?>
                <?php foreach ($users['data'] as $user): ?>
                    <tr>
                        <td class="text-md-center"><?= ++$no ?></td>
                        <td class="font-weight-bold">
                            <div class="d-flex flex-row align-items-center">
                                <div class="rounded mr-3" style="height:40px; width: 40px; background: url('<?= asset_url(if_empty($user['avatar'], base_url('assets/dist/img/no-avatar.png'))) ?>') center center / cover"></div>
                                <div style="flex: 1">
                                    <p style="margin-bottom: -5px"><?= strtoupper($user['name']) ?></p>
                                    <?php if(!empty($user['parent_user'])): ?>
                                        <small class="text-muted">Parent: <?= $user['parent_user'] ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td><?= $user['username'] ?></td>
                        <td>
                            <a href="mailto:<?= $user['email'] ?>"><?= $user['email'] ?></a>
                        </td>
                        <td>
                            <span class="badge badge-<?= $statuses[$user['status']] ?>">
                                <?= $user['status'] ?>
                            </span>
                        </td>
                        <td class="text-md-right">
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?php if(AuthorizationModel::isAuthorized(PERMISSION_USER_VIEW)): ?>
                                        <a class="dropdown-item" href="<?= site_url('manage/user/view/' . $user['id']) ?>">
                                            <i class="mdi mdi-eye-outline mr-2"></i> View
                                        </a>
                                    <?php endif; ?>
                                    <?php if(AuthorizationModel::isAuthorized(PERMISSION_USER_EDIT)): ?>
                                        <a class="dropdown-item" href="<?= site_url('manage/user/edit/' . $user['id']) ?>">
                                            <i class="mdi mdi-square-edit-outline mr-2"></i> Edit
                                        </a>
                                    <?php endif; ?>
                                    <?php if(AuthorizationModel::isAuthorized(PERMISSION_USER_DELETE)): ?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item btn-delete" href="#modal-delete" data-toggle="modal"
                                           data-id="<?= $user['id'] ?>" data-label="<?= $user['name'] ?>" data-title="User"
                                           data-url="<?= site_url('manage/user/delete/' . $user['id']) ?>">
                                            <i class="mdi mdi-trash-can-outline mr-2"></i> Delete
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($users['data'])): ?>
                    <tr>
                        <td colspan="6" class="text-center">No users available</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
            <?php $this->load->view('components/_pagination', ['pagination' => $users]) ?>
        </div>
    </div>
</div>

<?php $this->load->view('user/_modal_filter') ?>
<?php $this->load->view('components/modals/_delete') ?>
