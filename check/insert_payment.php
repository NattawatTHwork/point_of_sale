<?php
session_start();
date_default_timezone_set('Asia/Bangkok');
require_once '../include/connect.php';

if (isset($_SESSION['user_id'])) {
    $timestamp = new DateTime();
    $timestamp = $timestamp->format('Y-m-d H:i:s');
    $no_receipt = $_POST['no_receipt'];
    $method = $_POST['method'];
    // $name = $_POST['name'];
    // $type_id = $_POST['type_id'];
    // $description = $_POST['description'];
    // $price = $_POST['price'];
    // $discount = $_POST['discount'];
    // $user_id = $_SESSION['user_id'];

    $insert_payment = $connect->prepare("INSERT INTO payment(no_receipt, method, timestamp) VALUES(:no_receipt, :method, :timestamp)");
    $insert_payment->bindParam(":no_receipt", $no_receipt);
    $insert_payment->bindParam(":method", $method);
    $insert_payment->bindParam(":timestamp", $timestamp);
    $insert_payment->execute();
    if ($insert_payment) {
        echo 'success';
        exit();
    } else {
        echo 'fail';
        exit();
    }
} else {
    header("location: ../login.php");
}
