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
                    <a href="<?= site_url('manage/user/create') ?>" class="btn btn-sm btn-primary">
                        <i class="mdi mdi-plus-box-outline mr-1"></i>Create
                    </a>
                </div>
            </div>
            <div class="<?= $users['total_data'] > 3 ? 'table-responsive' : '' ?>">
                <table class="table table-sm table-hover mt-3" id="table-user">
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
                            <td class="text-center"><?= ++$no ?></td>
                            <td class="font-weight-bold">
                                <div class="d-flex flex-row align-items-center">
                                    <div class="rounded mr-3" style="height:40px; width: 40px; background: url('<?= base_url(if_empty($user['avatar'], 'assets/dist/img/no-avatar.png', 'uploads/')) ?>') center center / cover"></div>
                                    <?= $user['name'] ?>
                                </div>
                            </td>
                            <td><?= $user['username'] ?></td>
                            <td>
                                <a href="mailto:<?= $user['email'] ?>"><?= $user['email'] ?></a>
                            </td>
                            <td>
                                <label class="badge badge-<?= $statuses[$user['status']] ?>">
                                    <?= $user['status'] ?>
                                </label>
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="<?= site_url('manage/user/view/' . $user['id']) ?>">
                                            <i class="mdi mdi-eye-outline mr-2"></i> View
                                        </a>
                                        <a class="dropdown-item" href="<?= site_url('manage/user/edit/' . $user['id']) ?>">
                                            <i class="mdi mdi-square-edit-outline mr-2"></i> Edit
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item btn-delete" href="#modal-delete" data-toggle="modal"
                                           data-id="<?= $user['id'] ?>" data-label="<?= $user['name'] ?>" data-title="User"
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