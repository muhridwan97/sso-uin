<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= site_url('/') ?>">
                <span class="mdi mdi-arrow-left"></span> Home
            </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Help Page
        </li>
    </ol>
</nav>
<div class="panel-body">
    <h3>Help and Supports</h3>
    <p class="text-muted">Last updated: October 20, 2018</p>
    <p>
        For more information please contact our support at
        <a href="mailto:<?= get_setting('email_support') ?>">
            <?= get_setting('email_support') ?>
        </a>
        and if you found any bugs, please sent them to
        <a href="mailto:<?= get_setting('email_bug_report') ?>">
            <?= get_setting('email_bug_report') ?>
        </a>
    </p>
</div>