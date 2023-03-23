<?php
session_start();
require_once '../include/connect.php';

if (isset($_SESSION['user_id'])) {
    $product_id = $_POST['product_id'];

    $get_product = $connect->prepare("SELECT * FROM product WHERE product_id = '$product_id'");
    $get_product->execute();
    $row_product = $get_product->fetch(PDO::FETCH_ASSOC);
    if ($row_product) {
        echo json_encode($row_product);
        exit();
    } else {
        echo 'fail';
        exit();
    }
} else {
    header("location: ../login.php");
}
