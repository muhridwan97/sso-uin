<?php $this->load->view('components/_banner_control') ?>

    <div class="container content-wrapper">
        <div class="row">
            <div class="col-md-3 col-lg-2">
                <p class="form-section-title">Main Menu</p>
                <div class="nav flex-column nav-pills mr-md-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" href="<?= site_url('manage/user') ?>">Users</a>
                    <a class="nav-link" href="<?= site_url('manage/application') ?>">Applications</a>
                    <a class="nav-link" href="<?= site_url('manage/changelog') ?>">Release</a>
                    <a class="nav-link" href="<?= site_url('manage/setting') ?>">Settings</a>
                </div>
            </div>
            <div class="col-md-9 col-lg-10">
                <h4 class="card-title pt-2"><?= $title ?></h4>
                <div class="form-plaintext">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="rounded my-3" style="height:100px; width: 100px; background: url('<?= base_url(if_empty($user['avatar'], 'assets/dist/img/no-avatar.png', '/uploads/')) ?>') center center / cover"></div>
                        </div>
                        <div class="col-lg-10 pt-lg-3">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="name">Name</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" id="name">
                                                <?= $user['name'] ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="username">Username</label>
                                        <div class="col-sm-9">
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
                                        <label class="col-sm-3 col-form-label" for="email">Email</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" id="email">
                                                <?= $user['email'] ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="status">Status</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" id="status">
                                                <?= $user['status'] ?>
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