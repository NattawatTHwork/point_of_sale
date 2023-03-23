<?php
session_start();
require_once '../include/connect.php';

if (isset($_SESSION['user_id'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $store = $_POST['store'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];

    $update_information = $connect->query("UPDATE user SET firstname = '$firstname', lastname = '$lastname', store = '$store', description = '$description' WHERE user_id = '$user_id'");
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
