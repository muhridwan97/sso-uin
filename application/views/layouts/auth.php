<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?= $this->security->get_csrf_hash() ?>">
    <meta name="base-url" content="<?= site_url() ?>">
    <meta name="user-id" content="">
    <meta name="theme-color" content="#ffffff">
    <title><?= $this->config->item('app_name') ?> | <?= isset($title) ? $title : 'Home' ?></title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/dist/app.css') ?>">
</head>

<body class="auth-layout">

<div class="container">
    <?php $this->load->view($page, $data) ?>
</div>

<footer class="auth-footer mt-4 mt-md-5 py-4 small">
    <div class="container d-sm-flex justify-content-between">
        <p class="text-muted mb-1">
            Copyright &copy; <?= date('Y') ?> <strong><?= $this->config->item('app_author') ?></strong>
            <span class="d-none d-sm-inline">all rights reserved</span>.
        </p>

        <ul class="list-inline mb-0">
            <li class="list-inline-item">
                <a href="http://www.transcon-indonesia.com">Home</a>
            </li>
            <li class="list-inline-item">
                <a href="<?= site_url('page/help') ?>">Help</a>
            </li>
            <li class="list-inline-item">
                <a href="<?= site_url('page/terms') ?>">Terms</a>
            </li>
        </ul>
    </div>
</footer>

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
</body>

</html>