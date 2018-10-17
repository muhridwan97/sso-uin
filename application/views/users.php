<div>
    <div class="d-flex justify-content-between align-items-center mb-3" id="warehouse">
        <h4>Warehouse Users</h4>
        <a href="<?= site_url('user?export=warehouse') ?>" class="btn btn-success">Export</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col" class="text-center">#</th>
            <th scope="col">Name</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Roles</th>
        </tr>
        </thead>
        <tbody>
        <?php $no = 1; ?>
        <?php foreach ($userWarehouse as $user): ?>
            <tr>
                <th scope="row" class="text-center"><?= $no++ ?></th>
                <td><?= $user['name'] ?></td>
                <td><?= $user['username'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= str_replace(',', '<br>', $user['roles']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <hr>

    <div class="d-flex justify-content-between align-items-center mb-3 mt-5" id="purchasing">
        <h4>Purchasing Users</h4>
        <a href="<?= site_url('user?export=purchasing') ?>" class="btn btn-success">Export</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col" class="text-center">#</th>
            <th scope="col">Name</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Roles</th>
        </tr>
        </thead>
        <tbody>
        <?php $no = 1; ?>
        <?php foreach ($userPurchasing as $user): ?>
            <tr>
                <th scope="row" class="text-center"><?= $no++ ?></th>
                <td><?= $user['name'] ?></td>
                <td><?= $user['username'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= str_replace(',', '<br>', $user['roles']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <hr>

    <div class="d-flex justify-content-between align-items-center mb-3 mt-5" id="absent">
        <h4>Absent Users</h4>
        <a href="<?= site_url('user?export=absent') ?>" class="btn btn-success">Export</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col" class="text-center">#</th>
            <th scope="col">Name</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Roles</th>
        </tr>
        </thead>
        <tbody>
        <?php $no = 1; ?>
        <?php foreach ($userAbsent as $user): ?>
            <tr>
                <th scope="row" class="text-center"><?= $no++ ?></th>
                <td><?= $user['name'] ?></td>
                <td><?= $user['username'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['role'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <hr>

    <div class="d-flex justify-content-between align-items-center mb-3 mt-5" id="hr">
        <h4>HR Users</h4>
        <a href="<?= site_url('user?export=hr') ?>" class="btn btn-success">Export</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col" class="text-center">#</th>
            <th scope="col">Name</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Roles</th>
        </tr>
        </thead>
        <tbody>
        <?php $no = 1; ?>
        <?php foreach ($userHR as $user): ?>
            <tr>
                <th scope="row" class="text-center"><?= $no++ ?></th>
                <td><?= $user['name'] ?></td>
                <td><?= $user['username'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= str_replace(',', '<br>', $user['roles']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <hr>

    <div class="d-flex justify-content-between align-items-center mb-3 mt-5" id="crm">
        <h4>CRM Users</h4>
        <a href="<?= site_url('user?export=crm') ?>" class="btn btn-success">Export</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col" class="text-center">#</th>
            <th scope="col">Name</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Roles</th>
        </tr>
        </thead>
        <tbody>
        <?php $no = 1; ?>
        <?php foreach ($userCRM as $user): ?>
            <tr>
                <th scope="row" class="text-center"><?= $no++ ?></th>
                <td><?= $user['name'] ?></td>
                <td><?= $user['username'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= str_replace(',', '<br>', $user['roles']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <hr>

    <div class="d-flex justify-content-between align-items-center mb-3 mt-5" id="vms">
        <h4>VMS (TCIM) Users</h4>
        <a href="<?= site_url('user?export=vms') ?>" class="btn btn-success">Export</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col" class="text-center">#</th>
            <th scope="col">Name</th>
            <th scope="col">Username</th>
            <th scope="col">Roles</th>
        </tr>
        </thead>
        <tbody>
        <?php $no = 1; ?>
        <?php foreach ($userVMS as $user): ?>
            <tr>
                <th scope="row" class="text-center"><?= $no++ ?></th>
                <td><?= $user['name'] ?></td>
                <td><?= $user['username'] ?></td>
                <td><?= $user['role'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <hr>

    <div class="d-flex justify-content-between align-items-center mb-3 mt-5" id="ticket">
        <h4>Ticket Users</h4>
        <a href="<?= site_url('user?export=ticket') ?>" class="btn btn-success">Export</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col" class="text-center">#</th>
            <th scope="col">Name</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Roles</th>
        </tr>
        </thead>
        <tbody>
        <?php $no = 1; ?>
        <?php foreach ($userTicket as $user): ?>
            <tr>
                <th scope="row" class="text-center"><?= $no++ ?></th>
                <td><?= $user['name'] ?></td>
                <td><?= $user['username'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['role'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <hr>

    <div class="d-flex justify-content-between align-items-center mb-3 mt-5" id="training">
        <h4>Training Users</h4>
        <a href="<?= site_url('user?export=training') ?>" class="btn btn-success">Export</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col" class="text-center">#</th>
            <th scope="col">Name</th>
            <th scope="col">Username</th>
            <th scope="col">Roles</th>
        </tr>
        </thead>
        <tbody>
        <?php $no = 1; ?>
        <?php foreach ($userTraining as $user): ?>
            <tr>
                <th scope="row" class="text-center"><?= $no++ ?></th>
                <td><?= $user['name'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['role'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <hr>

    <div class="d-flex justify-content-between align-items-center mb-3 mt-5" id="evaluation">
        <h4>Evaluation Users</h4>
        <a href="<?= site_url('user?export=evaluation') ?>" class="btn btn-success">Export</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col" class="text-center">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Roles</th>
        </tr>
        </thead>
        <tbody>
        <?php $no = 1; ?>
        <?php foreach ($userEvaluation as $user): ?>
            <tr>
                <th scope="row" class="text-center"><?= $no++ ?></th>
                <td><?= $user['name'] ?></td>
                <td><?= $user['username'] ?></td>
                <td><?= $user['role'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>