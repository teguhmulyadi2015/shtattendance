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
                <a href="<?= base_url('admin/add_master_department') ?>" class="btn btn-md btn-primary mb-2">Add New Dept</a>
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
                                    <th>Dept ID</th>
                                    <th>Dept Name</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($department as $d) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $d['dept_id'] ?></td>
                                        <td><?= $d['dept_name'] ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/edit_master_department/') . $d['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                            <a href="<?= base_url('admin/delete_department/') . $d['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure want to delete??')">Delete</a>
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