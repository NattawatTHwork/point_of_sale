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
$product_data = $connect->prepare("SELECT * FROM product INNER JOIN type ON product.type_id = type.type_id WHERE user_id = '$user_id'");
$product_data->execute();
$row_product = $product_data->fetchAll(PDO::FETCH_ASSOC);

$qr_code = $connect->prepare("SELECT img_path FROM user WHERE user_id = '$user_id'");
$qr_code->execute();
$row_qr_code = $qr_code->fetch(PDO::FETCH_ASSOC);
?>

<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<body id="page-top">
    <div id="wrapper">
        <?php include 'include/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'include/topbar.php'; ?>
                <div class="container-fluid">
                    <form id="insert_record_form">
                        <div class="row">
                            <?php
                            $i = 0;
                            foreach ($row_product as $row) {
                            ?>
                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 text-center mb-3">
                                    <div class="card">
                                        <div style="height: 200px; display: flex; justify-content: center; align-items: center;">
                                            <img class="card-img-top" src="./img/<?= $row['img_path'] != '' ? $row['img_path']  : 'no_image.jpg' ?>" alt="Card image cap" style="max-height: 100%; max-width: 100%; border-radius: 5%;">
                                        </div>
                                        <div class="card-body">
                                            <h4 class="card-title font-weight-bold" id="name<?= $i += 1 ?>"><?= $row['name'] ?></h4>
                                            <h5 class="card-text" id="net_price<?= $i ?>"><?= $row['price'] - $row['discount'] ?> บาท</h5>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-dark" onclick="decreaseQuantity<?= $i ?>()">-</button>
                                                </div>
                                                <input type="hidden" name="price<?= $i ?>" id="price<?= $i ?>" value="<?= $row['price'] - $row['discount'] ?>" class="form-control">
                                                <input type="hidden" name="product_id<?= $i ?>" id="product_id<?= $i ?>" value="<?= $row['product_id'] ?>" class="form-control">
                                                <input type="number" name="quantity<?= $i ?>" id="quantity<?= $i ?>" value="0" class="form-control" style="padding: 0px; font-size: 20px; text-align: center;">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-primary" onclick="increaseQuantity<?= $i ?>()">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            <input type="hidden" name="count" id="count" value="<?= $i ?>" class="form-control">
                        </div>
                        <?php
                        if ($product_data->rowCount() > 0) {
                        ?>
                            <div class="d-flex justify-content-center align-items-center">
                                <button class="btn btn-primary" type="button" onclick="pre_confirm()">ยืนยัน</button>
                            </div>
                        <?php
                        }
                        ?>
                    </form>
                </div>
            </div>
            <?php include 'include/footer.php'; ?>
        </div>
    </div>
    <?php include 'include/scroll.php'; ?>
    <?php include 'include/modal.php'; ?>
    <?php include 'include/js.php'; ?>

    <!-- Modal -->
    <div class="modal fade" id="pre_confirm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">รายการสั่งซื้อ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" class="form-control" name="product_id" id="product_id_edit" placeholder="ประเภท">
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary" onclick="submitConfirmForm()">ยืนยัน</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function pre_confirm() {
            var count = parseInt(document.getElementById('count').value);
            var tableHTML = '';
            var total_price = 0;

            for (var i = 1; i <= count; i++) {
                var quantity = parseInt(document.getElementById('quantity' + i).value);
                if (quantity > 0) {
                    name = document.getElementById('name' + i).innerHTML;
                    net_price = document.getElementById('price' + i).value;
                    quantity = document.getElementById('quantity' + i).value;
                    total_price += (net_price * quantity);

                    tableHTML += '<tr>';
                    tableHTML += '<td>' + name + '</td>';
                    tableHTML += '<td>' + quantity + '</td>';
                    tableHTML += '<td>' + net_price + '</td>';
                    tableHTML += '</tr>';
                }
            }

            if (tableHTML !== '') {
                var tableCode = '<table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">';
                tableCode += '<thead><tr><th>ชื่อสินค้า</th><th>จำนวน</th><th>ราคา</th></tr></thead>';
                tableCode += '<tbody>' + tableHTML + '</tbody>';
                tableCode += '<tfoot><tr><th colspan="2">ราคารวม</th><th>' + total_price + '</th></tr></tfoot>';
                tableCode += '</table>';

                var modal = document.getElementById('pre_confirm');
                modal.querySelector('.modal-body').innerHTML = tableCode;

                $("#pre_confirm").modal("show");
            }
        }

        function submitConfirmForm() {
            $('#pre_confirm').modal('hide');
            $('#insert_record_form').submit();
        }

        <?php $i = 0;
        foreach ($row_product as $row) { ?>

            function increaseQuantity<?= $i += 1 ?>() {
                var quantity<?= $i ?> = parseInt(document.getElementById('quantity<?= $i ?>').value);
                quantity<?= $i ?> = isNaN(quantity<?= $i ?>) ? 1 : quantity<?= $i ?>;
                quantity<?= $i ?>++;
                document.getElementById('quantity<?= $i ?>').value = quantity<?= $i ?>;
            }

            function decreaseQuantity<?= $i ?>() {
                var quantity<?= $i ?> = parseInt(document.getElementById('quantity<?= $i ?>').value);
                quantity<?= $i ?> = isNaN(quantity<?= $i ?>) ? 1 : quantity<?= $i ?>;
                quantity<?= $i ?> = quantity<?= $i ?> <= 1 ? 0 : quantity<?= $i ?> - 1;
                document.getElementById('quantity<?= $i ?>').value = quantity<?= $i ?>;
            }
        <?php } ?>

        $(document).ready(function() {
            $('#insert_record_form').submit(function(event) {
                event.preventDefault();
                var check = 0;
                const formData = new FormData(event.target);
                const count = formData.get('count');
                for (let i = 1; i <= count; i++) {
                    const quantity = formData.get('quantity' + i);
                    if (quantity > 0) {
                        check = 1;
                    }
                }
                if (check == 1) {
                    Swal.fire({
                        title: 'เลือกวิธีชำระเงิน',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'พร้อมเพย์',
                        cancelButtonText: 'เงินสด',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'พร้อมเพย์',
                                text: 'เมื่อชำระเงินเสร็จแล้วกรุณาแสดงต่อพนักงาน',
                                imageUrl: './img/' + '<?= $row_qr_code['img_path'] ?>',
                                imageWidth: 300,
                                imageAlt: 'Custom image',
                                showCancelButton: true,
                                confirmButtonText: 'เสร็จสิ้น',
                                cancelButtonText: 'ยกเลิก',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var data = $(this).serialize();
                                    data += '&method=1';
                                    $.ajax({
                                        url: 'check/insert_payment.php',
                                        method: 'POST',
                                        data: data,
                                        success: function(response) {
                                            console.log(response)
                                            if (response == 'success') {
                                                Swal.fire({
                                                        title: 'สำเร็จ',
                                                        icon: 'success',
                                                        confirmButtonText: 'ตกลง',
                                                        confirmButtonColor: '#4e73df'
                                                    })
                                                    .then(function() {
                                                        location.reload();
                                                    });
                                            }
                                            if (response == 'fail') {
                                                Swal.fire({
                                                        title: 'เกิดข้อผิดพลาด',
                                                        icon: 'error',
                                                        confirmButtonText: 'ตกลง',
                                                        confirmButtonColor: '#4e73df'
                                                    })
                                                    .then(function() {
                                                        location.reload();
                                                    });
                                            }
                                        }
                                    })
                                }
                            })
                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            var cash_data = $(this).serialize();
                            Swal.fire({
                                    title: 'สำเร็จ',
                                    icon: 'success',
                                    confirmButtonText: 'ตกลง',
                                    confirmButtonColor: '#4e73df'
                                })
                                .then(function() {
                                    var data = cash_data;
                                    data += '&method=0';
                                    $.ajax({
                                        url: 'check/insert_payment.php',
                                        method: 'POST',
                                        data: data,
                                        success: function(response) {
                                            if (response == 'success') {
                                                location.reload();
                                            }
                                            if (response == 'fail') {
                                                Swal.fire({
                                                        title: 'เกิดข้อผิดพลาด',
                                                        icon: 'error',
                                                        confirmButtonText: 'ตกลง',
                                                        confirmButtonColor: '#4e73df'
                                                    })
                                                    .then(function() {
                                                        location.reload();
                                                    });
                                            }
                                        }
                                    })
                                });
                        }
                    })
                }
            });
        });
    </script>
</body>

</html>