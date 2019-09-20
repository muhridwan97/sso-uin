<div class="app-banner">
    <div class="container">
        <h3 class="banner-title">Active Application Directory</h3>
        <p class="d-none d-sm-block">
            <?= get_setting('meta_description', 'Single sign-on (SSO) a gate for user authentication service that permits to access system use one set of login credentials') ?>
        </p>
        <div class="btn-section-wrapper">
            <?php $segment1 = $this->uri->segment(1) ?>
            <a href="<?= site_url('app') ?>" data-title="Applications supporting single sign on and full user management "
               class="btn btn-section<?= $segment1 == '' || $segment1 == 'app' ? ' active' : '' ?>">Application</a>
            <?php if(AuthorizationModel::isAuthorized(PERMISSION_USER_VIEW)
                || AuthorizationModel::isAuthorized(PERMISSION_ROLE_VIEW)
                || AuthorizationModel::isAuthorized(PERMISSION_APPLICATION_VIEW)
                || AuthorizationModel::isAuthorized(PERMISSION_RELEASE_VIEW)
                || AuthorizationModel::isAuthorized(PERMISSION_SETTING_EDIT)): ?>
                <?php
                    if(AuthorizationModel::isAuthorized(PERMISSION_USER_VIEW)) {
                        $destination = 'user';
                    } elseif(AuthorizationModel::isAuthorized(PERMISSION_ROLE_VIEW)) {
                        $destination = 'role';
                    } elseif(AuthorizationModel::isAuthorized(PERMISSION_APPLICATION_VIEW)) {
                        $destination = 'application';
                    } elseif(AuthorizationModel::isAuthorized(PERMISSION_RELEASE_VIEW)) {
                        $destination = 'release';
                    } elseif(AuthorizationModel::isAuthorized(PERMISSION_SETTING_EDIT)) {
                        $destination = 'setting';
                    } else {
                        $destination = '';
                    }
                ?>
                <a href="<?= site_url('manage/' . $destination) ?>" data-title="Manage master data and application module"
                   class="btn btn-section<?= $segment1 == 'manage' ? ' active' : '' ?>">Manage</a>
            <?php endif; ?>
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