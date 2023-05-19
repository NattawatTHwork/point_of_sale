<?php
session_start();
require_once '../include/connect.php';

if (isset($_SESSION['user_id'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $id_number = $_POST['id_number'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $store = $_POST['store'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];
    $newname = $_POST['checkpreimg'];

    if (!empty($_FILES['preimg']['name'])) {
        $image = $_FILES['preimg']['name'];
        $newname = uniqid(10) . basename($image);
        $target = "../img/" . $newname;
        move_uploaded_file($_FILES['preimg']['tmp_name'], $target);
        // $conn->query("INSERT INTO contractor_pic (contractor_info_id, contractor_pic_sort, contractor_pic_path)
        // VALUE('" . $contractor_id . "', '1', '" . $newname . "')");
    }

    $update_information = $connect->query("UPDATE user SET firstname = '$firstname', lastname = '$lastname', id_number = '$id_number', phone = '$phone', address = '$address', store = '$store', description = '$description', img_path = '$newname' WHERE user_id = '$user_id'");
    if ($update_information) {
        echo 'success';
        exit();
    } else {
        echo 'fail';
        exit();
    }
} else {
    header("location: ../login.php");
}
