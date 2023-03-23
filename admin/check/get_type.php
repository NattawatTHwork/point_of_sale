<?php
session_start();
require_once '../../include/connect.php';

if (isset($_SESSION['admin_id'])) {
    $type_id = $_POST['type_id'];

    $get_type = $connect->prepare("SELECT * FROM type WHERE type_id = '$type_id'");
    $get_type->execute();
    $row_type = $get_type->fetch(PDO::FETCH_ASSOC);
    if ($row_type) {
        echo json_encode($row_type);
        exit();
    } else {
        echo 'fail';
        exit();
    }
} else {
    header("location: ../login.php");
}
