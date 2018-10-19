<?php $this->load->view('components/_banner_control') ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-md-3 col-lg-2">
            <?php $this->load->view('components/_sidebar_nav') ?>
        </div>
        <div class="col-md-9 col-lg-10">
            <div class="d-flex justify-content-between">
                <h4 class="card-title pt-2">Users</h4>
                <div>
                    <a href="#modal-filter" data-toggle="modal" class="btn btn-outline-primary btn-sm pr-2 pl-2">
                        <i class="mdi mdi-filter-variant"></i>
                    </a>
                    <a href="<?= base_url(uri_string()) ?>?<?= $_SERVER['QUERY_STRING'] ?>&export=true" class="btn btn-outline-primary btn-sm pr-2 pl-2">
                        <i class="mdi mdi-file-download-outline"></i>
                    </a>
                    <a href="<?= site_url('manage/application/create') ?>" class="btn btn-sm btn-primary">
                        <i class="mdi mdi-plus-box-outline mr-1"></i>Create
                    </a>
                </div>
            </div>
            <div class="<?= $applications['total_data'] > 3 ? 'table-responsive' : '' ?>">
                <table class="table table-hover mt-3" id="table-users">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 60px">No</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Version</th>
                        <th style="width: 80px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no = isset($applications) ? ($applications['current_page'] - 1) * $applications['per_page'] : 0 ?>
                    <?php foreach ($applications['data'] as $application): ?>
                        <tr>
                            <td class="text-center"><?= ++$no ?></td>
                            <td>
                                <a href="<?= $application['url'] ?>">
                                    <?= $application['title'] ?>
                                </a>
                            </td>
                            <td><?= $application['description'] ?></td>
                            <td><?= $application['version'] ?></td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm dropdown-toggle" type="button"
                                            data-toggle="dropdown">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="<?= site_url('manage/application/view/' . $application['id']) ?>">
                                            <i class="mdi mdi-eye-outline mr-2"></i> View
                                        </a>
                                        <a class="dropdown-item" href="<?= site_url('manage/application/edit/' . $application['id']) ?>">
                                            <i class="mdi mdi-square-edit-outline mr-2"></i> Edit
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item btn-delete" href="#modal-delete" data-toggle="modal"
                                           data-id="<?= $application['id'] ?>" data-label="<?= $application['title'] ?>" data-title="Employee"
                                           data-url="<?= site_url('manage/application/delete/' . $application['id']) ?>">
                                            <i class="mdi mdi-trash-can-outline mr-2"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($applications['data'])): ?>
                        <tr>
                            <td colspan="6" class="text-center">No users available</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-sm-between mt-3">
                <small class="text-muted mb-2">Total result <?= $applications['total_data'] ?> items</small>
                <?php $this->load->view('components/_pagination', ['pagination' => $applications]) ?>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('application/_modal_filter') ?>
<?php $this->load->view('components/modals/_delete') ?>