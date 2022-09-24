<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'on');

include ('connect.php');

$tpl = 'include/templates/';
$fun = 'include/function/';
$css = 'layout/dist/css/';
$js  = 'layout/dist/js/';
$img  = 'layout/dist/img/';
$plugins = 'layout/plugins/';

include($tpl . 'header.php');
include($tpl . 'navbar.php');
include($tpl . 'sidebar.php');
include($fun . 'function.php');