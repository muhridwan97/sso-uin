<?php $this->load->view('components/_banner_control') ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-md-3 col-lg-2">
            <?php $this->load->view('components/_sidebar_nav') ?>
        </div>
        <div class="col-md-9 col-lg-10">
            <h4 class="card-title pt-2">Draft a Release</h4>
            <form action="<?= site_url('manage/release/update/' . $applicationRelease['id']) ?>" method="post" enctype="multipart/form-data">
                <?= _csrf() ?>
                <?= _method('put') ?>
                <p class="form-section-title">Profile Info</p>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="application">Application</label>
                            <select class="custom-select" name="application" id="application" required>
                                <?php foreach ($applications as $application): ?>
                                    <option value="<?= $application['id'] ?>"<?= set_select('application', $application['id'], $application['id'] == $applicationRelease['id_application']) ?>>
                                        <?= $application['title'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('application') ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="major">Version</label>
                                    <input type="number" class="form-control" id="major" name="major"
                                           placeholder="Major" min="0" value="<?= set_value('major', $applicationRelease['major']) ?>">
                                    <?= form_error('major') ?>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="minor">&nbsp;</label>
                                    <input type="number" class="form-control" id="minor" name="minor"
                                           placeholder="Minor" min="0" value="<?= set_value('minor', $applicationRelease['minor']) ?>">
                                    <?= form_error('minor') ?>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="patch">&nbsp;</label>
                                    <input type="number" class="form-control" id="patch" name="patch"
                                           placeholder="Patch" min="0" value="<?= set_value('patch', $applicationRelease['patch']) ?>">
                                    <?= form_error('patch') ?>
                                </div>
                            </div>
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
                    <div class="col-sm-6">
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
                    <div class="col-sm-6">
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