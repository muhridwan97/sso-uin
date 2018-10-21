<?php $this->load->view('components/_banner_control') ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-md-3 col-lg-2">
            <?php $this->load->view('components/_sidebar_nav') ?>
        </div>
        <div class="col-md-9 col-lg-10">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-1">Applications</h4>
                <span class="text-muted d-none d-sm-block ml-2 mr-auto text-light-gray">a list of system collection</span>
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
            <table class="table table-sm table-hover mt-3 responsive" id="table-application">
                <tbody>
                <?php $no = isset($applications) ? ($applications['current_page'] - 1) * $applications['per_page'] : 0 ?>
                <?php foreach ($applications['data'] as $application): ?>
                    <tr>
                        <td class="text-center responsive-hide"><?= ++$no ?></td>
                        <td class="font-weight-bold">
                            <div class="rounded text-white d-inline-block mr-3" style="background: <?= $application['color'] ?>">
                                <div style="width: 40px; height:40px;" class="d-flex justify-content-center align-items-center">
                                    <span class="mdi <?= $application['icon'] ?>" style="font-size: 20px"></span>
                                </div>
                            </div>
                            <a href="<?= $application['url'] ?>">
                                <?= $application['title'] ?>
                            </a>
                        </td>
                        <td><?= $application['description'] ?></td>
                        <td><?= $application['version'] ?></td>
                        <td>
                            <a href="<?= site_url('manage/release?application=' . $application['id']) ?>">
                                <?= if_empty($application['total_release'], 0) ?>x released
                            </a>
                        </td>
                        <td class="text-lg-right">
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                        data-toggle="dropdown">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="<?= site_url('manage/application/view/' . $application['id']) ?>">
                                        <i class="mdi mdi-eye-outline mr-2"></i> View
                                    </a>
                                    <a class="dropdown-item" href="<?= site_url('manage/release/create?application_id=' . $application['id']) ?>">
                                        <i class="mdi mdi-file-upload-outline mr-2"></i> Release New
                                    </a>
                                    <a class="dropdown-item" href="<?= site_url('manage/application/edit/' . $application['id']) ?>">
                                        <i class="mdi mdi-square-edit-outline mr-2"></i> Edit
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item btn-delete" href="#modal-delete" data-toggle="modal"
                                       data-id="<?= $application['id'] ?>" data-label="<?= $application['title'] ?>" data-title="Application"
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
                        <td colspan="6" class="text-center">No applications available</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
            <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-sm-between mt-3">
                <small class="text-muted mb-2">Total result <?= $applications['total_data'] ?> items</small>
                <?php $this->load->view('components/_pagination', ['pagination' => $applications]) ?>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('application/_modal_filter') ?>
<?php $this->load->view('components/modals/_delete') ?>