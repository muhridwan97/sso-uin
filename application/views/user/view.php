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
                        <div class="col-lg-2">
                            <div class="rounded my-3" style="height:100px; width: 100px; background: url('<?= base_url(if_empty($user['avatar'], 'assets/dist/img/no-avatar.png', '/uploads/')) ?>') center center / cover"></div>
                        </div>
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label" for="name">Name</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext" id="name">
                                                <?= $user['name'] ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label" for="username">Username</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext" id="username">
                                                <?= $user['username'] ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label" for="email">Email</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext" id="email">
                                                <?= $user['email'] ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label" for="status">Status</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext" id="status">
                                                <?= $user['status'] ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label" for="created_at">Created At</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext" id="created_at">
                                                <?= format_date($user['created_at'], 'd F Y H:i') ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label" for="updated_at">Updated At</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext" id="updated_at">
                                                <?= if_empty(format_date($user['updated_at'], 'd F Y H:i'), '-') ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <a href="javascript:void()" onclick="history.back()" class="btn btn-secondary">Back</a>
                        <a href="<?= site_url('manage/user/edit/' . $user['id']) ?>" class="btn btn-primary">
                            Edit User
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('user/_modal_filter') ?>
<?php $this->load->view('components/modals/_delete') ?>