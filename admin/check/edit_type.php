<?php
session_start();
require_once '../../include/connect.php';

if (isset($_SESSION['admin_id'])) {
    $type = $_POST['type'];
    $type_id = $_POST['type_id'];
    $admin_id = $_SESSION['admin_id'];

    $edit_type = $connect->query("UPDATE type SET type = '$type' WHERE type_id = '$type_id'");
    if ($edit_type) {
        echo 'success';
        exit();
    } else {
        echo 'fail';
        exit();
    }
} else {
    header("location: ../login.php");
}
