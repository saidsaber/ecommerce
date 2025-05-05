<?php
include("config.php");

function getCategory(){
    $query = "SELECT * FROM catigory";
    $res = mysqli_query($GLOBALS['conn'] , $query);
    $result = mysqli_fetch_assoc($res);
    // print_r($result);
    return $res;
}