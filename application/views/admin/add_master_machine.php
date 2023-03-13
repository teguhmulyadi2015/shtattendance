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
                <a href="<?= base_url('admin/master_machine') ?>" class="btn btn-md btn-primary mb-2"><i class="fas fa-plust"></i>Back</a>
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
                        <form action="<?= base_url('admin/add_master_machine_process') ?>" method="post">
                            <div class="form-group">
                                <label for="ip_address">IP Address</label>
                                <input type="text" name="ip_address" class="form-control <?= form_error('ip_address') ? 'is-invalid' : ''; ?>" placeholder="Enter Ip Address" aria-invalid="true" value="<?= set_value('ip_address') ?>">
                                <span class="error invalid-feedback">
                                    <?= form_error('ip_address') ?>
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="machine_loc">Machine Location</label>
                                <input type="text" name="machine_loc" class="form-control <?= form_error('machine_loc') ? 'is-invalid' : ''; ?>" placeholder="Enter Machine Location" aria-invalid="true" value="<?= set_value('machine_loc') ?>">
                                <span class="error invalid-feedback">
                                    <?= form_error('machine_loc') ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="is_active">Is Active</label>
                                <select class="form-control <?= form_error('is_active') ? 'is-invalid' : ''; ?>" name="is_active">
                                    <option value="Y" selected>Y</option>
                                    <option value="N">N</option>
                                </select>
                                <span class="error invalid-feedback">
                                    <?= form_error('is_active') ?>
                                </span>
                            </div>



                            <div class="row">
                                <!-- /.col -->
                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                </div>
                                <div class="col">
                                    <button type="reset" class="btn btn-secondary btn-block">Reset</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->