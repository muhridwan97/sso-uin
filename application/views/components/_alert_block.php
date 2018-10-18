<?php if ($this->session->flashdata('status') != NULL): ?>
    <div class="alert alert-<?= $this->session->flashdata('status') ?> mb-0" role="alert">
        <div class="container">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
<?php endif; ?>