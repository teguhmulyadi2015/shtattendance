<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Change Password</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg">
                    <?php if ($this->session->flashdata('message')) : ?>
                        <?= $this->session->flashdata('message') ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg">
                    <div class="card card-primary card-outline">
                        <form action="<?= base_url('attendance/change_password_process') ?>" method="POST">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" name="username" value="<?= $username['username'] ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="old_password">Old Password</label>
                                            <input type="password" class="form-control  <?= form_error('old_password') ? 'is-invalid' : ''; ?>" placeholder="Enter old password" name="old_password">
                                            <span class="error invalid-feedback">
                                                <?= form_error('old_password') ?>
                                            </span>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="new_password1">New Password</label>
                                            <input type="password" class="form-control <?= form_error('new_password1') ? 'is-invalid' : ''; ?>" name="new_password1" placeholder="Enter new password">
                                            <span class="error invalid-feedback">
                                                <?= form_error('new_password1') ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="new_password2">Retype New Password</label>
                                            <input type="password" class="form-control <?= form_error('new_password2') ? 'is-invalid' : ''; ?>" name="new_password2" placeholder="Retype new password">
                                            <span class="error invalid-feedback">
                                                <?= form_error('new_password2') ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <button type="submit" class="btn btn-block bg-gradient-primary">Submit</button>
                                    </div>
                                    <div class="col">
                                        <button type="reset" class="btn btn-block bg-gradient-secondary">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->