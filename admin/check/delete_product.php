<?php
session_start();
require_once '../../include/connect.php';

if (isset($_SESSION['admin_id'])) {
    $product_original_id = $_POST['product_original_id'];

    $delete_product_original = $connect->query("DELETE FROM product_original WHERE product_original_id = '$product_original_id'");
    if ($delete_product_original) {
        echo 'success';
        exit();
    } else {
        echo 'fail';
        exit();
    }
} else {
    header("location: ../login.php");
}
