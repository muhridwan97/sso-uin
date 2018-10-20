<?php $this->load->view('components/_banner_control') ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-md-3 col-lg-2">
            <?php $this->load->view('components/_sidebar_nav') ?>
        </div>
        <div class="col-md-9 col-lg-10">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-1">Releases</h4>
                <span class="text-muted d-none d-sm-block ml-2 mr-auto text-light-gray">logs of deployments schedule</span>
                <div>
                    <a href="#modal-filter" data-toggle="modal" class="btn btn-outline-primary btn-sm pr-2 pl-2">
                        <i class="mdi mdi-filter-variant"></i>
                    </a>
                    <a href="<?= base_url(uri_string()) ?>?<?= $_SERVER['QUERY_STRING'] ?>&export=true" class="btn btn-outline-primary btn-sm pr-2 pl-2">
                        <i class="mdi mdi-file-download-outline"></i>
                    </a>
                    <a href="<?= site_url('manage/release/create') ?>" class="btn btn-sm btn-primary">
                        <i class="mdi mdi-plus-box-outline mr-1"></i>Release
                    </a>
                </div>
            </div>
            <div class="<?= $applicationReleases['total_data'] > 3 ? 'table-responsive' : '' ?>">
                <table class="table table-sm table-hover mt-3" id="table-release">
                    <tbody>
                    <?php
                    $statuses = [
                        ApplicationReleaseModel::LABEL_RELEASE => 'success',
                        ApplicationReleaseModel::LABEL_DRAFT => 'light',
                        ApplicationReleaseModel::LABEL_RC => 'primary',
                        ApplicationReleaseModel::LABEL_ALPHA => 'warning',
                        ApplicationReleaseModel::LABEL_BETA => 'danger',
                    ]
                    ?>
                    <?php $no = isset($applicationReleases) ? ($applicationReleases['current_page'] - 1) * $applicationReleases['per_page'] : 0 ?>
                    <?php foreach ($applicationReleases['data'] as $release): ?>
                        <tr>
                            <td class="text-center"><?= ++$no ?></td>
                            <td class="font-weight-bold"><?= $release['application_title'] ?></td>
                            <td><?= $release['version'] ?></td>
                            <td class="text-sm-right">
                                <span class="badge badge-<?= $statuses[$release['label']] ?> mr-2">
                                    <?= $release['label'] ?>
                                </span>
                            </td>
                            <td>at <?= format_date($release['release_date'], 'd F Y') ?></td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm dropdown-toggle" type="button"
                                            data-toggle="dropdown">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="<?= site_url('manage/release/view/' . $release['id']) ?>">
                                            <i class="mdi mdi-eye-outline mr-2"></i> View
                                        </a>
                                        <a class="dropdown-item" href="<?= site_url('manage/release/edit/' . $release['id']) ?>">
                                            <i class="mdi mdi-square-edit-outline mr-2"></i> Edit
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item btn-delete" href="#modal-delete" data-toggle="modal"
                                           data-id="<?= $release['id'] ?>" data-label="<?= $release['version'] ?>" data-title="Release"
                                           data-url="<?= site_url('manage/release/delete/' . $release['id']) ?>">
                                            <i class="mdi mdi-trash-can-outline mr-2"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($applicationReleases['data'])): ?>
                        <tr>
                            <td colspan="6" class="text-center">No users available</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-sm-between mt-3">
                <small class="text-muted mb-2">Total result <?= $applicationReleases['total_data'] ?> items</small>
                <?php $this->load->view('components/_pagination', ['pagination' => $applicationReleases]) ?>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('release/_modal_filter') ?>
<?php $this->load->view('components/modals/_delete') ?>