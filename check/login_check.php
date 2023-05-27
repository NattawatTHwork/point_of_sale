<?php
session_start();
require_once '../include/connect.php';

$email = $_POST['email'];
$password = $_POST['password'];

$check_email = $connect->prepare("SELECT * FROM user WHERE email = :email");
$check_email->bindParam(":email", $email);
$check_email->execute();
$row = $check_email->fetch(PDO::FETCH_ASSOC);

$all_member = $connect->prepare("SELECT * FROM member WHERE (user_id, approve_date) IN (SELECT user_id, MAX(approve_date) FROM member GROUP BY user_id)");
$all_member->execute();
$row_all_member = $all_member->fetchAll(PDO::FETCH_ASSOC);

$current_date = date('Y-m-d');
foreach ($row_all_member as $rows) {
    if (strtotime($current_date) > strtotime($rows['approve_date'] . ' +1 month')) {
        $uid = $rows['user_id'];
        $update_status = $connect->query("UPDATE user SET status = '0' WHERE user_id = '$uid'");
    }
}

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