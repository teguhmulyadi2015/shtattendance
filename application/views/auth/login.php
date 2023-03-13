<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SHT Attendance Pull System</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('vendor/assets/') ?>plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url('vendor/assets/') ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('vendor/assets/') ?>dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page" style="margin-top:-150px;">
    <img src="<?= base_url('vendor/assets/') ?>dist/img/sht-logo.png" alt="AdminLTE Logo" class="brand-image img-circle" style="opacity: .8; width: 150px; height: 150px;" >
    <a href="<?= base_url('auth') ?>" class="h2"><b>SHT Attendance Pull System</b></a>
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <?php if ($this->session->flashdata('message')) : ?>
                    <?= $this->session->flashdata('message') ?>
                <?php endif; ?>
                <form action="<?= base_url('auth/login_process') ?>" method="POST">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control <?= form_error('username') ? 'is-invalid' : ''; ?>" placeholder="Enter Username" aria-invalid="true" value="<?= set_value('username') ?>">
                        <span class="error invalid-feedback">
                            <?= form_error('username') ?>
                        </span>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control <?= form_error('password') ? 'is-invalid' : ''; ?>" placeholder="Enter Password" aria-invalid="true">
                        <span class="error invalid-feedback">
                            <?= form_error('password') ?>
                        </span>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url('vendor/assets/') ?>plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('vendor/assets/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('vendor/assets/') ?>dist/js/adminlte.min.js"></script>
</body>

</html>