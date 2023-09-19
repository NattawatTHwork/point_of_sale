<?php
session_start();
require_once '../include/connect.php';

if (isset($_SESSION['user_id'])) {
    $product_id = $_POST['product_id'];

    $get_product = $connect->prepare("SELECT img_path FROM product WHERE product_id = '$product_id'");
    $get_product->execute();
    $row_product = $get_product->fetch(PDO::FETCH_ASSOC);

    $filename = '../img/'.$row_product['img_path'];
    if (file_exists($filename)) {
        if (unlink($filename)) {
            $delete_product = $connect->query("DELETE FROM product WHERE product_id = '$product_id'");
            if ($delete_product) {
                echo 'success';
                exit();
            } else {
                echo 'fail';
                exit();
            }
        }
    }
} else {
    header("location: ../login.php");
}
