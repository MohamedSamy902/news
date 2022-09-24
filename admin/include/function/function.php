<?php 


function checkRow($from, $id)
{
    global $con;
    $stmt = $con->prepare("SELECT * From $from WHERE ID = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row;
}





