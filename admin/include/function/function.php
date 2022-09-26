<?php 


function getRowById($from, $id)
{
    global $con;
    $stmt = $con->prepare("SELECT * From $from WHERE ID = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0) {
        return $row;
    }else {
        return [];
    }
}





