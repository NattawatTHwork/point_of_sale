<?php
session_start();
require_once '../include/connect.php';

if (isset($_SESSION['user_id'])) {
    $action = $_POST['action'];
    date_default_timezone_set('Asia/Bangkok');

    if ($action == 'image') {
        $member_id = $_POST['member_id'];
        $get_img = $connect->prepare("SELECT * FROM member WHERE member_id = '$member_id'");
        $get_img->execute();
        $row_get_img = $get_img->fetch(PDO::FETCH_ASSOC);
        if ($row_get_img) {
            echo json_encode($row_get_img);
            exit();
        } else {
            echo 'fail';
            exit();
        }
    }

    if ($insert_member) {
        echo 'success';
        exit();
    } else {
        echo 'fail';
        exit();
    }
} else {
    header("location: ../login.php");
}
