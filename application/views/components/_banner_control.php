<div class="app-banner">
    <div class="container">
        <h3 class="banner-title">Active Application Directory</h3>
        <p class="d-none d-sm-block">
            Single sign-on (SSO) a gate for user authentication service that permits to access Transcon Indonesia<br>
            management system use one set of login credentials
        </p>
        <div class="btn-section-wrapper">
            <?php $segment1 = $this->uri->segment(1) ?>
            <a href="<?= site_url('app') ?>" data-title="Applications supporting single sign on and full user management "
               class="btn btn-section<?= $segment1 == '' || $segment1 == 'app' ? ' active' : '' ?>">Application</a>
            <a href="<?= site_url('manage/user') ?>" data-title="Manage master data and application module"
               class="btn btn-section<?= $segment1 == 'manage' ? ' active' : '' ?>">Manage</a>
            <a href="<?= site_url('notification') ?>" data-title="Your detail push notification"
               class="d-none d-sm-inline-block btn btn-section<?= $segment1 == 'notification' ? ' active' : '' ?>">Notification</a>
        </div>
    </div>
</div>
<div class="app-banner-description d-none d-sm-block">
    <div class="container">
        &nbsp;
    </div>
</div>