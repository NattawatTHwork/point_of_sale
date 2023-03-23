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


$type_data = $connect->prepare("SELECT * FROM type");
$type_data->execute();
$row_type = $type_data->fetchAll(PDO::FETCH_ASSOC);
?>

<body id="page-top">
    <div id="wrapper">
        <?php include 'include/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'include/topbar.php'; ?>
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">สินค้า</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> เพิ่มประเภท</a> -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#insert_product">
                            <i class="fas fa-download fa-sm text-white-50"></i> เพิ่มสินค้า
                        </button>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">ตารางสินค้า</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="35%">ชื่อ</th>
                                            <th width="30%">ประเภท</th>
                                            <th width="15%">ราคา</th>
                                            <th width="10%">จำนวน</th>
                                            <th width="10%">ตัวเลือก</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($row_product as $row) { ?>
                                            <tr>
                                                <td><?= $row['name'] ?></td>
                                                <td><?= $row['type'] ?></td>
                                                <td><?= $row['price'] - $row['discount'] ?></td>
                                                <td></td>
                                                <td class="text-center">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                            ตัวเลือก
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <button class="dropdown-item" type="button" onclick="get_product(<?= $row['product_id'] ?>)">แก้ไข</button>
                                                            <button class="dropdown-item" type="button" onclick="delete_product(<?= $row['product_id'] ?>)">ลบ</button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
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

    <!-- Modal -->
    <div class="modal fade" id="insert_product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form id="insert_product_form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">เพิ่มสินค้า</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- <input type="hidden" class="form-control" name="user_id" id="user_id" placeholder="ชื่อสินค้า" value="<?= $_SESSION['user_id'] ?>" required> -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="formGroupExampleInput">ชื่อสินค้า</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="ชื่อสินค้า" required>
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput">ประเภท</label>
                            <select class="form-control" name="type_id" id="type_id">
                                <?php foreach ($row_type as $row) { ?>
                                    <option value="<?= $row['type_id'] ?>"><?= $row['type'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput">ราคาขาย</label>
                            <input type="text" class="form-control" name="price" id="price" placeholder="ราคาขาย" required>
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput">ส่วนลด</label>
                            <input type="text" class="form-control" name="discount" id="discount" placeholder="ส่วนลด" required>
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput">รายละเอียด</label>
                            <textarea class="form-control" name="description" id="description" placeholder="รายละเอียด" style="height: 150px" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form id="edit_product_form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">เพิ่มประเภท</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" class="form-control" name="product_id" id="product_id_edit" placeholder="ประเภท">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="formGroupExampleInput">ชื่อสินค้า</label>
                            <input type="text" class="form-control" name="name" id="name_edit" placeholder="ชื่อสินค้า" required>
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput">ประเภท</label>
                            <select class="form-control" name="type_id" id="type_id_edit">
                                <?php foreach ($row_type as $row) { ?>
                                    <option value="<?= $row['type_id'] ?>"><?= $row['type'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput">ราคาขาย</label>
                            <input type="text" class="form-control" name="price" id="price_edit" placeholder="ราคาขาย" required>
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput">ส่วนลด</label>
                            <input type="text" class="form-control" name="discount" id="discount_edit" placeholder="ส่วนลด" required>
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput">รายละเอียด</label>
                            <textarea class="form-control" name="description" id="description_edit" placeholder="รายละเอียด" style="height: 150px" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#insert_product_form').submit(function(event) {
                console.log($(this).serialize())
                event.preventDefault();
                $.ajax({
                    url: 'check/insert_product.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        console.log(response)
                        if (response == 'success') {
                            Swal.fire({
                                title: 'สำเร็จ',
                                icon: 'success',
                                confirmButtonText: 'ตกลง',
                                confirmButtonColor: '#4e73df'
                            }).then(function() {
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
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            });

            $('#edit_product_form').submit(function(event) {
                console.log($(this).serialize())
                event.preventDefault();
                $.ajax({
                    url: 'check/edit_product.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        console.log(response)
                        if (response == 'success') {
                            Swal.fire({
                                title: 'สำเร็จ',
                                icon: 'success',
                                confirmButtonText: 'ตกลง',
                                confirmButtonColor: '#4e73df'
                            }).then(function() {
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
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            });
        });

        function get_product(product_id) {
            $.ajax({
                url: 'check/get_product.php',
                type: "POST",
                data: {
                    product_id: product_id
                },
                success: function(response) {
                    let res = JSON.parse(response);
                    $("#name_edit").val(res.name);
                    $('#type_id_edit option[value="' + res.type_id + '"]').prop('selected', true);
                    $("#price_edit").val(res.price);
                    $("#discount_edit").val(res.discount);
                    $("#description_edit").val(res.description);
                    $("#product_id_edit").val(res.product_id);
                    $("#edit_product").modal("show");
                }
            });
        }

        function delete_product(product_id) {
            $.ajax({
                url: 'check/get_product.php',
                type: "POST",
                data: {
                    product_id: product_id
                },
                success: function(response) {
                    let res = JSON.parse(response);
                    Swal.fire({
                        title: res.name,
                        text: 'คุณต้องการลบใช่ไหม',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ลบ',
                        cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: 'check/delete_product.php',
                                method: 'POST',
                                data: {
                                    product_id: product_id
                                },
                                success: function(response) {
                                    if (response == 'success') {
                                        Swal.fire({
                                            title: 'สำเร็จ',
                                            icon: 'success',
                                            confirmButtonText: 'ตกลง',
                                            confirmButtonColor: '#4e73df'
                                        }).then(function() {
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
                                },
                                error: function(error) {
                                    console.log(error)
                                }
                            });
                        }
                    })
                }
            });
        }
    </script>
</body>

</html>