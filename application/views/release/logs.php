<?php $this->load->view('components/_banner_control') ?>

<div class="container content-wrapper">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= site_url('app') ?>">
                    <span class="mdi mdi-arrow-left"></span> Application
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= site_url('manage/release') ?>">
                    Releases
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <?= $application['title'] ?>
            </li>
        </ol>
    </nav>
    <h3 class="mb-1"><?= $application['title'] ?></h3>
    <p class="text-muted mb-2"><?= $application['description'] ?></p>
    <p class="text-primary"><?= $application['total_release'] ?>x released</p>

    <?php
    $statuses = [
        ApplicationReleaseModel::LABEL_RELEASE => 'success',
        ApplicationReleaseModel::LABEL_DRAFT => 'light',
        ApplicationReleaseModel::LABEL_RC => 'primary',
        ApplicationReleaseModel::LABEL_ALPHA => 'warning',
        ApplicationReleaseModel::LABEL_BETA => 'danger',
    ]
    ?>
    <?php $isFirst = true; ?>
    <?php foreach ($applicationReleases as $release): ?>
        <div class="mt-4 mb-5">
            <div class="d-flex flex-row align-items-start">
                <h4 class="mr-2 mb-0"><?= $release['version'] ?></h4>
                <span class="badge badge-<?= $statuses[$release['label']] ?>">
                    <?= $release['label'] ?>
                </span>
                <?php if ($isFirst): ?>
                    <span class="badge badge-success ml-2">
                        LATEST
                    </span>
                    <?php $isFirst = false; ?>
                <?php endif; ?>
            </div>
            <small class="text-muted">
                Issued at <?= format_date($release['release_date'], 'd F Y') ?>
            </small>
            <p class="mb-2"><?= $release['description'] ?></p>
            <?php if (!empty($release['attachment'])): ?>
                <p>
                    <i class="mdi mdi-file-outline"></i>
                    <span class="text-muted">Attachment:</span>
                    <a href="<?= base_url('uploads/' . $release['attachment']) ?>">Download</a>
                </p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>