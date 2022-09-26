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
    $stmt = $con->prepare("SELECT * From roles");
    $stmt->execute();
    $roles = $stmt->fetchAll();

?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>DataTables</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">DataTables</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    DataTable with minimal features & hover style
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Countrole</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($roles as $role) { ?>
                                            <tr>
                                                <td><?= $role['id'] ?></td>
                                                <td><?= $role['name'] ?></td>
                                                <td>
                                                    <a class="btn btn-primary" href="role.php?do=edit&id=<?= $role['id'] ?>">Edit</a>
                                                    <a class="btn btn-danger" href="role.php?do=delete&id=<?= $role['id'] ?>">Delete</a>
                                                </td>

                                            </tr>
                                        <?php } ?>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->


                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

<?php

} elseif ($do == 'cereat') {

    $stmt2 = $con->prepare('SELECT * FROM permissions');
    $stmt2->execute();
    $permissions = $stmt2->fetchAll();
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
                                    <div class="col-sm-6">
                                        <!-- checkbox -->

                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <?php foreach ($permissions as $permission) { ?>

                                                    <div class="col col-3">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="checkboxPrimary<?= $permission['id'] ?>" name="permission[]" value="<?= $permission['id'] ?>">
                                                            <label for="checkboxPrimary<?= $permission['id'] ?>"><?= $permission['name'] ?>
                                                            </label>
                                                        </div>
                                                    </div>

                                                <?php } ?>
                                            </div>

                                        </div>
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
        $errors = [];
        if (empty($name)) {
            $errors[] = 'Can By Not Empty';
        }

        if (strlen($name) < 2) {
            $errors[] = 'Value Must Be At Biger Than 2';
        }

        if (strlen($name) > 20) {
            $errors[] = 'Value Must Be At least Than 20';
        }



        $permissions = $_POST['permission'];
        if (empty($errors)) {

            $stmt = $con->prepare('INSERT INTO roles(name) VALUE(:zname)');
            $stmt->execute([
                'zname' => $name,
            ]);
            $lat_id = $con->lastInsertId();

            foreach ($permissions as $permission_id) {
                $stmt = $con->prepare('INSERT INTO permissions_has_role(role_id, permission_id) VALUE(:zrole, :zpermation)');
                $stmt->execute([
                    'zrole' => $lat_id,
                    'zpermation' => $permission_id,
                ]);
            }
        } else {
            foreach ($errors as $error) {
                echo '<h1>' . $error . '</h1>';
            }
        }

        header('Location: role.php?do=index');
        exit();
    }
} elseif ($do == 'edit') {
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;
    $role = getRowById('roles', $id);
    $count = COUNT($role);
    if ($count > 0) {
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
                                <form id="quickForm" method="POST" action="<?= $_SERVER['PHP_SELF'] ?>?do=update">
                                    <div class="card-body">
                                        <input type="hidden" value="<?= $_GET['id'] ?>" name="id">
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
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $name    = $_POST['name'];
        $id      = $_POST['id'];

        $errors = [];
        if (empty($name)) {
            $errors[] = 'Can By Not Empty';
        }

        if (strlen($name) < 2) {
            $errors[] = 'Value Must Be At Biger Than 2';
        }

        if (strlen($name) > 20) {
            $errors[] = 'Value Must Be At least Than 20';
        }

        $count = getRowById('roles', $id);
        if (COUNT($count) == 0) {
            $errors[] = 'This Is Id Is NOt Found';
        }
        if (empty($errors)) {
            $stmt = $con->prepare("UPDATE roles SET name = ? WHERE id = ?");
            $stmt->execute([$name, $id]);
        } else {
            foreach ($errors as $error) {
                echo '<h1>' . $error . '</h1>';
            }
        }
    }
    header('Location: role.php?do=index');
    exit();
} elseif ($do == 'delete') {
    $id = $_GET['id'];
    $stmt = $con->prepare("DELETE from roles WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: role.php?do=index');
    exit();
} else {
    header('Location: role.php?do=index');
    exit();
}



include($tpl . 'footer.php');
include($tpl . 'footerjs.php');

ob_end_flush();