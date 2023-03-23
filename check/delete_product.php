<?php
session_start();
require_once '../include/connect.php';

if (isset($_SESSION['user_id'])) {
    $product_id = $_POST['product_id'];

    $delete_type = $connect->query("DELETE FROM product WHERE product_id = '$product_id'");
    if ($delete_type) {
        echo 'success';
        exit();
    } else {
        echo 'fail';
        exit();
    }
} else {
    header("location: ../login.php");
}
