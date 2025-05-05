<?php
session_start();
include('../core/CategoryName.php');
// include('../core/main.php');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $categoryName = $_POST['CategoryName'];
    createCategory($categoryName);
    print_r($_SESSION['error']);
    // echo error('catigory');
}