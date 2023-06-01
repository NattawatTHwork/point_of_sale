<?php
session_start();
date_default_timezone_set('Asia/Bangkok');
require_once '../include/connect.php';

if (isset($_SESSION['user_id'])) {
    $timestamp = new DateTime();
    $timestamp = $timestamp->format('Y-m-d H:i:s');
    $method = $_POST['method'];
    // $name = $_POST['name'];
    // $type_id = $_POST['type_id'];
    // $description = $_POST['description'];
    // $price = $_POST['price'];
    // $discount = $_POST['discount'];
    // $user_id = $_SESSION['user_id'];
    $count = $_POST['count'];
    $no_receipt = date("YmdHis");
    for ($i = 1; $i <= $count; $i++) {
        $quantity = $_POST['quantity' . $i];
        if ($quantity == 0) {
            continue;
        } else {
            $product_id = $_POST['product_id' . $i];
            $net_price = $_POST['price' . $i];
            $insert_record = $connect->prepare("INSERT INTO record(no_receipt, product_id, quantity, net_price) VALUES(:no_receipt, :product_id, :quantity, :net_price)");
            $insert_record->bindParam(":no_receipt", $no_receipt);
            $insert_record->bindParam(":product_id", $product_id);
            $insert_record->bindParam(":quantity", $quantity);
            $insert_record->bindParam(":net_price", $net_price);
            $insert_record->execute();
        }
    }

    $insert_payment = $connect->prepare("INSERT INTO payment(no_receipt, method, timestamp) VALUES(:no_receipt, :method, :timestamp)");
    $insert_payment->bindParam(":no_receipt", $no_receipt);
    $insert_payment->bindParam(":method", $method);
    $insert_payment->bindParam(":timestamp", $timestamp);
    $insert_payment->execute();
    if ($insert_payment && $insert_record) {
        echo $no_receipt;
        exit();
    } else {
        echo 'fail';
        exit();
    }
} else {
    header("location: ../login.php");
}
