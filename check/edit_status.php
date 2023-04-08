<?php
session_start();
require_once '../include/connect.php';

if (isset($_SESSION['user_id'])) {
    $payment_id = $_POST['payment_id'];

    $get_status = $connect->prepare("SELECT status FROM payment WHERE payment_id = '$payment_id'");
    $get_status->execute();
    $row_status = $get_status->fetch(PDO::FETCH_ASSOC);

    if ($row_status['status'] == 0) {
        $new_status = 1;
    } else {
        $new_status = 0;
    }
    $edit_status = $connect->query("UPDATE payment SET status = '$new_status' WHERE payment_id = '$payment_id'");
    if ($edit_status) {
        echo 'success';
        exit();
    } else {
        echo 'fail';
        exit();
    }
} else {
    header("location: ../login.php");
}
