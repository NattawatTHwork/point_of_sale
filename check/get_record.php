<?php
session_start();
require_once '../include/connect.php';

if (isset($_SESSION['user_id'])) {
    $no_receipt = $_POST['no_receipt'];

    $get_record = $connect->prepare("SELECT * FROM record INNER JOIN product ON record.product_id = product.product_id WHERE no_receipt = '$no_receipt'");
    $get_record->execute();
    $row_record = $get_record->fetchAll(PDO::FETCH_ASSOC);
    if ($row_record) {
        echo json_encode($row_record);
        exit();
    } else {
        echo 'fail';
        exit();
    }
} else {
    header("location: ../login.php");
}
