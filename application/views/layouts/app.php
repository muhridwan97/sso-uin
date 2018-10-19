<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?= $this->security->get_csrf_hash() ?>">
    <meta name="base-url" content="<?= site_url() ?>">
    <meta name="user-id" content="<?= AuthModel::loginData('id') ?>">
    <meta name="theme-color" content="#ffffff">
    <title><?= $this->config->item('app_name') ?> | <?= isset($title) ? $title : 'Home' ?></title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.materialdesignicons.com/2.8.94/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/dist/app.css') ?>">
</head>

<body class="has-sticky-footer">
<nav id="main-navbar" class="navbar navbar-expand-lg navbar-light shadow-sm sticky-top py-2 py-sm-3" style="background: white">
    <div class="container">
        <span class="navbar-brand"><?= $this->config->item('app_name') ?></span>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link p-0" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="d-flex flex-row align-items-center">
                        <span class="d-none d-sm-inline-block mr-2"><?= AuthModel::loginData('name') ?></span>
                        <div class="rounded-circle" style="height: 37px; width: 37px; background: url('<?= base_url(if_empty(AuthModel::loginData('avatar'), 'assets/dist/img/no-avatar.png', 'uploads/')) ?>') center center / cover"></div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?= site_url('account') ?>">My Account</a>
                    <a class="dropdown-item" href="<?= site_url('notification') ?>">Notification</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= site_url('auth/logout') ?>">Sign Out</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<?php $this->load->view('components/_alert_block') ?>

<?php $this->load->view($page, $data) ?>

<?php $this->load->view('components/_footer') ?>

<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="<?= base_url('assets/dist/app.bundle.js') ?>"></script>

</body>

</html>