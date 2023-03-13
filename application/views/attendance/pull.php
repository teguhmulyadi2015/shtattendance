<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pull Attendance to DB</small></h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg">
                    <?php if ($this->session->flashdata('messagePingOK')) { ?>
                        <div class="alert alert-success"> <?= $this->session->flashdata('messagePingOK') ?> </div>
                    <?php } ?>
                    <?php if ($this->session->flashdata('messagePingNoOK')) { ?>
                        <div class="alert alert-warning"> <?= $this->session->flashdata('messagePingNoOK') ?> </div>
                    <?php } ?>
                    <?php if ($this->session->flashdata('messageConMachine')) { ?>
                        <div class="alert alert-warning"> <?= $this->session->flashdata('messageConMachine') ?> </div>
                    <?php } ?>
                    <?php if ($this->session->flashdata('messageNotInsertDB')) { ?>
                        <div class="alert alert-warning"> <?= $this->session->flashdata('messageNotInsertDB') ?> </div>
                    <?php } ?>
                    <?php if ($this->session->flashdata('messageInsertDB')) { ?>
                        <div class="alert alert-success"> <?= $this->session->flashdata('messageInsertDB') ?> </div>
                    <?php } ?>

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
                        <div class="card-body">
                            <form action="<?= base_url('attendance/pull_process') ?>" method="POST" target="_blank">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <!-- <label>Select Attendance</label> -->
                                        <select class="form-control" name="ip_address" required>
                                            <option value="">--Select--</option>
                                            <option value="ALL">ALL</option>
                                            <?php foreach ($machine as $m) : ?>
                                                <option value="<?= $m['ip_address'] ?>"><?= $m['ip_address'] . ' ' . $m['machine_loc'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-block bg-gradient-primary" onclick="showLoading()">Pull</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- <h5 class="card-title"></h5>                  -->
                                <!-- <p class="card-text">
                                    Some quick example text to build on the card title and make up the bulk of the card's
                                    content.
                                </p> -->
                                <!-- <a href="#" class="card-link">Card link</a> -->
                                <!-- <a href="#" class="card-link">Another link</a> -->
                            </form>
                        </div>
                    </div><!-- /.card -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg">
                    <div class="alert alert-danger alert-dismissible">
                        <b style="font-size: 20pt;">Latest Absent Data</b>
                        <a class="btn bg-gradient-info" href="<?= base_url('attendance/pull') ?>">Refresh</a>
                        <br>
                        <hr>

                        <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                        <?php $i = 1;
                        foreach ($latest as $l) : ?>
                            <?php
                            $date = date_create_from_format('Y-m-d H:i:s', $l['max_date']);
                            $formattedDate = date_format($date, 'm/d/Y H:i:s');
                            ?>
                            <span>
                                <?= $i++ . '. ' . $formattedDate . '#' . $l['ip_machine'] . '#' . $l['machine_loc'] ?><br>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->