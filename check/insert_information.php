<?php
session_start();
require_once '../include/connect.php';

if (isset($_SESSION['user_id'])) {
    if ($_POST['action'] == 'information') {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $id_number = $_POST['id_number'];
        $phone = $_POST['phone'];
        $line = $_POST['line'];
        $address = $_POST['address'];
        $store = $_POST['store'];
        $description = $_POST['description'];
        $agree = $_POST['agree'];
        $user_id = $_SESSION['user_id'];
        $newname = $_POST['checkpreimg'];

        if (!empty($_FILES['preimg']['name'])) {
            $image = $_FILES['preimg']['name'];
            $newname = uniqid(10) . basename($image);
            $target = "../img/" . $newname;
            move_uploaded_file($_FILES['preimg']['tmp_name'], $target);
            // $conn->query("INSERT INTO contractor_pic (contractor_info_id, contractor_pic_sort, contractor_pic_path)
            // VALUE('" . $contractor_id . "', '1', '" . $newname . "')");
        }

        $update_information = $connect->query("UPDATE user SET firstname = '$firstname', lastname = '$lastname', id_number = '$id_number', phone = '$phone', line = '$line', address = '$address', store = '$store', description = '$description', img_path = '$newname', agree = '$agree' WHERE user_id = '$user_id'");
        if ($update_information) {
            echo 'success';
            exit();
        } else {
            echo 'fail';
            exit();
        }
    } elseif ($_POST['action'] == 'subscribe') {
        $user_id = $_SESSION['user_id'];
        date_default_timezone_set('Asia/Bangkok');
        $approve_date = date('Y-m-d');

        $member_last = $connect->prepare("SELECT * FROM member WHERE user_id = '$user_id' ORDER BY member_id DESC");
        $member_last->execute();
        $row_member_last = $member_last->fetch(PDO::FETCH_ASSOC);
        if (strtotime($row_member_last['approve_date'] . ' +1 month') <= strtotime($approve_date)) {
            $approve_date = date('Y-m-d', strtotime($approve_date));
            $insert_member = $connect->prepare("INSERT INTO member(user_id, approve_date) VALUES(:user_id, :approve_date)");
            $insert_member->bindParam(":user_id", $user_id);
            $insert_member->bindParam(":approve_date", $approve_date);
            $insert_member->execute();
        } elseif (strtotime($row_member_last['approve_date'] . ' +1 month') > strtotime($approve_date)) {
            $approve_date = date('Y-m-d', strtotime($row_member_last['approve_date'] . ' +1 month'));
            $insert_member = $connect->prepare("INSERT INTO member(user_id, approve_date) VALUES(:user_id, :approve_date)");
            $insert_member->bindParam(":user_id", $user_id);
            $insert_member->bindParam(":approve_date", $approve_date);
            $insert_member->execute();
        }
        $update_status = $connect->query("UPDATE user SET status = '1' WHERE user_id = '$user_id'");
        if ($insert_member && $update_status) {
            echo 'success';
            exit();
        } else {
            echo 'fail';
            exit();
        }
    } elseif ($_POST['action'] == 'contact') {
        $user_id = $_SESSION['user_id'];
        $member_id = $_POST['member_id'];

        if (!empty($_FILES['preimg1']['name'])) {
            $image = $_FILES['preimg1']['name'];
            $newname = uniqid(10) . basename($image);
            $target = "../img/" . $newname;
            move_uploaded_file($_FILES['preimg1']['tmp_name'], $target);
        }
        $update_information = $connect->query("UPDATE member SET img_path = '$newname' WHERE member_id = '$member_id'");

        if (true) {
            echo 'success';
            exit();
        } else {
            echo 'fail';
            exit();
        }
    }
} else {
    header("location: ../login.php");
}
