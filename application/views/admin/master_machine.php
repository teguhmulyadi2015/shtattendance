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
                <a href="<?= base_url('admin/add_master_machine') ?>" class="btn btn-md btn-primary mb-2">Add New Machine</a>
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
                                    <th>IP Address</th>
                                    <th>Machine Location</th>
                                    <th>status</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($machines as $m) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $m['ip_address'] ?></td>
                                        <td><?= $m['machine_loc'] ?></td>
                                        <td>
                                            <?php if ($m['is_active'] == 'Y') : ?>
                                                <span class="badge badge-success"><?= $m['is_active'] ?></span>
                                            <?php else : ?>
                                                <span class="badge badge-danger"><?= $m['is_active']  ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/edit_master_machine/') . $m['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                            <a href="<?= base_url('admin/delete_machine/') . $m['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure delete???')">Delete</a>
                                            <a href="<?= base_url('admin/ping_machine/') . $m['ip_address'] ?>" class="btn btn-sm btn-success">Ping</a>
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