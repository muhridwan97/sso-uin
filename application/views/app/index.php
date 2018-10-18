<?php $this->load->view('components/_alert') ?>

<div class="app-banner">
    <div class="container">
        <h3>Active Application Directory</h3>
        <p>
            Single sign-on (SSO) a gate for user authentication service that permits to access Transcon Indonesia<br>
            management system use one set of login credentials
        </p>
        <div class="btn-section-wrapper">
            <a href="#" class="btn btn-section active">Application</a>
            <a href="#" class="btn btn-section">Setting</a>
        </div>
    </div>
</div>
<div class="app-banner-description">
    <div class="container">
        Applications supporting single sign on and full user management
    </div>
</div>
<div class="container app-wrapper">
    <div class="row">
        <?php foreach ($applications as $application): ?>
            <div class="col-sm-6 col-md-4 col-lg-3 card-app">
                <a href="<?= $application['url'] ?>" class="d-block">
                    <div class="card text-light" style="background: <?= if_empty($application['color'], '#5096ff') ?>">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <span class="app-icon align-middle mdi <?= if_empty($application['icon'], 'mdi-application') ?>"></span>
                        </div>
                    </div>
                    <div class="card-title">
                        <h3 class="app-title"><?= $application['title'] ?></h3>
                        <p class="app-subtitle mb-1"><?= $application['description'] ?></p>
                    </div>
                </a>
                <p class="app-version">
                    <?= $application['version'] ?> See <a href="<?= site_url('change-logs/' . $application['id']) ?>">Change Logs</a>
                </p>
            </div>
        <?php endforeach; ?>
        <div class="col-sm-6 col-md-4 col-lg-3 card-app">
            <a href="<?= site_url('account') ?>" class="d-block">
                <div class="card bg-blue text-light" style="background: #4d4f53">
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <span class="app-icon align-middle mdi mdi-security-account-outline"></span>
                    </div>
                </div>
                <div class="card-title">
                    <h3 class="app-title">My Account</h3>
                    <p class="app-subtitle">Manage your profile & password</p>
                </div>
            </a>
        </div>
    </div>
</div>