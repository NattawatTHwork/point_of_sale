<!DOCTYPE html>
<html lang="en">

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
}
require 'include/connect.php';
include 'include/header.php';

$user_id = $_SESSION['user_id'];
$user = $connect->prepare("SELECT * FROM user WHERE user_id = '$user_id'");
$user->execute();
$row_user = $user->fetch(PDO::FETCH_ASSOC);

?>

<body id="page-top">
    <div id="wrapper">
        <?php include 'include/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'include/topbar.php'; ?>
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><?= 'ชื่อร้านค้า : ' . $row_user['store'] ?></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div>
                                <table width="60%">
                                    <tbody>
                                        <tr>
                                            <td height="60px" class="font-weight-bold">ชื่อผู้ใช้งาน</td>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            <td><?= $row_user['firstname'].' '.$row_user['lastname'] ?></td>
                                        </tr>
                                        <tr>
                                            <td height="60px" class="font-weight-bold">ชื่อร้านค้า</td>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            <td><?= $row_user['store'] ?></td>
                                        </tr>
                                        <tr>
                                            <td height="60px" class="font-weight-bold">อีเมล</td>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            <td><?= $row_user['email'] ?></td>
                                        </tr>
                                        <tr>
                                            <td height="60px" class="font-weight-bold">รายละเอียดร้านค้า</td>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            <td><?= $row_user['description'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                                <br>
                                <div class="text-center">
                                    <img src="./img/<?= $row_user['img_path'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'include/footer.php'; ?>
        </div>
    </div>
    <?php include 'include/scroll.php'; ?>
    <?php include 'include/modal.php'; ?>
    <?php include 'include/js.php'; ?>
</body>

</html>