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
        <?php include 'include/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'include/topbar.php'; ?>
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                        <form method="GET" action="dashboard.php">
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
                        </form>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                ยอดขาย (ต่อเดือน)
                                            </div>
                                            <?php
                                            $earnings_monthly = $connect->prepare("SELECT * FROM product INNER JOIN record ON product.product_id = record.product_id INNER JOIN payment ON record.no_receipt = payment.no_receipt WHERE user_id = '$user_id' AND MONTH(timestamp) = $month AND YEAR(timestamp) = $year");
                                            $earnings_monthly->execute();
                                            $row_earnings_monthly = $earnings_monthly->fetchAll(PDO::FETCH_ASSOC);
                                            $sum_month = 0;
                                            foreach ($row_earnings_monthly as $row) {
                                                $sum = $row['quantity'] * $row['net_price'];
                                                $sum_month += $sum;
                                            }
                                            ?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $sum_month ?> บาท</div>
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
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                ยอดขาย (ต่อปี)
                                            </div>
                                            <?php
                                            $earnings_yearly = $connect->prepare("SELECT * FROM product INNER JOIN record ON product.product_id = record.product_id INNER JOIN payment ON record.no_receipt = payment.no_receipt WHERE user_id = '$user_id' AND YEAR(timestamp) = $year");
                                            $earnings_yearly->execute();
                                            $row_earnings_yearly = $earnings_yearly->fetchAll(PDO::FETCH_ASSOC);
                                            $sum_year = 0;
                                            foreach ($row_earnings_yearly as $row) {
                                                $sum = $row['quantity'] * $row['net_price'];
                                                $sum_year += $sum;
                                            }
                                            ?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $sum_year ?> บาท</div>
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
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                จำนวน (ต่อเดือน)
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <?php
                                                    $item = $connect->prepare("SELECT * FROM product INNER JOIN record ON product.product_id = record.product_id INNER JOIN payment ON record.no_receipt = payment.no_receipt WHERE user_id = '$user_id' AND MONTH(timestamp) = $month AND YEAR(timestamp) = $year");
                                                    $item->execute();
                                                    $row_item = $item->fetchAll(PDO::FETCH_ASSOC);
                                                    $sum_item = 0;
                                                    foreach ($row_item as $row) {
                                                        $sum_item += $row['quantity'];
                                                    }
                                                    ?>
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $sum_item ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                จำนวน (ต่อปี)
                                            </div>
                                            <?php
                                            $item_year = $connect->prepare("SELECT * FROM product INNER JOIN record ON product.product_id = record.product_id INNER JOIN payment ON record.no_receipt = payment.no_receipt WHERE user_id = '$user_id' AND YEAR(timestamp) = $year");
                                            $item_year->execute();
                                            $row_item_year = $item_year->fetchAll(PDO::FETCH_ASSOC);
                                            $sum_item_year = 0;
                                            foreach ($row_item_year as $row) {
                                                $sum_item_year += $row['quantity'];
                                            }
                                            ?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $sum_item_year ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <?php
                        $product = $connect->prepare("SELECT * FROM product WHERE user_id = '$user_id'");
                        $product->execute();
                        $row_product = $product->fetchAll(PDO::FETCH_ASSOC);

                        $quantity = $connect->prepare("SELECT SUM(quantity) as quantityall FROM record INNER JOIN product ON record.product_id = product.product_id INNER JOIN payment ON record.no_receipt = payment.no_receipt WHERE user_id = '$user_id' AND MONTH(timestamp) = $month AND YEAR(timestamp) = $year");
                        $quantity->execute();
                        $row_quantity = $quantity->fetch(PDO::FETCH_ASSOC);
                        // echo $row_quantity['quantityall'];
                        ?>
                        <!-- Content Column -->
                        <div class="col-12 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">จำนวน (ต่อเดือน)</h6>
                                </div>
                                <div class="card-body">
                                    <?php
                                    foreach ($row_product as $row) {
                                        $product_id = $row['product_id'];
                                        $record = $connect->prepare("SELECT SUM(quantity) as quantityall FROM record INNER JOIN payment ON record.no_receipt = payment.no_receipt WHERE product_id = '$product_id' AND MONTH(timestamp) = $month AND YEAR(timestamp) = $year");
                                        $record->execute();
                                        $row_record = $record->fetch(PDO::FETCH_ASSOC);
                                        // echo $row_record['quantityall'];
                                    ?>
                                        <h4 class="small font-weight-bold"><?= $row['name'] ?> <span class="float-right"><?= $row_quantity['quantityall'] == 0 ? 'ไม่มียอดขายในเดือนนี้' : number_format(($row_record['quantityall'] / $row_quantity['quantityall']) * 100, 0) . '%' ?></span></h4>
                                        <div class="progress mb-4">
                                            <div class="progress-bar" role="progressbar" style="width: <?= number_format(($row_record['quantityall'] / $row_quantity['quantityall']) * 100, 0) ?>%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <?php
                        $product = $connect->prepare("SELECT * FROM product WHERE user_id = '$user_id'");
                        $product->execute();
                        $row_product = $product->fetchAll(PDO::FETCH_ASSOC);

                        $quantity = $connect->prepare("SELECT SUM(quantity) as quantityall FROM record INNER JOIN product ON record.product_id = product.product_id INNER JOIN payment ON record.no_receipt = payment.no_receipt WHERE user_id = '$user_id' AND YEAR(timestamp) = $year");
                        $quantity->execute();
                        $row_quantity = $quantity->fetch(PDO::FETCH_ASSOC);
                        // echo $row_quantity['quantityall'];
                        ?>
                        <!-- Content Column -->
                        <div class="col-12 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">จำนวน (ต่อปี)</h6>
                                </div>
                                <div class="card-body">
                                    <?php
                                    foreach ($row_product as $row) {
                                        $product_id = $row['product_id'];
                                        $record = $connect->prepare("SELECT SUM(quantity) as quantityall FROM record INNER JOIN payment ON record.no_receipt = payment.no_receipt WHERE product_id = '$product_id' AND YEAR(timestamp) = $year");
                                        $record->execute();
                                        $row_record = $record->fetch(PDO::FETCH_ASSOC);
                                        // echo $row_record['quantityall'];
                                    ?>
                                        <h4 class="small font-weight-bold"><?= $row['name'] ?> <span class="float-right"><?= $row_quantity['quantityall'] == 0 ? 'ไม่มียอดขายในปีนี้' : number_format(($row_record['quantityall'] / $row_quantity['quantityall']) * 100, 0) . '%' ?></span></h4>
                                        <div class="progress mb-4">
                                            <div class="progress-bar" role="progressbar" style="width: <?= number_format(($row_record['quantityall'] / $row_quantity['quantityall']) * 100, 0) ?>%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    <?php } ?>
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