<?php
session_start();
include('../core/shipment.php');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $Name = $_POST['Name'];
    $Email = $_POST['Email'];
    $Address = $_POST['Address'];
    $Phone = $_POST['Phone'];
    $Notes = $_POST['Notes'];

    $shipMentData = [
        'Name' => $Name,
        'Email' => $Email,
        'Address' => $Address,
        'Phone' => $Phone,
        'Notes' => $Notes,
    ];
    shipMent($shipMentData);
}