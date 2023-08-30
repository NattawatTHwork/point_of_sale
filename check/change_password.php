<?php
session_start();
require_once '../include/connect.php';

if (isset($_SESSION['user_id'])) {
    $old_password = $_POST['old_password'];
    $password = $_POST['password'];
    $repeatpassword = $_POST['repeatpassword'];
    $user_id = $_SESSION['user_id'];

    if ($password == $repeatpassword) {
        $get_password = $connect->prepare("SELECT password_view FROM user WHERE user_id = '$user_id'");
        $get_password->execute();
        $row_password = $get_password->fetch(PDO::FETCH_ASSOC);

        if ($row_password['password_view'] == $old_password) {
            $hash_password = password_hash($password, PASSWORD_DEFAULT);
            $edit_password = $connect->query("UPDATE user SET password = '$hash_password', password_view = '$password' WHERE user_id = '$user_id'");
            if ($edit_password) {
                echo 'success';
                exit();
            } else {
                echo 'fail';
                exit();
            }
        }
    }
} else {
    header("location: ../login.php");
}
