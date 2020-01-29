<?php $this->load->view('components/_banner_control') ?>

<div class="container app-wrapper">
    <h3>Notifications</h3>
    <p class="mb-4">Your last 30 days updates will show up here.</p>

	<?php foreach ($notifications as $notification): ?>
		<div class="d-flex flex-row mb-3">
			<i class="mdi mdi-information-outline mr-2"></i>
			<div class="d-sm-flex justify-content-sm-between flex-grow-1">
				<div>
					<a href="<?= site_url('notification/read/' . $notification['id'] . '?source=' . $notification['source'] . '&redirect=') ?><?= if_empty(get_if_exist($notification['data'], 'url', $notification['url']), '#') ?>"
					   class="mb-0 d-block <?= $notification['is_read'] ? 'text-dark' : 'text-success' ?>" style="font-size: 0.9rem">
						<?= is_array($notification['data']) ? $notification['data']['message'] : $notification['data'] ?>
					</a>
					<p class="text-muted small text-uppercase mb-0"><?= $notification['source'] ?></p>
				</div>
				<small class="text-muted text-right" style="min-width: 170px">
					<?= relative_time($notification['created_at']) ?>
				</small>
			</div>
		</div>
	<?php endforeach; ?>
	<?php if(empty($notifications)): ?>
		<p class="text-muted">No notification available.</p>
	<?php endif; ?>
</div>
