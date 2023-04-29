<?php
session_start();
require_once '../include/connect.php';

if (isset($_SESSION['user_id'])) {
    $no_receipt = $_POST['no_receipt'];

    $delete_data_record = $connect->query("DELETE FROM record WHERE no_receipt = '$no_receipt'");
    $delete_data_payment = $connect->query("DELETE FROM payment WHERE no_receipt = '$no_receipt'");
    if ($delete_data_record && $delete_data_payment) {
        echo 'success';
        exit();
    } else {
        echo 'fail';
        exit();
    }
} else {
    header("location: ../login.php");
}
