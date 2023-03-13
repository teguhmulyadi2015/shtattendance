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
                <a href="<?= base_url('admin/master_users') ?>" class="btn btn-md btn-primary mb-2">Back</a>
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
                        <form action="<?= base_url('admin/edit_master_users_process') ?>" method="post">
                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control <?= form_error('username') ? 'is-invalid' : ''; ?>" placeholder="Enter Username" aria-invalid="true" value="<?= $user['username'] ?>" readonly>
                                <span class="error invalid-feedback">
                                    <?= form_error('username') ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="role_name">Role</label>
                                <select class="form-control <?= form_error('role_name') ? 'is-invalid' : ''; ?>" name="role_name">
                                    <option value="">--Select Role--</option>
                                    <option value="guest" <?= ($user['role_name'] == 'guest') ? 'selected' : ''; ?>>Guest</option>
                                    <option value="admin" <?= ($user['role_name'] == 'admin') ? 'selected' : ''; ?>>Administrator</option>
                                </select>
                                <span class="error invalid-feedback">
                                    <?= form_error('role_name') ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="empno">Empno</label>
                                <input type="number" name="empno" class="form-control <?= form_error('empno') ? 'is-invalid' : ''; ?>" placeholder="Enter Emp.No" aria-invalid="true" value="<?= $user['empno'] ?>">
                                <span class="error invalid-feedback">
                                    <?= form_error('empno') ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="fullname">Fullname</label>
                                <input type="text" name="fullname" class="form-control <?= form_error('fullname') ? 'is-invalid' : ''; ?>" placeholder="Enter Fullname" aria-invalid="true" value="<?= $user['full_name'] ?>">
                                <span class="error invalid-feedback">
                                    <?= form_error('fullname') ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="dept_id">Department</label>
                                <select class="form-control <?= form_error('dept_id') ? 'is-invalid' : ''; ?>" name="dept_id">
                                    <option value="">--Select Department--</option>
                                    <?php foreach ($dept as $d) : ?>
                                        <option value="<?= $d['dept_id'] ?>" <?= ($d['dept_id'] == $user['dept_id']) ? 'selected' : ''; ?>><?= $d['dept_name'] ?></option>
                                    <?php endforeach; ?>

                                </select>
                                <span class="error invalid-feedback">
                                    <?= form_error('dept_id') ?>
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="is_active">Is Active</label>
                                <select class="form-control <?= form_error('is_active') ? 'is-invalid' : ''; ?>" name="is_active">
                                    <option value="">--Select--</option>
                                    <option value="Y" <?= ($user['is_active'] == 'Y') ? 'selected' : ''; ?>>Y</option>
                                    <option value="N" <?= ($user['is_active'] == 'N') ? 'selected' : ''; ?>>N</option>
                                </select>
                                <span class="error invalid-feedback">
                                    <?= form_error('dept_id') ?>
                                </span>
                            </div>

                            <div class="row">
                                <!-- /.col -->
                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-block">Update</button>
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