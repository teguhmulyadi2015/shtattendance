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
                <a href="<?= base_url('admin/master_department') ?>" class="btn btn-md btn-primary mb-2"><i class="fas fa-plust"></i>Back</a>
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
                        <form action="<?= base_url('admin/edit_master_department_process') ?>" method="post">
                            <input type="hidden" name="id" value="<?= $dept['id'] ?>">
                            <div class="form-group">
                                <label for="dept_code">Department Code</label>
                                <input type="text" name="dept_code" class="form-control <?= form_error('dept_code') ? 'is-invalid' : ''; ?>" placeholder="Enter Ip Address" aria-invalid="true" value="<?= $dept['dept_id'] ?>" readonly>
                                <span class="error invalid-feedback">
                                    <?= form_error('dept_code') ?>
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="dept_name">Department Name</label>
                                <input type="text" name="dept_name" class="form-control <?= form_error('dept_name') ? 'is-invalid' : ''; ?>" placeholder="Enter Machine Location" aria-invalid="true" value="<?= $dept['dept_name'] ?>">
                                <span class="error invalid-feedback">
                                    <?= form_error('dept_name') ?>
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