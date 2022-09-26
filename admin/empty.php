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
} elseif ($do == 'store') {
} elseif ($do == 'edit') {
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;
    $role = getRowById('roles', $id);
    $count = COUNT($role);
} elseif ($do == 'update') {
} elseif ($do == 'delete') {
} else {
}



include($tpl . 'footer.php');
include($tpl . 'footerjs.php');

ob_end_flush();
