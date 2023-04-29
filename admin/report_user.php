<!DOCTYPE html>
<html lang="en">

<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("location: login.php");
}
require '../include/connect.php';
include '../include/header.php';

if (!empty($_GET['month'])) {
    $month = $_GET['month'];
}

if (!empty($_GET['year'])) {
    $year = $_GET['year'];
}

$m = '';
$y = '';

if (isset($month)) {
    $m = $month;
}

if (isset($year)) {
    $y = $year;
}

$report_data = $connect->prepare("SELECT * FROM user INNER JOIN product ON user.user_id = product.user_id INNER JOIN record ON product.product_id = record.product_id INNER JOIN payment ON record.no_receipt = payment.no_receipt GROUP BY user.user_id");
if (isset($month) && isset($year)) {
    $report_data = $connect->prepare("SELECT * FROM user INNER JOIN product ON user.user_id = product.user_id INNER JOIN record ON product.product_id = record.product_id INNER JOIN payment ON record.no_receipt = payment.no_receipt WHERE MONTH(timestamp) = $month AND YEAR(timestamp) = $year GROUP BY user.user_id");
}
if (!isset($month) && isset($year)) {
    $report_data = $connect->prepare("SELECT * FROM user INNER JOIN product ON user.user_id = product.user_id INNER JOIN record ON product.product_id = record.product_id INNER JOIN payment ON record.no_receipt = payment.no_receipt WHERE YEAR(timestamp) = $year GROUP BY user.user_id");
}
$report_data->execute();
$row_report = $report_data->fetchAll(PDO::FETCH_ASSOC);

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

$user = $connect->prepare("SELECT * FROM user WHERE status = 1");
$user->execute();
$row_user = $user->fetchAll(PDO::FETCH_ASSOC);
?>

<body id="page-top">
    <div id="wrapper">
        <?php include '../include/sidebar_admin.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include '../include/topbar.php'; ?>
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Report by Users</h1>
                        <form method="GET" action="report_user.php">
                            <div class="d-inline">
                                <select class="form-select form-control-lg is-valid d-inline" name="month">
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

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">ตารางรายงาน</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="10%" class="text-center">ลำดับ</th>
                                            <th width="35%" class="text-center">ร้านค้า</th>
                                            <th width="35%" class="text-center">จำนวน</th>
                                            <th width="20%" class="text-center">ยอดขาย</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $all_price = 0;
                                        $j = 1;
                                        foreach ($row_report as $row) {
                                            $price = $connect->prepare("SELECT net_price, quantity FROM record INNER JOIN product ON record.product_id = product.product_id INNER JOIN user ON product.user_id = user.user_id WHERE user.user_id = '" . $row['user_id'] . "'");
                                            $price->execute();
                                            $row_price = $price->fetchAll(PDO::FETCH_ASSOC);
                                            $total_price = 0;
                                            $total_quantity = 0;
                                            foreach ($row_price as $rp) {
                                                $total_price += $rp['net_price'] * $rp['quantity'];
                                                $total_quantity += $rp['quantity'];
                                            }
                                            $all_price += $total_price;
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $j++ ?></td>
                                                <td class="text-center"><?= $row['store'] ?></td>
                                                <td class="text-center"><?= $total_quantity ?></td>
                                                <td class="text-center"><?= $total_price ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-center">ยอดขายรวมทั้งระบบ</th>
                                            <th class="text-center"><?= $all_price ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <button id="download_link" onClick="javascript:ExcelReport();" class="btn btn-primary float-right mt-3">
                                <i class="fas fa-download fa-sm text-white-50"></i> ดาวน์โหลดตาราง
                            </button>
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

    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/file-saver@1.3.3/FileSaver.js"></script>
    <script>
        function ExcelReport() //function สำหรับสร้าง ไฟล์ excel จากตาราง
        {
            var sheet_name = "excel_sheet"; /* กำหหนดชื่อ sheet ให้กับ excel โดยต้องไม่เกิน 31 ตัวอักษร */
            var elt = document.getElementById('dataTable'); /*กำหนดสร้างไฟล์ excel จาก table element ที่มี id ชื่อว่า myTable*/

            /*------สร้างไฟล์ excel------*/
            var wb = XLSX.utils.table_to_book(elt, {
                sheet: sheet_name
            });
            XLSX.writeFile(wb, 'report.xlsx'); //Download ไฟล์ excel จากตาราง html โดยใช้ชื่อว่า report.xlsx
        }
    </script>
</body>

</html>