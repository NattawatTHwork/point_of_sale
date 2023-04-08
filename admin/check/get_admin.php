<?php
session_start();
require_once '../../include/connect.php';

if (isset($_SESSION['admin_id'])) {
    $admin_id = $_POST['admin_id'];

    $get_admin = $connect->prepare("SELECT * FROM admin WHERE admin_id = '$admin_id'");
    $get_admin->execute();
    $row_admin = $get_admin->fetch(PDO::FETCH_ASSOC);
    if ($row_admin) {
        echo json_encode($row_admin);
        exit();
    } else {
        echo 'fail';
        exit();
    }
} else {
    header("location: ../login.php");
}
