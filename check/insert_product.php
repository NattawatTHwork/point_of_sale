<?php
session_start();
require_once '../include/connect.php';

if (isset($_SESSION['user_id'])) {
    $name = $_POST['name'];
    $type_id = $_POST['type_id'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $user_id = $_SESSION['user_id'];

    $insert_product = $connect->prepare("INSERT INTO product(name, type_id, user_id, description, price, discount) VALUES(:name, :type_id, :user_id, :description, :price, :discount)");
    $insert_product->bindParam(":name", $name);
    $insert_product->bindParam(":type_id", $type_id);
    $insert_product->bindParam(":user_id", $user_id);
    $insert_product->bindParam(":description", $description);
    $insert_product->bindParam(":price", $price);
    $insert_product->bindParam(":discount", $discount);
    $insert_product->execute();
    if ($insert_product) {
        echo 'success';
        exit();
    } else {
        echo 'fail';
        exit();
    }
} else {
    header("location: ../login.php");
}
