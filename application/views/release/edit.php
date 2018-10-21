<?php $this->load->view('components/_banner_control') ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-md-3 col-lg-2">
            <?php $this->load->view('components/_sidebar_nav') ?>
        </div>
        <div class="col-md-9 col-lg-10">
            <h4 class="card-title pt-2"><?= $title ?></h4>
            <form action="<?= site_url('manage/release/update/' . $applicationRelease['id']) ?>" method="post" enctype="multipart/form-data" id="form-release">
                <?= _csrf() ?>
                <?= _method('put') ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="application_title">Application</label>
                            <input type="hidden" name="application" value="<?= $applicationRelease['id_application'] ?>" required>
                            <input type="text" class="form-control-plaintext" readonly id="application_title"
                                   name="application_title" required
                                   value="<?= $applicationRelease['application_title'] ?>">
                            <?= form_error('application') ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="application_version">Version</label>
                            <input type="hidden" name="major" value="<?= $applicationRelease['major'] ?>" required>
                            <input type="hidden" name="minor" value="<?= $applicationRelease['minor'] ?>" required>
                            <input type="hidden" name="patch" value="<?= $applicationRelease['patch'] ?>" required>
                            <input type="text" class="form-control-plaintext" readonly id="application_version"
                                   name="application_version" required
                                   value="v<?= $applicationRelease['major'] ?>.<?= $applicationRelease['minor'] ?>.<?= $applicationRelease['patch'] ?>">
                            <?= form_error('major') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description"
                           placeholder="Description the changes that you make"
                              minlength="20" maxlength="1000"><?= set_value('description', $applicationRelease['description']) ?></textarea>
                    <?= form_error('description') ?>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="attachment">Attachment</label>
                            <input type="file" id="attachment" name="attachment" class="file-upload-default" data-max-size="5000000">
                            <div class="input-group">
                                <input type="text" class="form-control file-upload-info" disabled placeholder="Upload attachment" value="<?= $applicationRelease['attachment'] ?>">
                                <div class="input-group-append">
                                    <button class="file-upload-browse btn btn-default btn-simple-upload" type="button">
                                        Select File
                                    </button>
                                </div>
                            </div>
                            <?= form_error('attachment') ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="label">Label</label>
                                    <select class="custom-select" name="label" id="label" required>
                                        <?php foreach (ApplicationReleaseModel::LABELS as $label): ?>
                                            <option value="<?= $label ?>" <?= set_select('label', $label, $label == $applicationRelease['label']) ?>>
                                                <?= $label ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= form_error('label'); ?>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="release_date">Release Date</label>
                                    <input type="date" class="form-control" name="release_date" id="release_date" required
                                           placeholder="Pick a release date" value="<?= set_value('release_date', $applicationRelease['release_date']) ?>">
                                    <?= form_error('release_date'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success my-4">Update Release</button>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('components/modals/_alert') ?>