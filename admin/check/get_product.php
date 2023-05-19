<?php
session_start();
require_once '../../include/connect.php';

if (isset($_SESSION['admin_id'])) {
    $user_id = $_POST['user_id'];

    $get_user = $connect->prepare("SELECT * FROM product WHERE user_id = '$user_id'");
    $get_user->execute();
    $row_user = $get_user->fetchAll(PDO::FETCH_ASSOC);
    if ($row_user) {
        echo json_encode($row_user);
        exit();
    } else {
        echo json_encode($row_user);
        exit();
    }
} else {
    header("location: ../login.php");
}
