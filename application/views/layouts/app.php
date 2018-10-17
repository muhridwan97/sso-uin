<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?= $this->security->get_csrf_hash() ?>">
    <meta name="base-url" content="<?= site_url() ?>">
    <meta name="user-id" content="">
    <meta name="theme-color" content="#5983e8">
    <title><?= $this->config->item('app_name') ?> | <?= isset($title) ? $title : 'Home' ?></title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/dist/app.css') ?>">
</head>

<body style="position: relative" data-spy="scroll" data-target="#main-navbar" data-offset="100">
<nav id="main-navbar" class="navbar navbar-expand-lg navbar-light border-bottom shadow-sm sticky-top py-3" style="background: white">
    <div class="container">
        <span class="navbar-brand font-weight-bold"><?= $this->config->item('app_name') ?></span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto mr-2">
                <li class="nav-item">
                    <a class="nav-link" href="#warehouse">Warehouse</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#purchasing">Purchasing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#absent">Absent</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#hr">HR</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#crm">CRM</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#vms">VMS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#ticket">Ticket</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#training">Training</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#evaluation">Evaluation</a>
                </li>
            </ul>
            <form class="form-inline d-none d-lg-inline">
                <a class="btn btn-sm btn-outline-primary" href="http://transcon-indonesia.com">HOME</a>
            </form>
        </div>
    </div>
</nav>

<div class="container py-3 mt-3">
    <?php $this->load->view('components/_alert') ?>
    <?php $this->load->view($page, $data) ?>

    <footer class="mt-4 mt-md-5 pt-md-3 border-top">
        <small class="d-block mb-3 text-muted">
            &copy; Copyright <?= date('Y') ?> <strong><?= $this->config->item('app_author') ?></strong> all rights reserved.
        </small>
    </footer>
</div>

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
<script>
    $(document).ready( function () {
        $.ajaxSetup({
            headers: {
                "X-CSRFToken": variables.csrfToken
            }
        });

        $("#main-navbar ul li a[href^='#']").on('click', function(e) {
            // prevent default anchor click behavior
            e.preventDefault();

            // store hash
            var hash = this.hash;

            // animate
            $('html, body').animate({
                scrollTop: $(hash).offset().top - 100
            }, 1000, function(){

                // when done, add hash to url
                // (default click behaviour)
                // window.location.hash = hash;
            });

        });
    } );
</script>
</body>

</html>