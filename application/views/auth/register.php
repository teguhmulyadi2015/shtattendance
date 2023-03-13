<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Registration Page (v2)</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('vendor/assets/') ?>plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url('vendor/assets/') ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('vendor/assets/') ?>dist/css/adminlte.min.css">
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>SHT</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Register a new membership</p>

                <form action="<?= base_url('auth/register_process') ?>" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control <?= form_error('username') ? 'is-invalid' : ''; ?>" placeholder="Enter Username" aria-invalid="true" value="<?= set_value('username') ?>">
                        <span class="error invalid-feedback">
                            <?= form_error('username') ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="role_name">Role</label>
                        <select class="form-control <?= form_error('role_name') ? 'is-invalid' : ''; ?>" name="role_name">
                            <option value="">--Select Role--</option>
                            <option value="guest" selected>Guest</option>
                            <option value="admin">Administrator</option>
                        </select>
                        <span class="error invalid-feedback">
                            <?= form_error('role_name') ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="empno">Empno</label>
                        <input type="number" name="empno" class="form-control <?= form_error('empno') ? 'is-invalid' : ''; ?>" placeholder="Enter Emp.No" aria-invalid="true" value="<?= set_value('empno') ?>">
                        <span class="error invalid-feedback">
                            <?= form_error('empno') ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="fullname">Fullname</label>
                        <input type="text" name="fullname" class="form-control <?= form_error('fullname') ? 'is-invalid' : ''; ?>" placeholder="Enter Fullname" aria-invalid="true" value="<?= set_value('fullname') ?>">
                        <span class="error invalid-feedback">
                            <?= form_error('fullname') ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="dept_id">Department</label>
                        <select class="form-control <?= form_error('dept_id') ? 'is-invalid' : ''; ?>" name="dept_id">
                            <option value="">--Select Department--</option>
                            <option value="700" <?= set_select('dept_id', '700') ?>>IT</option>
                            <option value="600" <?= set_select('dept_id', '600') ?>>ADM</option>
                        </select>
                        <span class="error invalid-feedback">
                            <?= form_error('dept_id') ?>
                        </span>
                    </div>

                    <div class="row">
                        <!-- /.col -->
                        <div class="col">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="<?= base_url('vendor/assets/') ?>plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('vendor/assets/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('vendor/assets/') ?>dist/js/adminlte.min.js"></script>
</body>

</html>