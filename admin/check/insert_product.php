<?php
session_start();
require_once '../../include/connect.php';

if (isset($_SESSION['admin_id'])) {
    $name = $_POST['name'];
    $type_id = $_POST['type_id'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    if (!empty($_FILES['preimg']['name'])) {
        $image = $_FILES['preimg']['name'];
        $newname = uniqid(10) . basename($image);
        $target = "../../img/" . $newname;
        move_uploaded_file($_FILES['preimg']['tmp_name'], $target);
        // $conn->query("INSERT INTO contractor_pic (contractor_info_id, contractor_pic_sort, contractor_pic_path)
        // VALUE('" . $contractor_id . "', '1', '" . $newname . "')");
    }

    $insert_product = $connect->prepare("INSERT INTO product_original(name, type_id, description, price, img_path) VALUES(:name, :type_id, :description, :price, :newname)");
    $insert_product->bindParam(":name", $name);
    $insert_product->bindParam(":type_id", $type_id);
    $insert_product->bindParam(":description", $description);
    $insert_product->bindParam(":price", $price);
    $insert_product->bindParam(":newname", $newname);
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
