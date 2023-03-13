<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $title ?></h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row ">
            <div class="col">
                <a href="<?= base_url('admin/add_master_users') ?>" class="btn btn-md btn-primary mb-2">Add New User</a>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <?php if ($this->session->flashdata('message')) : ?>
                    <?= $this->session->flashdata('message') ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- <div class="card-header">
                        <h3 class="card-title">DataTable with minimal features &amp; hover style</h3>
                    </div> -->
                    <!-- /.card-header -->
                    <div class="card-body">

                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Empno</th>
                                    <th>Full Name</th>
                                    <th>Status</th>
                                    <th>Department</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($users as $u) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $u['username'] ?></td>
                                        <td>
                                            <?php if ($u['role_name'] == 'admin') : ?>
                                                <span class="badge badge-primary"><?= $u['role_name'] ?></span>
                                            <?php else : ?>
                                                <span class="badge badge-warning"><?= $u['role_name']  ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $u['empno'] ?></td>
                                        <td><?= $u['full_name'] ?></td>
                                        <td>
                                            <?php if ($u['is_active'] == 'Y') : ?>
                                                <span class="badge badge-success"><?= $u['is_active'] ?></span>
                                            <?php else : ?>
                                                <span class="badge badge-danger"><?= $u['is_active']  ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $u['dept_name'] ?></td>
                                        <td>
                                            <?php if ($u['username'] == 'admin') : ?>
                                                <span class="text-danger">no delete no edit</span>
                                            <?php else : ?>
                                                <a href="<?= base_url('admin/edit_master_users/') . $u['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                                <a href="<?= base_url('admin/reset_password/') . $u['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are your sure want to reset???')">Reset Password</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <!-- <tfoot>
                        <tr>
                            <th>Rendering engine</th>
                            <th>Browser</th>
                            <th>Platform(s)</th>
                            <th>Engine version</th>
                            <th>CSS grade</th>
                        </tr>
                    </tfoot> -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->