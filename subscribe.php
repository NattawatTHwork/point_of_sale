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
$member_count = $connect->prepare("SELECT * FROM member WHERE user_id = '$user_id'");
$member_count->execute();
$row_member_count = $member_count->fetchAll(PDO::FETCH_ASSOC);
$count = count($row_member_count);
$fee = 0;
$member_last = $connect->prepare("SELECT * FROM member WHERE user_id = '$user_id' ORDER BY member_id DESC");
$member_last->execute();
$row_member_last = $member_last->fetch(PDO::FETCH_ASSOC);
if ($count > 0) {
    $start_date = $row_member_last['approve_date'];
    $end_date = date('Y-m-d', strtotime($start_date . ' +1 month'));
    $service_fee = $connect->prepare("SELECT * FROM payment INNER JOIN record ON payment.no_receipt = record.no_receipt INNER JOIN product ON record.product_id = product.product_id WHERE user_id = '$user_id' AND timestamp >= '$start_date' AND timestamp <= '$end_date'");
    $service_fee->execute();
    $row_service_fee = $service_fee->fetchAll(PDO::FETCH_ASSOC);
    $total_price = 0;
    foreach ($row_service_fee as $row_fee) {
        $total_price = $total_price + ($row_fee['quantity'] * $row_fee['net_price']);
    }
    $fee = number_format((($total_price * 0.93) * 0.02), 2, '.', ',');
}


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
                            <h6 class="m-0 font-weight-bold text-primary">ชำระค่าบริการ</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="text-center">
                                    <h4>ระยะเวลาการใช้บริการของคุณหมดแล้ว</h4>
                                    <h5>กรุณาชำระค่าบริการเพื่อใช้งานต่อ</h5>
                                    <h5>ค่าบริการ <b><?= $fee ?></b> บาท</h5>
                                    <br>
                                    <h5>นาย ณัฐวัตร ทุ่งเย็น</h5>
                                    <h5>057-2-67368-9</h5>
                                    <h5>ทีเอ็มบีธนชาต <img src="https://upload.wikimedia.org/wikipedia/commons/d/dd/Ttb_bank_logo2.png" width="50"></h5>
                                </div>
                                <div class="text-center">
                                    <form id="contact">
                                        <input type="hidden" name="action" value="contact" />
                                        <input type="hidden" name="member_id" value="<?= $row_member_last['member_id'] ?>" />
                                        <div class="form-floating mb-3">
                                            <img id="showpic1" src="./img/add_image.png" class="rounded col-sm-12" onclick="document.getElementById('preimg1').click();" style="cursor: pointer; width: 300px; display: block; margin: auto;">
                                        </div>
                                        <div class="text-center">
                                            <input type="file" class="sr-only" id="preimg1" name="preimg1" accept="image/*" onchange="readURL1(this);" style="display: none;">
                                        </div>
                                        <a onclick="$('#preimg1').click();" class="m-2 mb-5 btn btn-success d-block mx-auto">เพิ่มหลักฐานการชำระเงิน</a>
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-primary" type="submit">ยืนยัน</button>
                                        </div>
                                    </form>
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

    <script>
        $(document).ready(function() {
            $('#contact').submit(function(event) {
                console.log('111');
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: 'check/insert_information.php',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response == 'success') {
                            Swal.fire({
                                title: 'สำเร็จ',
                                text: 'ส่งหลักฐานเรียบร้อย กำลังรอการตรวจสอบจากผู้ดูแลระบบ',
                                icon: 'success',
                                confirmButtonText: 'ตกลง',
                                confirmButtonColor: '#0d6efd'
                            }).then(function() {
                                location.reload();
                            });
                        }
                        if (response == 'fail') {
                            Swal.fire({
                                    title: 'เกิดข้อผิดพลาด',
                                    icon: 'error',
                                    confirmButtonText: 'ตกลง',
                                    confirmButtonColor: '#0d6efd'
                                })
                                .then(function() {
                                    location.reload();
                                });
                        }
                    },
                    error: function(error) {
                        console.log(error)
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
        });
    </script>
    <script type="text/javascript">
        function readURL1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showpic1').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

</body>

</html>