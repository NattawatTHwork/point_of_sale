<?php
session_start();
require_once '../../include/connect.php';

if (isset($_SESSION['admin_id'])) {
    $type = $_POST['type'];

    $insert_type = $connect->prepare("INSERT INTO type(type) VALUES(:type)");
    $insert_type->bindParam(":type", $type);
    $insert_type->execute();
    if ($insert_type) {
        echo 'success';
        exit();
    } else {
        echo 'fail';
        exit();
    }
} else {
    header("location: ../login.php");
}
