<div class="sticky-top mb-4" style="top: 100px">
    <p class="form-section-title">Main Menu</p>
    <div class="nav flex-column nav-pills mr-md-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <?php $segment2 = $this->uri->segment(2) ?>
        <a class="nav-link<?= $segment2 == '' || $segment2 == 'user' ? ' active' : '' ?>" href="<?= site_url('manage/user') ?>">Users</a>
        <a class="nav-link<?= $segment2 == '' || $segment2 == 'application' ? ' active' : '' ?>" href="<?= site_url('manage/application') ?>">Applications</a>
        <a class="nav-link<?= $segment2 == '' || $segment2 == 'release' ? ' active' : '' ?>" href="<?= site_url('manage/release') ?>">Release</a>
        <a class="nav-link<?= $segment2 == '' || $segment2 == 'setting' ? ' active' : '' ?>" href="<?= site_url('manage/setting') ?>">Settings</a>
    </div>
</div>