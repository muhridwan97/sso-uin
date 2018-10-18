<?php $this->load->view('components/_banner_control') ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-sm-3 col-md-2">
            <p class="form-section-title">Main Menu</p>
            <div class="nav flex-column nav-pills mr-md-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" href="<?= site_url('manage/user') ?>">Users</a>
                <a class="nav-link" href="<?= site_url('manage/application') ?>">Applications</a>
                <a class="nav-link" href="<?= site_url('manage/changelog') ?>">Release</a>
                <a class="nav-link" href="<?= site_url('manage/setting') ?>">Settings</a>
            </div>
        </div>
        <div class="col-sm-9 col-md-10">
            <div class="d-flex justify-content-between">
                <h4 class="card-title pt-2">Users</h4>
                <div>
                    <a href="#modal-filter" data-toggle="modal" class="btn btn-primary btn-sm pr-2 pl-2">
                        <i class="mdi mdi-filter-variant"></i>
                    </a>
                    <a href="<?= base_url(uri_string()) ?>?<?= $_SERVER['QUERY_STRING'] ?>&export=true" class="btn btn-primary btn-sm pr-2 pl-2">
                        <i class="mdi mdi-file-download-outline"></i>
                    </a>
                    <a href="<?= site_url('employee/create') ?>" class="btn btn-sm btn-primary">
                        <i class="mdi mdi-plus-box-outline mr-2"></i>Create
                    </a>
                </div>
            </div>
            <div class="<?= $users['total_data'] > 3 ? 'table-responsive' : '' ?>">
                <table class="table table-hover mt-3" id="table-users">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 60px">No</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th style="width: 80px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $statuses = [
                        UserModel::STATUS_ACTIVATED => 'success',
                        UserModel::STATUS_PENDING => 'info',
                        UserModel::STATUS_SUSPENDED => 'danger',
                    ]
                    ?>
                    <?php $no = isset($users) ? ($users['current_page'] - 1) * $users['per_page'] : 0 ?>
                    <?php foreach ($users['data'] as $user): ?>
                        <tr>
                            <td class="text-center"><?= ++$no ?></td>
                            <td>
                                <div class="d-flex flex-row align-items-center">
                                    <div class="rounded mr-2" style="height:40px; width: 40px; background: url('<?= if_empty($user['avatar'], '/assets/dist/img/no-avatar.png', '/uploads/') ?>') center center / cover"></div>
                                    <?= $user['name'] ?>
                                </div>
                            </td>
                            <td><?= $user['username'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td>
                                <label class="badge badge-<?= $statuses[$user['status']] ?>">
                                    <?= $user['status'] ?>
                                </label>
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                            data-toggle="dropdown">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right row-employee"
                                         data-id="<?= $user['id'] ?>"
                                         data-label="<?= $user['name'] ?>">
                                        <a class="dropdown-item" href="<?= site_url('employee/view/' . $user['id']) ?>">
                                            <i class="mdi mdi-eye-outline mr-2"></i> View
                                        </a>
                                        <a class="dropdown-item" href="<?= site_url('employee/edit/' . $user['id']) ?>">
                                            <i class="mdi mdi-square-edit-outline mr-2"></i> Edit
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item btn-delete" href="#modal-delete" data-toggle="modal"
                                           data-id="<?= $user['id'] ?>" data-label="<?= $user['name'] ?>" data-title="Employee"
                                           data-url="<?= site_url('manage/user/delete/' . $user['id']) ?>">
                                            <i class="mdi mdi-trash-can-outline mr-2"></i> Delete
                                        </a>
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
            </div>
            <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-sm-between mt-3">
                <small class="text-muted mb-2">Total result <?= $users['total_data'] ?> items</small>
                <?php $this->load->view('components/_pagination', ['pagination' => $users]) ?>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('user/_modal_filter') ?>
<?php $this->load->view('components/modals/_delete') ?>