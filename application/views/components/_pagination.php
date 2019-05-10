<?php if(isset($pagination)): ?>
    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-center justify-content-sm-between mt-3">
        <small class="text-muted mb-2 mb-sm-0">Total result <?= $pagination['total_data'] ?> items</small>

        <nav aria-label="Page navigation" class="mb-0">
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item<?= $pagination['current_page'] == 1 ? ' disabled' : '' ?>">
                    <a class="page-link" href="<?= site_url(uri_string()) . '?' . set_url_param(['page' => $pagination['current_page'] - 1]) ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>

                <?php for ($i = 1; $i <= ($pagination['current_page'] >= 8 ? 1 : ($pagination['total_page'] > 8 ? 8 : $pagination['total_page'])); $i++): ?>
                    <li class="page-item<?= $i == $pagination['current_page'] ? ' active' : '' ?>">
                        <a class="page-link" href="<?= site_url(uri_string()) . '?' . set_url_param(['page' => $i]) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if($pagination['current_page'] >= 8 && $pagination['current_page'] <= $pagination['total_page'] - 8): ?>
                    <li class="page-item disabled">
                        <a class="page-link disabled" href="#">
                            ...
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="<?= site_url(uri_string()) . '?' . set_url_param(['page' => $pagination['current_page'] - 1]) ?>">
                            <?= $pagination['current_page'] - 1 ?>
                        </a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="<?= site_url(uri_string()) . '?' . set_url_param(['page' => $pagination['current_page']]) ?>">
                            <?= $pagination['current_page'] ?>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="<?= site_url(uri_string()) . '?' . set_url_param(['page' => $pagination['current_page'] + 1]) ?>">
                            <?= $pagination['current_page'] + 1 ?>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if($pagination['total_page'] >= 8): ?>
                    <?php if($pagination['current_page'] > ($pagination['total_page'] - 8)): ?>
                        <li class="page-item disabled">
                            <a class="page-link disabled" href="#">
                                ...
                            </a>
                        </li>
                        <?php for ($i = $pagination['total_page'] - 8; $i <= $pagination['total_page']; $i++): ?>
                            <li class="page-item<?= $pagination['current_page'] == $i ? ' active' : '' ?>">
                                <a class="page-link" href="<?= site_url(uri_string()) . '?' . set_url_param(['page' => $i]) ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <a class="page-link disabled" href="#">
                                ...
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="<?= site_url(uri_string()) . '?' . set_url_param(['page' => $pagination['total_page']]) ?>">
                                <?= $pagination['total_page'] ?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <li class="page-item<?= $pagination['current_page'] >= $pagination['total_page'] ? ' disabled' : '' ?>">
                    <a class="page-link" href="<?= site_url(uri_string()) . '?' . set_url_param(['page' => $pagination['current_page'] + 1]) ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
<?php endif; ?>