<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm">
                    <h1 class="m-0"> System Pulling Data Attendance Machine - SHT</h1>
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
                        <div class="card-body">
                            <h5 class="card-title">SOP System Pulling Data Attendance Machine - SHT </h5>
                            <br>
                            <ol>
                                <li type="1">
                                    <a href="<?= base_url('attendance/pull') ?>">Pull</a>
                                    <ul>
                                        <li>
                                            First Pulling data from Machine, wait until process finish
                                        </li>
                                    </ul>
                                </li>
                                <br>
                                <li type="1">
                                    <a href="<?= base_url('attendance/download') ?>">Download</a>
                                    <ul>
                                        <li>
                                            After Pulling data from Machine then Download Data by date range
                                        </li>
                                    </ul>
                                </li>
                                <br>
                                <!-- <li type="1">
                                    <a href="<?= base_url('attendance/clear') ?>" target="_blank">Closing</a>
                                    <ul>
                                        <li>
                                            After Closing Attendance, please Also Closing SHT Attendance
                                        </li>
                                    </ul>
                                </li> -->
                                <br>
                            </ol>
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