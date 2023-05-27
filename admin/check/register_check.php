<?php
session_start();
require_once '../../include/connect.php';

if ($_POST['password'] !== $_POST['repeatpassword']) {
    header("location: ../register.php?status=notmatch");
    exit();
}

$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$password_view = $_POST['password'];
$satus = 0;

$check_email = $connect->prepare("SELECT email FROM admin WHERE email = :email");
$check_email->bindParam(":email", $email);
$check_email->execute();
$row = $check_email->fetch(PDO::FETCH_ASSOC);

if ($check_email->rowCount() > 0) {
    header("location: ../register.php?status=duplicate");
    exit();
} else {
    $create_id = $connect->prepare("INSERT INTO admin(email, password, password_view, status) VALUES(:email, :password, :password_view, :status)");
    $create_id->bindParam(':email', $email);
    $create_id->bindParam(':password', $password);
    $create_id->bindParam(':password_view', $password_view);
    $create_id->bindParam(':status', $satus);
    $create_id->execute();
    if ($create_id) {
        header("location: ../login.php");
        exit();
    }
}
