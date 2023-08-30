<?php
session_start();
require_once '../../include/connect.php';

if (isset($_SESSION['admin_id'])) {
    $name = $_POST['name'];
    $type_id = $_POST['type_id'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $product_original_id = $_POST['product_original_id'];
    $newname = $_POST['img_path'];

    if (!empty($_FILES['preimg1']['name'])) {
        $image = $_FILES['preimg1']['name'];
        $newname = uniqid(10) . basename($image);
        $target = "../../img/" . $newname;
        move_uploaded_file($_FILES['preimg1']['tmp_name'], $target);
        // $conn->query("INSERT INTO contractor_pic (contractor_info_id, contractor_pic_sort, contractor_pic_path)
        // VALUE('" . $contractor_id . "', '1', '" . $newname . "')");
    }


    $edit_product = $connect->query("UPDATE product_original SET name = '$name', type_id = '$type_id', description = '$description', price = '$price', img_path = '$newname' WHERE product_original_id = '$product_original_id'");
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
