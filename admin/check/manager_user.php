<?php
session_start();
require_once '../../include/connect.php';

if (isset($_SESSION['admin_id'])) {
    $action = $_POST['action'];
    if ($action != 'image') {
        $user_id = $_POST['user_id'];
    }
    date_default_timezone_set('Asia/Bangkok');
    $approve_date = date('Y-m-d');

    if ($action == 'new_user') {
        $insert_member = $connect->prepare("INSERT INTO member(user_id, approve_date) VALUES(:user_id, :approve_date)");
        $insert_member->bindParam(":user_id", $user_id);
        $insert_member->bindParam(":approve_date", $approve_date);
        $insert_member->execute();
        $update_status = $connect->query("UPDATE user SET status = '1' WHERE user_id = '$user_id'");
    } elseif ($action == 'trial') {
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
    } elseif ($action == 'member') {
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
    } elseif ($action == 'cancel') {
        $insert_member = $connect->query("DELETE FROM member WHERE user_id = '$user_id' ORDER BY member_id DESC LIMIT 1");
    } elseif ($action == 'image') {
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

    $all_member = $connect->prepare("SELECT * FROM member WHERE (user_id, approve_date) IN (SELECT user_id, MAX(approve_date) FROM member GROUP BY user_id)");
    $all_member->execute();
    $row_all_member = $all_member->fetchAll(PDO::FETCH_ASSOC);

    $current_date = date('Y-m-d');
    foreach ($row_all_member as $rows) {
        if (strtotime($current_date) > strtotime($rows['approve_date'] . ' +1 month +5 days')) {
            $uid = $rows['user_id'];
            $update_status = $connect->query("UPDATE user SET status = '0' WHERE user_id = '$uid'");
        }
    }

    // if ($action != 'image') {
    if ($insert_member) {
        echo 'success';
        exit();
    } else {
        echo 'fail';
        exit();
    }
    // }
} else {
    header("location: ../login.php");
}
