<?php
session_start();
require_once '../include/connect.php';

$email = $_POST['email'];
$password = $_POST['password'];

$check_email = $connect->prepare("SELECT * FROM user WHERE email = :email");
$check_email->bindParam(":email", $email);
$check_email->execute();
$row = $check_email->fetch(PDO::FETCH_ASSOC);

if($check_email->rowCount() > 0){
    if (password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['user_id'];
        header("location: ../information.php");
    }else{
        header("location: ../login.php?status=incorrect");
    }
}else{
    header("location: ../login.php?status=notemail");
}