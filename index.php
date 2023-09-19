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

$type = $connect->prepare("SELECT type.type_id, type, COUNT(*) as count FROM product INNER JOIN type ON product.type_id = type.type_id WHERE user_id = '$user_id' GROUP BY type.type_id, type ORDER BY type ASC");
$type->execute();
$row_type = $type->fetchAll(PDO::FETCH_ASSOC);

$qr_code = $connect->prepare("SELECT img_path FROM user WHERE user_id = '$user_id'");
$qr_code->execute();
$row_qr_code = $qr_code->fetch(PDO::FETCH_ASSOC);

$nextMonthDate = 0;
$todayDate = 0;
$member_count = $connect->prepare("SELECT * FROM member WHERE user_id = '$user_id'");
$member_count->execute();
$row_member_count = $member_count->fetchAll(PDO::FETCH_ASSOC);
$count = count($row_member_count);
if ($count > 1) {
    $date = $connect->prepare("SELECT * FROM member WHERE user_id = '$user_id' ORDER BY member_id DESC");
    $date->execute();
    $rows = $date->fetch(PDO::FETCH_ASSOC);

    $nextMonthDate = strtotime(date('Y-m-d', strtotime($rows['approve_date'] . ' +1 month')));
    $todayDate = strtotime(date('Y-m-d'));
    $finalDate = date('d-m-Y', strtotime($rows['approve_date'] . ' +1 month +5 days'));
}

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
                    <select id="typeSelector" class="form-control mb-3">
                        <option value="all">ทั้งหมด</option>
                        <?php foreach ($row_type as $type) { ?>
                            <option value="<?= $type['type_id'] ?>"><?= $type['type'] ?></option>
                        <?php } ?>
                    </select>
                    <form id="insert_record_form">
                        <div class="row">
                            <?php
                            $i = 0;
                            foreach ($row_product as $row) {
                            ?>
                                    <div class="card text-center m-3" data-type="<?= $row['type_id'] ?>" style="width: 200px; height: 300px;">
                                        <div class="m-5" style="height: 50px; display: flex; justify-content: center; align-items: center;">
                                            <img class="card-img-top" src="./img/<?= $row['img_path'] != '' ? $row['img_path']  : 'no_image.jpg' ?>" alt="Card image cap" style="max-height: 200px; object-fit: contain; border-radius: 5%;">
                                        </div>
                                        <div class="card-body">
                                            <h4 class="card-title font-weight-bold" id="name<?= $i += 1 ?>" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= $row['name'] ?></h4>
                                            <h5 class="card-text" id="net_price<?= $i ?>"><?= $row['price'] ?> บาท</h5>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-dark" onclick="decreaseQuantity<?= $i ?>()">-</button>
                                                </div>
                                                <input type="hidden" name="price<?= $i ?>" id="price<?= $i ?>" value="<?= $row['price'] ?>" class="form-control">
                                                <input type="hidden" name="product_id<?= $i ?>" id="product_id<?= $i ?>" value="<?= $row['product_id'] ?>" class="form-control">
                                                <input type="number" name="quantity<?= $i ?>" id="quantity<?= $i ?>" value="0" class="form-control" style="padding: 0px; font-size: 20px; text-align: center;">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-primary" onclick="increaseQuantity<?= $i ?>()">+</button>
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
                            <div class="d-flex justify-content-center align-items-center mb-4">
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

    <div class="modal fade" id="popupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" class="form-control" name="product_id" id="product_id_edit" placeholder="ประเภท">
                <div class="modal-body">
                    <h5 class="text-center">การใช้งานของคุณหมดแล้ว<br>กรุณาชำระค่าบริการก่อน <?= $finalDate ?></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <a class="btn btn-primary" href="subscribe.php">ยืนยัน</a>
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
                tableCode += '<thead><tr><th>ชื่อเครื่องดื่ม</th><th>จำนวน</th><th>ราคา</th></tr></thead>';
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
                        confirmButtonColor: '#4e73df',
                        cancelButtonColor: '#4e73df',
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
                                confirmButtonColor: '#4e73df',
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
                                            if (response != 'fail') {
                                                Swal.fire({
                                                    title: 'คุณต้องการพิมพ์ใบเสร็จไหม',
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#4e73df',
                                                    cancelButtonColor: '#e74a3b',
                                                    confirmButtonText: 'พิมพ์',
                                                    cancelButtonText: 'ยกเลิก'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        window.location.href = "/detail.php?no_receipt=" + response;
                                                    } else {
                                                        location.reload();
                                                    }
                                                })
                                                // Swal.fire({
                                                //     title: 'สำเร็จ',
                                                //     icon: 'success',
                                                //     confirmButtonText: 'ตกลง',
                                                //     confirmButtonColor: '#4e73df'
                                                // })
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
                                            if (response != 'fail') {
                                                Swal.fire({
                                                    title: 'คุณต้องการพิมพ์ใบเสร็จไหม',
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#4e73df',
                                                    cancelButtonColor: '#e74a3b',
                                                    confirmButtonText: 'พิมพ์',
                                                    cancelButtonText: 'ยกเลิก'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        window.location.href = "/detail.php?no_receipt=" + response;
                                                    } else {
                                                        location.reload();
                                                    }
                                                })
                                                // Swal.fire({
                                                //     title: 'สำเร็จ',
                                                //     icon: 'success',
                                                //     confirmButtonText: 'ตกลง',
                                                //     confirmButtonColor: '#4e73df'
                                                // })
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

            if ((<?= $nextMonthDate ?> < <?= $todayDate ?>) && (<?= $count ?> > 1)) {
                $("#popupModal").modal("show");
            }

            // เมื่อมีการเปลี่ยนแปลงในเลือกประเภท
            document.getElementById("typeSelector").addEventListener("change", function() {
                var selectedType = this.value; // ค่าประเภทที่ถูกเลือก
                var cards = document.querySelectorAll(".card"); // เลือกทุก card

                cards.forEach(function(card) {
                    var cardType = card.getAttribute("data-type"); // ประเภทของ card
                    if (selectedType === "all" || cardType === selectedType) {
                        card.style.display = "block"; // แสดง card ที่ตรงเงื่อนไข
                    } else {
                        card.style.display = "none"; // ซ่อน card ที่ไม่ตรงเงื่อนไข
                    }
                });
            });

        });
    </script>

</body>

</html>