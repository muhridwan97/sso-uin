<?php $this->load->view('components/_banner_control') ?>

<div class="container app-wrapper">
    <div class="row">
        <?php foreach ($applications as $application): ?>
            <div class="col-sm-6 col-md-4 col-lg-3 card-app mb-4 mb-sm-5">
                <div class="d-flex flex-row flex-sm-column">
                    <a href="<?= site_url($application['url']) ?>">
                        <div class="card text-light mr-3" style="background: <?= if_empty($application['color'], '#5096ff') ?>">
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <span class="app-icon align-middle mdi <?= if_empty($application['icon'], 'mdi-application') ?>"></span>
                            </div>
                        </div>
                    </a>
                    <div class="card-title d-flex align-items-center d-sm-block">
                        <div>
                            <a href="<?= site_url($application['url']) ?>" class="d-block">
                                <h3 class="app-title"><?= $application['title'] ?></h3>
                                <p class="app-subtitle mb-1"><?= $application['description'] ?></p>
                            </a>
                            <p class="app-version mb-0">
                                <?= $application['version'] ?> See <a href="<?= site_url('change-logs/' . $application['id']) ?>">Change Logs</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="col-sm-6 col-md-4 col-lg-3 card-app mb-4 mb-sm-5">
            <div class="d-flex flex-row flex-sm-column">
                <a href="<?= site_url($application['url']) ?>">
                    <div class="card text-light mr-3" style="background: #4d4f53">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <span class="app-icon align-middle mdi mdi-security-account-outline"></span>
                        </div>
                    </div>
                </a>
                <div class="card-title d-flex align-items-center d-sm-block">
                    <div>
                        <a href="<?= site_url('account') ?>" class="d-block">
                            <h3 class="app-title">My Account</h3>
                            <p class="app-subtitle">Manage your profile & password</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>