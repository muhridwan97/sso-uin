<?php $this->load->view('components/_banner_control') ?>

<div class="container content-wrapper">
    <div class="row">
        <div class="col-md-3 col-lg-2">
            <?php $this->load->view('components/_sidebar_nav') ?>
        </div>
        <div class="col-md-9 col-lg-10">
            <h4 class="card-title"><?= $title ?></h4>
            <form action="<?= site_url('manage/application/update/' . $application['id']) ?>" method="post" id="form-application">
                <?= _csrf() ?>
                <?= _method('put') ?>
                <p class="form-section-title">Basic Info</p>
                <div class="row">
                    <div class="col-sm-7">
                        <div class="form-group">
                            <label for="title">Application Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                   placeholder="Application name" required maxlength="50"
                                   value="<?= set_value('title', $application['title']) ?>">
                            <?= form_error('title') ?>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="version">Version</label>
                            <input type="text" class="form-control-plaintext" readonly id="version" name="version"
                                   placeholder="Put app current version eg. v2.1.0" required maxlength="20"
                                   pattern="^[vV]\d+\.\d+(\.\d+)?" title="Eg. v2.1.0 or v3.0"
                                   value="<?= set_value('version', $application['version']) ?>">
                            <?= form_error('version') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-group">
                        <label for="description">Sort Description</label>
                        <input type="text" class="form-control" id="description" name="description"
                               placeholder="Simple app description" required maxlength="35"
                               value="<?= set_value('description', $application['description']) ?>">
                        <?= form_error('description') ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <div class="form-group">
                            <label for="url">URL</label>
                            <input type="url" class="form-control" id="url" name="url"
                                   placeholder="Index url of the application" required maxlength="50"
                                   value="<?= set_value('url', $application['url']) ?>">
                            <span class="form-text">Put full url including protocols or domain (IP is not allowed for now).</span>
                            <?= form_error('url') ?>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="order">Set Order To</label>
                            <select class="custom-select" name="order" id="order" required>
                                <?php $order = 1; ?>
                                <?php foreach ($applications as $app): ?>
                                    <option value="<?= $order ?>"<?= set_select('order', $order, $application['order'] == $order) ?>>
                                        <?= $order ?> - <?= $app['title'] ?>
                                    </option>
                                    <?php $order++ ?>
                                <?php endforeach; ?>
                            </select>
                            <span class="form-text">Selected application order will push to next order.</span>
                            <?= form_error('order') ?>
                        </div>
                    </div>
                </div>

                <p class="form-section-title">Look and Feel</p>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="icon">Application Icon</label>
                            <input type="text" class="form-control" id="icon" name="icon"
                                   placeholder="Click the icon below to select" required readonly maxlength="50"
                                   value="<?= set_value('icon', $application['icon']) ?>">
                            <p class="form-text">
                                The icon is provided by Material Design Icons (Cheatsheet)<br>
                                <a href="https://cdn.materialdesignicons.com/2.8.94/" target="_blank">https://cdn.materialdesignicons.com/2.8.94</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="color">Color Theme</label>
                            <input type="color" class="form-control" id="color" name="color"
                                   placeholder="Simple app description" required maxlength="20"
                                   value="<?= set_value('color', $application['color']) ?>">
                            <p class="form-text">
                                If your browser does not support color picker, just put hexadecimal (with # symbol) or RGB color format
                            </p>
                            <?= form_error('color') ?>
                        </div>
                    </div>
                </div>

                <?php $this->load->view('application/_icon_selector') ?>

                <button type="submit" class="btn btn-success my-5" data-toggle="one-touch" data-touch-message="Updating...">Update Application</button>
            </form>
        </div>
    </div>
</div>
