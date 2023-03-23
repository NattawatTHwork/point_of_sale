<?php
session_start();
require_once '../include/connect.php';

if (isset($_SESSION['user_id'])) {
    $name = $_POST['name'];
    $type_id = $_POST['type_id'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $product_id = $_POST['product_id'];

    $edit_product = $connect->query("UPDATE product SET name = '$name', type_id = '$type_id', description = '$description', price = '$price', discount = '$discount' WHERE product_id = '$product_id'");
    if ($edit_product) {
        echo 'success';
        exit();
    } else {
        echo 'fail';
        exit();
    }
} else {
    header("location: ../login.php");
}
