<?php
session_start();
include("../core/count.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['id'];
    $color = $_POST['color'];
    $size = $_POST['size'];
    $count = $_POST['count'];

    $countData = [
        'id'=> $id,
        'color'=> $color,
        'size'=> $size,
        'count'=> $count
    ];
    // echo '<pre>';
    // print_r($countData);
    setCount($countData) ;
}