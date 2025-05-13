<?php
session_start();
include("../core/color.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['id'];
    $color = $_POST['color'];
    $colorHexCod = $_POST['colorHexCod'];

    $colorData = [
        'id'=> $id,
        'color'=> $color,
        'colorHexCod'=> $colorHexCod
    ];
    setColor($colorData) ;
}