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
                        <label class="col-sm-3 col-form-label" for="title">Title</label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext" id="title">
                                <?= $applicationRelease['application_title'] ?>
                            </p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="version">Version</label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext" id="version">
                                <?= $applicationRelease['version'] ?>
                            </p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="label">Label</label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext" id="label">
                                <?= $applicationRelease['label'] ?>
                            </p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="release_date">Released At</label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext" id="release_date">
                                <?= format_date($applicationRelease['release_date'], 'd F Y') ?>
                            </p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="created_at">Created At</label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext" id="created_at">
                                <?= format_date($applicationRelease['created_at'], 'd F Y') ?>
                            </p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="attachment">Attachment</label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext" id="attachment">
                                <?php if(empty($applicationRelease['attachment'])): ?>
                                    No attachment
                                <?php else: ?>
                                    <a href="<?= asset_url($applicationRelease['attachment']) ?>">
                                        <?= $applicationRelease['attachment'] ?>
                                    </a>
                                <?php endif ?>
                            </p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="description">Description</label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext" id="description">
                                <?= $applicationRelease['description'] ?>
                            </p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <a href="javascript:void()" onclick="history.back()" class="btn btn-secondary">Back</a>
                        <a href="<?= site_url('manage/release/edit/' . $applicationRelease['id']) ?>" class="btn btn-primary">
                            Edit Release
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('user/_modal_filter') ?>
<?php $this->load->view('components/modals/_delete') ?>
