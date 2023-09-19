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

$m = date('m');
$y = date('Y');

if (!empty($_GET['month'])) {
    $m = $_GET['month'];
}

if (!empty($_GET['year'])) {
    $y = $_GET['year'];
}

$current_date =  date('Y-m-d');
$thai_month_names = array(
    'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
    'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
);
$month_number = date('n', strtotime($current_date));
$thai_month = $thai_month_names[$month_number - 1];

$date_obj = date_create($current_date);
date_modify($date_obj, "+543 years");
$current_date = date_format($date_obj, "j $thai_month Y");
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
                        <form method="GET" action="dashboard.php">
                            <div class="d-inline">
                                <select class="form-select form-control-lg is-valid d-inline" name="month" required>
                                    <option value="">เดือน</option>
                                    <?php for ($i = 0; $i < 12; $i++) { ?>
                                        <option value="<?= $i + 1 ?>" <?= $m == $i + 1 ? 'selected' : '' ?>><?= $months[$i] ?></option>
                                    <?php } ?>
                                </select>
                                <select class="form-select form-control-lg is-valid d-inline" name="year" required>
                                    <option value="">ปี</option>
                                    <?php for ($i = 2023; $i <= 2037; $i++) { ?>
                                        <option value="<?= $i ?>" <?= $y == $i ? 'selected' : '' ?>><?= $i + 543 ?></option>
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

                        <div class="col-xl-12 col-md-12 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                ยอดการชำระพร้อมเพย์ <?= $current_date ?>
                                            </div>
                                            <?php
                                            $promptpay = $connect->prepare("SELECT * FROM product INNER JOIN record ON product.product_id = record.product_id INNER JOIN payment ON record.no_receipt = payment.no_receipt WHERE user_id = '$user_id' AND method = 1 AND DATE_FORMAT(timestamp, '%d') = DAY(CURDATE()) AND MONTH(timestamp) = MONTH(CURRENT_DATE()) AND YEAR(timestamp) = YEAR(CURRENT_DATE())");
                                            $promptpay->execute();
                                            $row_promptpay = $promptpay->fetchAll(PDO::FETCH_ASSOC);
                                            $sum_promptpay = 0;
                                            foreach ($row_promptpay as $row) {
                                                $sum = $row['quantity'] * $row['net_price'];
                                                $sum_promptpay += $sum;
                                            }
                                            ?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $sum_promptpay ?> บาท</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-md-12 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                ยอดการชำระเงินสด <?= $current_date ?>
                                            </div>
                                            <?php
                                            $cash = $connect->prepare("SELECT * FROM product INNER JOIN record ON product.product_id = record.product_id INNER JOIN payment ON record.no_receipt = payment.no_receipt WHERE user_id = '$user_id' AND method = 0 AND DATE_FORMAT(timestamp, '%d') = DAY(CURDATE()) AND MONTH(timestamp) = MONTH(CURRENT_DATE()) AND YEAR(timestamp) = YEAR(CURRENT_DATE())");
                                            $cash->execute();
                                            $row_cash = $cash->fetchAll(PDO::FETCH_ASSOC);
                                            $sum_cash = 0;
                                            foreach ($row_cash as $row) {
                                                $sum = $row['quantity'] * $row['net_price'];
                                                $sum_cash += $sum;
                                            }
                                            ?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $sum_cash ?> บาท</div>
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
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                ยอดขาย (ต่อเดือน)
                                            </div>
                                            <?php
                                            $earnings_monthly = $connect->prepare("SELECT * FROM product INNER JOIN record ON product.product_id = record.product_id INNER JOIN payment ON record.no_receipt = payment.no_receipt WHERE user_id = '$user_id' AND MONTH(timestamp) = $m AND YEAR(timestamp) = $y");
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
                                            $earnings_yearly = $connect->prepare("SELECT * FROM product INNER JOIN record ON product.product_id = record.product_id INNER JOIN payment ON record.no_receipt = payment.no_receipt WHERE user_id = '$user_id' AND YEAR(timestamp) = $y");
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
                                                    $item = $connect->prepare("SELECT * FROM product INNER JOIN record ON product.product_id = record.product_id INNER JOIN payment ON record.no_receipt = payment.no_receipt WHERE user_id = '$user_id' AND MONTH(timestamp) = $m AND YEAR(timestamp) = $y");
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
                                            $item_year = $connect->prepare("SELECT * FROM product INNER JOIN record ON product.product_id = record.product_id INNER JOIN payment ON record.no_receipt = payment.no_receipt WHERE user_id = '$user_id' AND YEAR(timestamp) = $y");
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
                        $product = $connect->prepare("SELECT * FROM product WHERE user_id = '$user_id' LIMIT 5");
                        $product->execute();
                        $row_product = $product->fetchAll(PDO::FETCH_ASSOC);

                        $quantity = $connect->prepare("SELECT SUM(quantity) as quantityall FROM record INNER JOIN product ON record.product_id = product.product_id INNER JOIN payment ON record.no_receipt = payment.no_receipt WHERE user_id = '$user_id' AND MONTH(timestamp) = $m AND YEAR(timestamp) = $y");
                        $quantity->execute();
                        $row_quantity = $quantity->fetch(PDO::FETCH_ASSOC);
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
                                        $record = $connect->prepare("SELECT SUM(quantity) as quantityall FROM record INNER JOIN payment ON record.no_receipt = payment.no_receipt WHERE product_id = '$product_id' AND MONTH(timestamp) = $m AND YEAR(timestamp) = $y");
                                        $record->execute();
                                        $row_record = $record->fetch(PDO::FETCH_ASSOC);
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
                        $product = $connect->prepare("SELECT * FROM product WHERE user_id = '$user_id' LIMIT 5");
                        $product->execute();
                        $row_product = $product->fetchAll(PDO::FETCH_ASSOC);

                        $quantity = $connect->prepare("SELECT SUM(quantity) as quantityall FROM record INNER JOIN product ON record.product_id = product.product_id INNER JOIN payment ON record.no_receipt = payment.no_receipt WHERE user_id = '$user_id' AND YEAR(timestamp) = $y");
                        $quantity->execute();
                        $row_quantity = $quantity->fetch(PDO::FETCH_ASSOC);
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
                                        $record = $connect->prepare("SELECT SUM(quantity) as quantityall FROM record INNER JOIN payment ON record.no_receipt = payment.no_receipt WHERE product_id = '$product_id' AND YEAR(timestamp) = $y");
                                        $record->execute();
                                        $row_record = $record->fetch(PDO::FETCH_ASSOC);
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