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
    <title><?= $this->config->item('app_name') ?> | Page not found 404</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/dist/app.css') ?>">
</head>

<body>

<div class="d-flex align-items-center justify-content-center text-center" style="height: calc(100vh - 80px)">
    <div class="px-3">
        <h1 class="display-1">404</h1>
        <h1>Page Not Found</h1>
        <p class="lead text-muted">The page you’re looking for was not found.</p>
        <a class="btn btn-primary mt-2" href="<?= site_url() ?>">
            Back to home
        </a>
    </div>
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

</body>

</html>