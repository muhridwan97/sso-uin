<?php $this->load->view('components/_banner_control') ?>

    <div class="container content-wrapper">
        <div class="row">
            <div class="col-md-3 col-lg-2">
                <?php $this->load->view('components/_sidebar_nav') ?>
            </div>
            <div class="col-md-9 col-lg-10">
                <h4 class="card-title pt-2"><?= $title ?></h4>
                <div class="form-plaintext">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="title">Title</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext" id="title">
                                        <?= $application['title'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="description">Description</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext" id="description">
                                        <?= $application['description'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="url">URL</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext" id="url">
                                        <a href="<?= $application['url'] ?>"><?= $application['url'] ?></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="color">Color</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext" id="color">
                                        <?= $application['color'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="icon">Icon</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext" id="icon">
                                        <span class="mdi <?= $application['icon'] ?> mr-2"></span>
                                        <?= $application['icon'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="version">Version</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext" id="version">
                                        <?= $application['version'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="order">Order</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext" id="order">
                                        <?= $application['order'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="created_at">Created At</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext" id="created_at">
                                        <?= format_date($application['created_at'], 'd F Y H:i') ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="updated_at">Updated At</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext" id="updated_at">
                                        <?= if_empty(format_date($application['updated_at'], 'd F Y H:i'), '-') ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <a href="javascript:void()" onclick="history.back()" class="btn btn-secondary">Back</a>
                        <a href="<?= site_url('manage/application/edit/' . $application['id']) ?>" class="btn btn-primary">
                            Edit Application
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('user/_modal_filter') ?>
<?php $this->load->view('components/modals/_delete') ?>