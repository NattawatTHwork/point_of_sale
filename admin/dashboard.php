<!DOCTYPE html>
<html lang="en">

<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("location: login.php");
}
require '../include/connect.php';
include '../include/header.php';

$months = array(
    "มกราคม", // January
    "กุมภาพันธ์", // February
    "มีนาคม", // March
    "เมษายน", // April
    "พฤษภาคม", // May
    "มิถุนายน", // June
    "กรกฎาคม", // July
    "สิงหาคม", // August
    "กันยายน", // September
    "ตุลาคม", // October
    "พฤศจิกายน", // November
    "ธันวาคม" // December
);

if (isset($_GET['month'])) {
    $month = $_GET['month'];
} else {
    $month = 'MONTH(CURRENT_DATE())';
}

if (isset($_GET['year'])) {
    $year = $_GET['year'];
} else {
    $year = 'YEAR(CURRENT_DATE())';
}
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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <!-- <form method="GET" action="dashboard.php">
                            <div class="d-inline">
                                <select class="form-select form-control-lg is-valid d-inline" name="month" required>
                                    <?php for ($i = 0; $i < 12; $i++) { ?>
                                        <option value="<?= $i + 1 ?>"><?= $months[$i] ?></option>
                                    <?php } ?>
                                </select>
                                <select class="form-select form-control-lg is-valid d-inline" name="year">
                                    <?php for ($i = 2023; $i <= 2037; $i++) { ?>
                                        <option value="<?= $i ?>"><?= $i + 543 ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16" class="text-gray-300">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                                ค้นหา
                            </button>
                        </form> -->
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- <div class="col-xl-6 col-md-6 mb-4" onclick="active()">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                ร้านที่เปิดใช้งาน
                                            </div>
                                            <?php
                                            $store_active = $connect->prepare("SELECT * FROM user WHERE status = 1");
                                            $store_active->execute();
                                            $row_store_active = $store_active->fetchAll(PDO::FETCH_ASSOC);
                                            ?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($row_store_active) ?> ร้าน</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- <div class="col-xl-6 col-md-6 mb-4" onclick="inactive()">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                ร้านที่ปิดใช้งาน
                                            </div>
                                            <?php
                                            $store_inactive = $connect->prepare("SELECT * FROM user WHERE status = 0");
                                            $store_inactive->execute();
                                            $row_store_inactive = $store_inactive->fetchAll(PDO::FETCH_ASSOC);
                                            ?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($row_store_inactive) ?> ร้าน</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <div class="col-xl-12 col-md-12 mb-4" onclick="member()">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                สมาชิก
                                            </div>
                                            <?php
                                            $count = $connect->prepare("SELECT user_id, COUNT(*) as count FROM member GROUP BY user_id HAVING count > 1");
                                            $count->execute();
                                            $count_user_id = $count->rowCount();
                                            ?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $count_user_id ?> ร้าน</div>
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
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                ทดลองใช้งาน
                                            </div>
                                            <?php
                                            $count = $connect->prepare("SELECT user_id, COUNT(*) as count FROM member GROUP BY user_id HAVING count = 1");
                                            $count->execute();
                                            $count_user_id = $count->rowCount();
                                            ?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $count_user_id ?> ร้าน</div>
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
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                รอการอนุมัติ
                                            </div>
                                            <?php
                                            $count = $connect->prepare("SELECT COUNT(*) as count FROM user LEFT JOIN member ON user.user_id = member.user_id WHERE member.user_id IS NULL");
                                            $count->execute();
                                            $row = $count->fetch(PDO::FETCH_ASSOC);
                                            $count_user_id = $row['count'];
                                            ?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $count_user_id ?> ร้าน</div>
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
        function active() {
            window.location.href = window.location.protocol + "//" + window.location.host + "/admin/user.php?status=active";
        }

        function inactive() {
            window.location.href = window.location.protocol + "//" + window.location.host + "/admin/user.php?status=inactive";
        }

        function member() {
            window.location.href = window.location.protocol + "//" + window.location.host + "/admin/user.php?status=member";
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