<?php
session_start();
require_once '../../include/connect.php';

if (isset($_SESSION['admin_id'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $admin_id = $_SESSION['admin_id'];

    $update_information = $connect->query("UPDATE admin SET firstname = '$firstname', lastname = '$lastname' WHERE admin_id = '$admin_id'");
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
