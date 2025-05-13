<?php
session_start();
include("../core/size.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['id'];
    $size = $_POST['size'];

    $sizeData = [
        'id'=> $id,
        'size'=> $size,
    ];
    setSize($sizeData) ;
}