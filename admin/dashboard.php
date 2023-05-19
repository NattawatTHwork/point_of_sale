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

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
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
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
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
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <?php
                        $user = $connect->prepare("SELECT * FROM user WHERE status = 1");
                        $user->execute();
                        $row_user = $user->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <!-- Content Column -->
                        <div class="col-12 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">ยอดขายร้านค้า</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th width="60%">ร้านค้า</th>
                                                    <th width="40%">ยอดขายรายเดือน</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                foreach ($row_user as $row) {
                                                    $user_id = $row['user_id'];
                                                    $sales = $connect->prepare("SELECT * FROM product INNER JOIN record ON product.product_id = record.product_id INNER JOIN payment ON record.no_receipt = payment.no_receipt WHERE user_id = '$user_id' AND MONTH(timestamp) = MONTH(CURRENT_DATE()) AND YEAR(timestamp) = YEAR(CURRENT_DATE())");
                                                    $sales->execute();
                                                    $row_sales = $sales->fetchAll(PDO::FETCH_ASSOC);
                                                    $total_price = 0;
                                                    foreach ($row_sales as $rows) {
                                                        $total_price += $rows['quantity'] * $rows['net_price']; 
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td><?= $row['store'] ?></td>
                                                        <td><?= $total_price ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
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
</body>

</html>