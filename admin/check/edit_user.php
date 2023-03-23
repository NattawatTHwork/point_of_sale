<?php
session_start();
require_once '../../include/connect.php';

if (isset($_SESSION['admin_id'])) {
    $status = $_POST['status'];
    $user_id = $_POST['user_id'];

    $edit_user = $connect->query("UPDATE user SET status = '$status' WHERE user_id = '$user_id'");
    if ($edit_user) {
        echo 'success';
        exit();
    } else {
        echo 'fail';
        exit();
    }
} else {
    header("location: ../login.php");
}
