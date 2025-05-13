<?php
session_start();
include('../core/config.php');
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}else{
    $user = $_SESSION['user'];
}
if (isset($_GET['favorite'])) {
    $product = $_GET['favorite'];
    $query = "INSERT INTO favorite (productId, userId) value ('$product', '$user')";
    mysqli_query($conn, $query);
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}
if (isset($_GET['unfavorite'])) {
    $product = $_GET['unfavorite'];
    $query = "DELETE FROM favorite where favId = '$product'";
    mysqli_query($conn, $query);
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}
