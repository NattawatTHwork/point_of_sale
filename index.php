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
?>

<body id="page-top">
    <div id="wrapper">
        <?php include 'include/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'include/topbar.php'; ?>
                <div class="container-fluid">
                    <form id="insert_record_form">
                        <div class="row">
                            <?php $i = 0;
                            foreach ($row_product as $row) { ?>
                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 text-center mb-3">
                                    <div class="card">
                                        <!-- <img class="card-img-top" src="image.jpg" alt="Card image cap"> -->
                                        <div class="card-body">
                                            <h5 class="card-title"><?= $row['name'] ?></h5>
                                            <h5 class="card-text"><?= $row['price'] - $row['discount'] ?> บาท</h5>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-outline-danger" onclick="decreaseQuantity<?= $i += 1 ?>()">-</button>
                                                </div>
                                                <input type="hidden" name="price<?= $i ?>" id="price<?= $i ?>" value="<?= $row['price'] - $row['discount'] ?>" class="form-control">
                                                <input type="hidden" name="product_id<?= $i ?>" id="product_id<?= $i ?>" value="<?= $row['product_id'] ?>" class="form-control">
                                                <input type="number" name="quantity<?= $i ?>" id="quantity<?= $i ?>" value="0" class="form-control" style="padding: 0px; font-size: 20px; text-align: center;">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-success" onclick="increaseQuantity<?= $i ?>()">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <input type="hidden" name="count" id="count" value="<?= $i ?>" class="form-control">
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <button type="submit" class="btn btn-primary">ยืนยัน</button>
                        </div>
                    </form>
                </div>
            </div>
            <?php include 'include/footer.php'; ?>
        </div>
    </div>
    <?php include 'include/scroll.php'; ?>
    <?php include 'include/modal.php'; ?>
    <?php include 'include/js.php'; ?>

    <script>
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
                // console.log(formData)
                for (let i = 1; i <= count; i++) {
                    const quantity = formData.get('quantity' + i);
                    if (quantity > 0) {
                        check = 1;
                    }
                }
                if (check == 1) {
                    Swal.fire({
                        title: 'ยืนยันการสั่งซื้อ',
                        // text: "You won't be able to revert this!",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ยืนยัน',
                        cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: 'check/insert_record.php',
                                method: 'POST',
                                data: $(this).serialize(),
                                success: function(response) {
                                    let res = JSON.parse(response);
                                    if (res.success == 'success') {
                                        Swal.fire({
                                            title: 'เลือกวิธีชำระเงิน',
                                            icon: 'question',
                                            showCancelButton: true,
                                            confirmButtonText: 'QR Code',
                                            cancelButtonText: 'เงินสด',
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                Swal.fire({
                                                    title: 'QR Code',
                                                    text: 'เมื่อชำระเงินเสร็จแล้วกรุณาแสดงต่อพนักงาน',
                                                    imageUrl: 'https://unsplash.it/400/200',
                                                    imageWidth: 400,
                                                    imageHeight: 200,
                                                    imageAlt: 'Custom image',
                                                    showCancelButton: true,
                                                    confirmButtonText: 'เสร็จสิ้น',
                                                    cancelButtonText: 'ยกเลิก',
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        $.ajax({
                                                            url: 'check/insert_payment.php',
                                                            method: 'POST',
                                                            data: {
                                                                no_receipt: res.no_receipt,
                                                                method: 1
                                                            },
                                                            success: function(response) {
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
                                                Swal.fire({
                                                        title: 'สำเร็จ',
                                                        icon: 'success',
                                                        confirmButtonText: 'ตกลง',
                                                        confirmButtonColor: '#4e73df'
                                                    })
                                                    .then(function() {
                                                        $.ajax({
                                                            url: 'check/insert_payment.php',
                                                            method: 'POST',
                                                            data: {
                                                                no_receipt: res.no_receipt,
                                                                method: 0
                                                            },
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
                                                // $.ajax({
                                                //     url: 'check/insert_payment.php',
                                                //     method: 'POST',
                                                //     data: {
                                                //         no_receipt: res.no_receipt,
                                                //         method: 0
                                                //     },
                                                //     success: function(response) {
                                                //         if (response == 'success') {
                                                //             Swal.fire({
                                                //                     title: 'สำเร็จ',
                                                //                     icon: 'success',
                                                //                     confirmButtonText: 'ตกลง',
                                                //                     confirmButtonColor: '#4e73df'
                                                //                 })
                                                //                 .then(function() {
                                                //                     location.reload();
                                                //                 });
                                                //         }
                                                //         if (response == 'fail') {
                                                //             Swal.fire({
                                                //                     title: 'เกิดข้อผิดพลาด',
                                                //                     icon: 'error',
                                                //                     confirmButtonText: 'ตกลง',
                                                //                     confirmButtonColor: '#4e73df'
                                                //                 })
                                                //                 .then(function() {
                                                //                     location.reload();
                                                //                 });
                                                //         }
                                                //     }
                                                // })
                                            }
                                        })
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
                                },
                                error: function(error) {
                                    console.log(error)
                                }
                            });
                        }
                    })
                }
            });
        });
    </script>
</body>

</html>