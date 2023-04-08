<?php
session_start();
require_once '../../include/connect.php';

if (isset($_SESSION['admin_id'])) {
    $status = $_POST['status'];
    $admin_id = $_POST['admin_id'];

    $edit_admin = $connect->query("UPDATE admin SET status = '$status' WHERE admin_id = '$admin_id'");
    if ($edit_admin) {
        echo 'success';
        exit();
    } else {
        echo 'fail';
        exit();
    }
} else {
    header("location: ../login.php");
}
