<!DOCTYPE html>
<html lang="en">

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
}
require 'include/connect.php';
include 'include/header.php';

if (isset($_GET['no_receipt'])) {
    $no_receipt = $_GET['no_receipt'];
} else {
    $no_receipt = '';
}

$detail_data = $connect->prepare("SELECT * FROM payment INNER JOIN record ON payment.no_receipt = record.no_receipt INNER JOIN product ON record.product_id = product.product_id INNER JOIN user ON product.user_id = user.user_id WHERE record.no_receipt = $no_receipt");
$detail_data->execute();
$row_detail_data = $detail_data->fetchAll(PDO::FETCH_ASSOC);

if ($row_detail_data[0]['user_id'] != $_SESSION['user_id']) {
    header("location: report_payment_date.php");
}
?>

<body id="page-top">
    <div id="wrapper">
        <?php include 'include/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'include/topbar.php'; ?>
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Receipt</h1>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">หมายเลขใบเสร็จ : <?= isset($_GET['no_receipt']) ? $_GET['no_receipt'] : '' ?></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless text-center" id="Table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th colspan="4" style="font-size: 32px;"><?= $row_detail_data[0]['store'] ?></th>
                                        </tr>
                                        <tr>
                                            <th colspan="4">หมายเลขใบเสร็จ <?= $row_detail_data[0]['no_receipt'] ?></th>
                                        </tr>
                                        <tr>
                                            <th colspan="4">วันที่ <?= $row_detail_data[0]['timestamp'] ?></th>
                                        </tr>
                                        <tr>
                                            <th colspan="4">ที่อยู่ร้านค้า <?= $row_detail_data[0]['address'] ?></th>
                                        </tr>
                                        <tr>
                                            <th colspan="4"><?= $row_detail_data[0]['timestamp'] == 1 ? 'ชำระเงินด้วยพร้อมเพย์' : 'ชำระเงินด้วยเงินสด' ?></th>
                                        </tr>
                                        <tr>
                                            <th colspan="4"></th>
                                        </tr>
                                        <tr>
                                            <th style="border: 1px solid gray;">จำนวน</th>
                                            <th style="border: 1px solid gray;">ชื่อเครื่องดื่ม</th>
                                            <th style="border: 1px solid gray;">ราคา</th>
                                            <th style="border: 1px solid gray;">จำนวนเงิน</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_price = 0;
                                        foreach ($row_detail_data as $row) {
                                            $price = $row['net_price'] * $row['quantity'];
                                            $total_price += $price;
                                        ?>
                                            <tr>
                                                <th style="border: 1px solid gray;"><?= $row['quantity'] ?></th>
                                                <th style="border: 1px solid gray;"><?= $row['name'] ?></td>
                                                <th style="border: 1px solid gray;"><?= $row['net_price'] ?></td>
                                                <th style="border: 1px solid gray;"><?= $price ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" style="border: 1px solid gray;">ราคารวม</th>
                                            <th style="border: 1px solid gray;"><?= $total_price ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <button class="no-print btn btn-primary float-right mt-3" onclick="print_receipt(<?= $no_receipt ?>)">พิมพ์ใบเสร็จ</button>
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

    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/file-saver@1.3.3/FileSaver.js"></script>
    <script>
        function print_receipt(no_receipt) {
            // Get the receipt table element
            var table = document.getElementById("Table");

            // Create a new window to print the receipt
            var printWindow = window.open('', 'Print Receipt');
            printWindow.document.write('<html><head><title>Receipt</title></head><body>');
            printWindow.document.write(table.outerHTML);
            printWindow.document.write('<div>ผู้รับเงิน: ........................................</div>');
            printWindow.document.write('</body></html>');

            // Print the receipt and close the window
            printWindow.print();
            printWindow.close();


            // // Get the receipt table element
            // var table = document.getElementById("Table");

            // // Open a new window to send print commands to the printer
            // var printWindow = window.open('', 'Print Receipt');
            // printWindow.document.write('<html><head><title>Receipt</title></head><body>');

            // // Add the CSS styles to format the receipt for printing
            // printWindow.document.write('<style>');
            // printWindow.document.write('@media print {');
            // printWindow.document.write('  body { font-size: 12pt; }');
            // printWindow.document.write('  table { border-collapse: collapse; }');
            // printWindow.document.write('  th, td { padding: 0.2em 0.5em; border: 1px solid black; }');
            // printWindow.document.write('}');
            // printWindow.document.write('</style>');

            // // Add the receipt table to the window
            // printWindow.document.write(table.outerHTML);
            // printWindow.document.write('</body></html>');

            // // Send print commands to the printer
            // printWindow.print();
            // printWindow.close();
        }
    </script>
</body>

</html>