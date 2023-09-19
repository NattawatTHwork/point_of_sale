<!DOCTYPE html>
<html lang="en">

<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("location: login.php");
}
require '../include/connect.php';
include '../include/header.php';
?>

<body id="page-top">
    <div id="wrapper">
        <?php include '../include/sidebar_admin.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include '../include/topbar.php'; ?>
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">ร้านค้าในระบบ</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-4" onclick="member_active()">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-lg font-weight-bold text-success text-uppercase mb-1">
                                                สมาชิกใช้งานได้
                                            </div>
                                            <?php
                                            $count = $connect->prepare("SELECT user.user_id, COUNT(*) as count, status FROM user LEFT JOIN member ON user.user_id = member.user_id WHERE status = 1 GROUP BY user_id HAVING count > 1");
                                            $count->execute();
                                            $count_user_id = $count->rowCount();
                                            // $row_user = $count->fetchAll(PDO::FETCH_ASSOC);
                                            // echo '<pre>';
                                            // print_r($row_user);
                                            // echo '</pre>';
                                            ?>
                                            <div class="h3 mb-0 font-weight-bold text-gray-800"><?= $count_user_id ?> ร้าน</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-md-12 mb-4" onclick="member_inactive()">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-lg font-weight-bold text-danger text-uppercase mb-1">
                                                สมาชิกไม่ได้ใช้งาน
                                            </div>
                                            <?php
                                            $count = $connect->prepare("SELECT user.user_id, COUNT(*) as count, status FROM user LEFT JOIN member ON user.user_id = member.user_id WHERE status = 0 GROUP BY user_id HAVING count > 1");
                                            $count->execute();
                                            $count_user_id = $count->rowCount();
                                            ?>
                                            <div class="h3 mb-0 font-weight-bold text-gray-800"><?= $count_user_id ?> ร้าน</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-md-12 mb-4" onclick="trial()">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-lg font-weight-bold text-info text-uppercase mb-1">
                                                ทดลองใช้งาน
                                            </div>
                                            <?php
                                            $count = $connect->prepare("SELECT user_id, COUNT(*) as count FROM member GROUP BY user_id HAVING count = 1");
                                            $count->execute();
                                            $count_user_id = $count->rowCount();
                                            ?>
                                            <div class="h3 mb-0 font-weight-bold text-gray-800"><?= $count_user_id ?> ร้าน</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-md-12 mb-4" onclick="wait()">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-lg font-weight-bold text-warning text-uppercase mb-1">
                                                รอการอนุมัติ
                                            </div>
                                            <?php
                                            $count = $connect->prepare("SELECT COUNT(*) as count FROM user LEFT JOIN member ON user.user_id = member.user_id WHERE member.user_id IS NULL");
                                            $count->execute();
                                            $row = $count->fetch(PDO::FETCH_ASSOC);
                                            $count_user_id = $row['count'];
                                            ?>
                                            <div class="h3 mb-0 font-weight-bold text-gray-800"><?= $count_user_id ?> ร้าน</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include '../include/footer.php'; ?>
        </div>
    </div>
    <?php include '../include/scroll.php'; ?>
    <?php include '../include/modal.php'; ?>
    <?php include '../include/js.php'; ?>

    <script>
        function member_active() {
            window.location.href = window.location.protocol + "//" + window.location.host + "/admin/user.php?status=member_active";
        }

        function member_inactive() {
            window.location.href = window.location.protocol + "//" + window.location.host + "/admin/user.php?status=member_inactive";
        }

        function trial() {
            window.location.href = window.location.protocol + "//" + window.location.host + "/admin/user.php?status=trial";
        }

        function wait() {
            window.location.href = window.location.protocol + "//" + window.location.host + "/admin/user.php?status=wait";
        }
    </script>
</body>

</html>