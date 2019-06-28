<div class="modal fade" id="modal-filter" aria-labelledby="modalFilter">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= site_url(uri_string()) ?>" id="form-filter">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFilter">Filter <?= $title ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="search">Search</label>
                        <input type="text" class="form-control" name="search" id="search"
                               value="<?= get_url_param('search') ?>" placeholder="Search a data">
                        <?= form_error('search'); ?>
                    </div>
                    <div class="row">
                        <div class="col-8 col-sm-6">
                            <div class="form-group">
                                <label for="user_type">User Type</label>
                                <select class="custom-select" name="user_type" id="user_type">
                                    <option value=""<?= set_select('user_type', 'created_at', get_url_param('user_type') == 'created_at') ?>>
                                        ALL
                                    </option>
                                    <option value="INTERNAL"<?= set_select('user_type', 'INTERNAL', get_url_param('user_type') == 'INTERNAL') ?>>
                                        INTERNAL
                                    </option>
                                    <option value="EXTERNAL"<?= set_select('user_type', 'EXTERNAL', get_url_param('user_type') == 'EXTERNAL') ?>>
                                        EXTERNAL
                                    </option>
                                </select>
                                <?= form_error('user_type'); ?>
                            </div>
                        </div>
                        <div class="col-4 col-sm-6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="custom-select" name="status" id="status">
                                    <option value=""
                                        <?= set_select('status', 'ALL STATUS', get_url_param('status') == 'ALL STATUS') ?>>
                                        ALL STATUS
                                    </option>
                                    <option value="PENDING"
                                        <?= set_select('status', 'PENDING', get_url_param('status') == 'PENDING') ?>>
                                        PENDING
                                    </option>
                                    <option value="ACTIVATED"
                                        <?= set_select('status', 'ACTIVATED', get_url_param('status') == 'ACTIVATED') ?>>
                                        ACTIVATED
                                    </option>
                                    <option value="SUSPENDED"
                                        <?= set_select('status', 'SUSPENDED', get_url_param('status') == 'SUSPENDED') ?>>
                                        SUSPENDED
                                    </option>
                                </select>
                                <?= form_error('status'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8 col-sm-6">
                            <div class="form-group">
                                <label for="sort_by">Sort By</label>
                                <select class="custom-select" name="sort_by" id="sort_by" required>
                                    <option value="created_at"<?= set_select('sort_by', 'created_at', get_url_param('sort_by') == 'created_at') ?>>
                                        CREATED AT
                                    </option>
                                    <option value="name"<?= set_select('sort_by', 'name', get_url_param('sort_by') == 'name') ?>>
                                        NAME
                                    </option>
                                    <option value="username"<?= set_select('sort_by', 'username', get_url_param('sort_by') == 'username') ?>>
                                        USERNAME
                                    </option>
                                    <option value="email"<?= set_select('sort_by', 'email', get_url_param('sort_by') == 'email') ?>>
                                        EMAIL
                                    </option>
                                    <option value="status"<?= set_select('sort_by', 'status', get_url_param('sort_by') == 'status') ?>>
                                        STATUS
                                    </option>
                                </select>
                                <?= form_error('sort_by'); ?>
                            </div>
                        </div>
                        <div class="col-4 col-sm-6">
                            <div class="form-group">
                                <label for="order_method">Order</label>
                                <select class="custom-select" name="order_method" id="order_method" required>
                                    <option value="desc"
                                        <?= set_select('order_method', 'desc', get_url_param('order_method') == 'desc') ?>>
                                        DESCENDING
                                    </option>
                                    <option value="asc"
                                        <?= set_select('order_method', 'asc', get_url_param('order_method') == 'asc') ?>>
                                        ASCENDING
                                    </option>
                                </select>
                                <?= form_error('order_method'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="<?= site_url('manage/user') ?>" class="btn btn-sm btn-light">
                        RESET
                    </a>
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">
                        CLOSE
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        APPLY FILTER
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>