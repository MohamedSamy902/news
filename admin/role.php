<?php

ob_start();
session_start();

include('init.php');

// index
// cerete
// Insert
// Edit
// Update
// Delete

$do = isset($_GET['do']) ? $_GET['do'] : 'index';

if ($do == 'index') {
} elseif ($do == 'cereat') {
?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Role</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Role</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Add New Role</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="quickForm" method="POST" action="<?= $_SERVER['PHP_SELF'] ?>?do=store">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Role Name</label>
                                        <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter Name Role">
                                    </div>

                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                    <!-- right column -->
                    <div class="col-md-6">

                    </div>
                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <?php
} elseif ($do == 'store') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];

        $stmt = $con->prepare('INSERT INTO roles(name) VALUE(:zname)');
        $stmt->exeute([
            'zname' => $name,
        ]);
    }
} elseif ($do == 'edit') {
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;
    $role = checkRow('roles', $id);
    $count = COUNT($role);

    if ($count != 0) {
    ?>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Role</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Role</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- jquery validation -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Add New Role</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" action="<?= $_SERVER['PHP_SELF'] ?>?do=store">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Role Name</label>
                                            <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter Name Role" value="<?= $role['name'] ?>">
                                        </div>

                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (left) -->
                        <!-- right column -->
                        <div class="col-md-6">

                        </div>
                        <!--/.col (right) -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>

<?php
    }
} elseif ($do == 'update') {
} elseif ($do == 'delete') {
} else {
}



include($tpl . 'footer.php');
include($tpl . 'footerjs.php');

ob_end_flush();