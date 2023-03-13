<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Download Attendance <small>.txt</small></h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg">
                    <div class="card card-primary card-outline">
                        <form action="<?= base_url('attendance/download_process') ?>" method="POST">
                            <div class="card-body">
                                <div class="row">
                                    <!-- <div class="col-lg">
                                        <select class="form-control" name="ip_address" required>
                                            <option value="">--Select--</option>
                                            <option value="ALL" selected>ALL</option>
                                            <?php foreach ($machine as $m) : ?>
                                                <option value="<?= $m['ip_address'] ?>"><?= $m['ip_address'] . ' ' . $m['machine_loc'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div> -->
                                    <div class="col-lg">
                                        <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime" name="date_att1" required placeholder="From">
                                            <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="input-group date" id="reservationdatetime2" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime2" name="date_att2" required placeholder="To">
                                            <div class="input-group-append" data-target="#reservationdatetime2" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-block bg-gradient-primary">Download</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->