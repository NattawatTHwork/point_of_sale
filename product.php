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
$product_data = $connect->prepare("SELECT * FROM product INNER JOIN type ON product.type_id = type.type_id WHERE user_id = '$user_id' AND product.status = 1");
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
                        <h1 class="h3 mb-0 text-gray-800">Products</h1>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#insert_product">
                            <i class="fas fa-download fa-sm text-white-50"></i> เพิ่มเครื่องดื่ม
                        </button>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">ตารางเครื่องดื่ม</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="35%" class="text-center">ชื่อ</th>
                                            <th width="30%" class="text-center">ประเภท</th>
                                            <th width="15%" class="text-center">ราคา</th>
                                            <th width="10%" class="text-center">ตัวเลือก</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($row_product as $row) {
                                            $quantity = $connect->prepare("SELECT SUM(quantity) as quantity FROM record WHERE product_id = '" . $row['product_id'] . "'");
                                            $quantity->execute();
                                            $row_quantity = $quantity->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $row['name'] ?></td>
                                                <td class="text-center"><?= $row['type'] ?></td>
                                                <td class="text-center"><?= $row['price'] ?></td>
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
                            <button id="download_link" onClick="javascript:ExcelReport();" class="btn btn-primary float-right mt-3">
                                <i class="fas fa-download fa-sm text-white-50"></i> ดาวน์โหลดตาราง
                            </button>
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="insert_product_form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">เพิ่มเครื่องดื่ม</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="formGroupExampleInput">ชื่อเครื่องดื่ม</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="ชื่อเครื่องดื่ม" required>
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
                            <label for="formGroupExampleInput">รายละเอียด</label>
                            <textarea class="form-control" name="description" id="description" placeholder="รายละเอียด" style="height: 150px" required></textarea>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <img id="showpic" src="./img/add_image.png" class="rounded col-sm-12" onclick="document.getElementById('preimg').click();" style="cursor: pointer; width: 300px; display: block; margin: auto;">
                    </div>
                    <div class="text-center">
                        <input type="file" class="sr-only" id="preimg" name="preimg" accept="image/*" onchange="readURL(this);" style="display: none;">
                    </div>
                    <a onclick="$('#preimg').click();" class="m-2 mb-5 btn btn-primary d-block">เพิ่มรูปเครื่องดื่ม</a>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="edit_product_form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">แก้ไขเครื่องดื่ม</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" class="form-control" name="product_id" id="product_id_edit" placeholder="ประเภท">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="formGroupExampleInput">ชื่อเครื่องดื่ม</label>
                            <input type="text" class="form-control" name="name" id="name_edit" placeholder="ชื่อเครื่องดื่ม" required>
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
                            <label for="formGroupExampleInput">รายละเอียด</label>
                            <textarea class="form-control" name="description" id="description_edit" placeholder="รายละเอียด" style="height: 150px" required></textarea>
                        </div>
                        <div class="form-floating mb-3">
                            <img id="showpic1" src="./img/add_image.png" class="rounded col-sm-12" onclick="document.getElementById('preimg1').click();" style="cursor: pointer; width: 300px; display: block; margin: auto;">
                            <input type="hidden" name="img_path" id="img_path_edit" value="">
                        </div>
                        <div class="text-center">
                            <input type="file" class="sr-only" id="preimg1" name="preimg1" accept="image/*" onchange="readURL1(this);" style="display: none;">
                        </div>
                        <a onclick="$('#preimg1').click();" class="m-2 mb-5 btn btn-primary d-block">เพิ่มรูปเครื่องดื่ม</a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="original_img()">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/file-saver@1.3.3/FileSaver.js"></script>
    <script>
        function ExcelReport() //function สำหรับสร้าง ไฟล์ excel จากตาราง
        {
            var sheet_name = "excel_sheet"; /* กำหหนดชื่อ sheet ให้กับ excel โดยต้องไม่เกิน 31 ตัวอักษร */
            var elt = document.getElementById('dataTable'); /*กำหนดสร้างไฟล์ excel จาก table element ที่มี id ชื่อว่า myTable*/
            let originalTable = elt.cloneNode(true);
            let rows = elt.rows;
            for (let i = 0; i < rows.length; i++) {
                rows[i].deleteCell(-1);
            }

            /*------สร้างไฟล์ excel------*/
            var wb = XLSX.utils.table_to_book(elt, {
                sheet: sheet_name
            });
            XLSX.writeFile(wb, 'report.xlsx'); //Download ไฟล์ excel จากตาราง html โดยใช้ชื่อว่า report.xlsx

            elt.parentNode.replaceChild(originalTable, elt);
        }

        $(document).ready(function() {
            $('#insert_product_form').submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: 'check/insert_product.php',
                    method: 'POST',
                    data: formData,
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
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });

            $('#edit_product_form').submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: 'check/edit_product.php',
                    method: 'POST',
                    data: formData,
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
                    },
                    cache: false,
                    contentType: false,
                    processData: false
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
                    $("#description_edit").val(res.description);
                    $("#product_id_edit").val(res.product_id);
                    if (res.img_path != '') {
                        $("#showpic1").attr("src", "./img/" + res.img_path);
                    }
                    $("#img_path_edit").val(res.img_path);
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
                        confirmButtonColor: '#4e73df',
                        cancelButtonColor: '#e74a3b',
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

        function original_img() {
            $("#showpic1").attr("src", "./img/add_image.png");
        }
    </script>
    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showpic').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

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