<?php
session_start();
require_once '../../include/connect.php';

if (isset($_SESSION['admin_id'])) {
    $type_id = $_POST['type_id'];

    $delete_type = $connect->query("DELETE FROM type WHERE type_id = '$type_id'");
    if ($delete_type) {
        echo 'success';
        exit();
    } else {
        echo 'fail';
        exit();
    }
} else {
    header("location: ../login.php");
}
