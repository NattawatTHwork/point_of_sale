<!DOCTYPE html>
<html lang="en">

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
}
require './include/connect.php';
include './include/header.php';


$user_id = $_SESSION['user_id'];
$member_count = $connect->prepare("SELECT * FROM member WHERE user_id = '$user_id'");
$member_count->execute();
$row_member_count = $member_count->fetchAll(PDO::FETCH_ASSOC);
$count = count($row_member_count);
$i = 1;

?>

<body id="page-top">
    <div id="wrapper">
        <?php include './include/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include './include/topbar.php'; ?>
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">
                            <?php
                            if ($count == 0) {
                                echo 'ผู้ใช้งานใหม่';
                            } elseif ($count == 1) {
                                echo 'ทดลองใช้งาน';
                            } else {
                                echo 'สมาชิก';
                            }
                            ?>
                        </h1>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">ประวัติการใช้บริการ</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>วันที่เริ่ม</th>
                                            <th>วันสิ้นสุด</th>
                                            <th>ค่าบริการ</th>
                                            <th>หลักฐาน</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($row_member_count as $row) {
                                        ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= date('d-m-Y', strtotime($row['approve_date'])) ?></td>
                                                <td><?= $end = date('d-m-Y', strtotime($row['approve_date'] . ' +1 month')) ?></td>
                                                <?php
                                                $start_date = $row['approve_date'];
                                                $end_date = date('Y-m-d', strtotime($start_date . ' +1 month'));
                                                $service_fee = $connect->prepare("SELECT * FROM payment INNER JOIN record ON payment.no_receipt = record.no_receipt INNER JOIN product ON record.product_id = product.product_id WHERE user_id = '$user_id' AND timestamp >= '$start_date' AND timestamp <= '$end_date'");
                                                $service_fee->execute();
                                                $row_service_fee = $service_fee->fetchAll(PDO::FETCH_ASSOC);
                                                $total_price = 0;
                                                foreach ($row_service_fee as $row_fee) {
                                                    $total_price = $total_price + ($row_fee['quantity'] * $row_fee['net_price']);
                                                }
                                                $fee = $total_price * 0.02;
                                                ?>
                                                <td><?= $i == 2 ? 'ทดลองใช้งาน' : $fee ?></td>
                                                <td><button type="button" class="btn btn-primary" onclick="view(<?= $row['member_id'] ?>)" <?= $i == 2 ? 'style="display: none;"' : '' ?> <?= empty($row['img_path']) ? 'disabled' : '' ?>>ดูหลักฐาน</button></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div class="text-center">
                                <?php if ($count != 0) { ?>
                                    <h5>บริการจะสิ้นสุดวันที่ <?= $end ?></h5>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php include './include/footer.php'; ?>
        </div>
    </div>
    <?php include './include/scroll.php'; ?>
    <?php include './include/modal.php'; ?>
    <?php include './include/js.php'; ?>

    <div class="modal fade" id="view" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">หลักฐานการชำระเงิน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <img src="" name="img_path" id="img_path" class="mx-auto d-block" width="400">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function view(member_id) {
            $.ajax({
                url: 'check/history.php',
                type: "POST",
                data: {
                    action: 'image',
                    member_id: member_id
                },
                success: function(response) {
                    let res = JSON.parse(response);
                    var img = document.getElementById('img_path');
                    if (res.img_path.length === 0) {
                        img.setAttribute("src", '../img/no_image.jpg');
                    } else {
                        img.setAttribute("src", '../img/' + res.img_path);
                    }
                    $("#view").modal("show");
                }
            });
        }
    </script>
</body>

</html>