<!DOCTYPE html>
<html lang="en">

<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("location: login.php");
}
require '../include/connect.php';
include '../include/header.php';

$user_data = $connect->prepare("SELECT * FROM user");
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'active' || $_GET['status'] == 'inactive') {
        if ($_GET['status'] == 'active') {
            $status = 1;
        } else {
            $status = 0;
        }
        $user_data = $connect->prepare("SELECT * FROM user WHERE status = '$status'");
    }

    if ($_GET['status'] == 'member' || $_GET['status'] == 'trial' || $_GET['status'] == 'wait') {
        if ($_GET['status'] == 'member') {
            $user_data = $connect->prepare("SELECT *, COUNT(*) as count FROM member INNER JOIN user ON member.user_id = user.user_id GROUP BY member.user_id HAVING count > 1");
        } elseif ($_GET['status'] == 'trial') {
            $user_data = $connect->prepare("SELECT *, COUNT(*) as count FROM member INNER JOIN user ON member.user_id = user.user_id GROUP BY member.user_id HAVING count = 1");
        } elseif ($_GET['status'] == 'wait') {
            $user_data = $connect->prepare("SELECT * FROM user WHERE user_id NOT IN (SELECT user_id FROM member)");
        }
    }
}
$user_data->execute();
$row_user = $user_data->fetchAll(PDO::FETCH_ASSOC);
// echo '<pre>';
// print_r($row_user);
// echo '</pre>';

?>

<body id="page-top">
    <div id="wrapper">
        <?php include '../include/sidebar_admin.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include '../include/topbar.php'; ?>
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Users</h1>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                ตารางรายชื่อ
                                <?php
                                if (isset($_GET['status'])) {
                                    if ($_GET['status'] == 'member') {
                                        echo 'สมาชิก';
                                    } elseif ($_GET['status'] == 'trial') {
                                        echo 'ทดลองใช้งาน';
                                    } elseif ($_GET['status'] == 'wait') {
                                        echo 'รอการอนุมัติ';
                                    }
                                }
                                ?>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="text-center">
                                        <tr>
                                            <th width="20%">ชื่อ</th>
                                            <th width="20%">นามสกุล</th>
                                            <th width="20%">อีเมล</th>
                                            <th width="20%">ชื่อร้านค้า</th>
                                            <th width="10%">สถานะ</th>
                                            <th width="10%">ตัวเลือก</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php foreach ($row_user as $row) { ?>
                                            <tr>
                                                <td><?= $row['firstname'] ?></td>
                                                <td><?= $row['lastname'] ?></td>
                                                <td><?= $row['email'] ?></td>
                                                <td><?= $row['store'] ?></td>
                                                <?php if ($row['status'] == 0) { ?>
                                                    <td class="text-danger">ปิดใช้งาน</td>
                                                <?php } else { ?>
                                                    <td class="text-success">เปิดใช้งาน</td>
                                                <?php } ?>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                            ตัวเลือก
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <button class="dropdown-item" type="button" onclick="get_user(<?= $row['user_id'] ?>)">ดูข้อมูล</button>
                                                            <button class="dropdown-item" type="button" onclick="get_product(<?= $row['user_id'] ?>)">ดูสินค้า</button>
                                                            <!-- <button class="dropdown-item" type="button" onclick="edit_status(<?= $row['user_id'] ?>)">เปลี่ยนสถานะ</button> -->
                                                            <a class="dropdown-item" type="button" href="manage_user.php?user_id=<?= $row['user_id'] ?>">ประวัติการใช้บริการ</a>
                                                            <a class="dropdown-item" type="button" href="report_payment_date.php?user_id=<?= $row['user_id'] ?>">รายงานยรายวัน</a>
                                                            <a class="dropdown-item" type="button" href="report_payment_month.php?user_id=<?= $row['user_id'] ?>">รายงานรายเดือน</a>
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
            <?php include '../include/footer.php'; ?>
        </div>
    </div>
    <?php include '../include/scroll.php'; ?>
    <?php include '../include/modal.php'; ?>
    <?php include '../include/js.php'; ?>

    <!-- Modal -->
    <div class="modal fade" id="view_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ข้อมูลผู้ใช้งาน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="email">อีเมล</label>
                        <input type="text" class="form-control" name="email" id="email" disabled>
                    </div>
                    <div class="form-group">
                        <label for="password">รหัสผ่าน</label>
                        <input type="text" class="form-control" name="password" id="password" disabled>
                    </div>
                    <div class="form-group">
                        <label for="firstname">ชื่อ</label>
                        <input type="text" class="form-control" name="firstname" id="firstname" disabled>
                    </div>
                    <div class="form-group">
                        <label for="lastname">นามสกุล</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" disabled>
                    </div>
                    <div class="form-group">
                        <label for="id_number">หมายเลขบัตรประชาชน</label>
                        <input type="text" class="form-control" name="id_number" id="id_number" disabled>
                    </div>
                    <div class="form-group">
                        <label for="phone">เบอร์โทร</label>
                        <input type="text" class="form-control" name="phone" id="phone" disabled>
                    </div>
                    <div class="form-group">
                        <label for="line">ไลน์</label>
                        <input type="text" class="form-control" name="line" id="line" disabled>
                    </div>
                    <div class="form-group">
                        <label for="address">ที่อยู่</label>
                        <input type="text" class="form-control" name="address" id="address" disabled>
                    </div>
                    <div class="form-group">
                        <label for="store">ชื่อร้านค้า</label>
                        <input type="text" class="form-control" name="store" id="store" disabled>
                    </div>
                    <div class="form-group">
                        <label for="description">รายละเอียด</label>
                        <textarea class="form-control" name="description" id="description" placeholder="รายละเอียด" style="height: 150px" disabled></textarea>
                    </div>
                    <div class="form-group">
                        <label for="description">QR Code</label><br>
                        <img src="" name="img_path" id="img_path" class="mx-auto d-block" width="400">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="view_product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ข้อมูลสินค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_status" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="edit_status_form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ข้อมูลผู้ใช้งาน</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" class="form-control" name="user_id" id="user_id_edit">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="status">สถานะ</label>
                            <select class="form-control" name="status" id="status">
                                <option value="1">เปิด</option>
                                <option value="0">ปิด</option>
                            </select>
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
            $('#edit_status_form').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: 'check/edit_user.php',
                    method: 'POST',
                    data: $(this).serialize(),
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
            });
        });

        function get_user(user_id) {
            $.ajax({
                url: 'check/get_user.php',
                type: "POST",
                data: {
                    user_id: user_id
                },
                success: function(response) {
                    let res = JSON.parse(response);
                    if (res.id_number) {
                        var idNumber = res.id_number;
                        var formattedIDNumber = idNumber.slice(0, 1) + '-' + idNumber.slice(1, 5) + '-' + idNumber.slice(5, 10) + '-' + idNumber.slice(10, 12) + '-' + idNumber.slice(12);
                    }
                    if (res.phone) {
                        var phone = res.phone;
                        var formattedPhone = phone.slice(0, 2) + '-' + phone.slice(2, 6) + '-' + phone.slice(6);
                    }

                    var img = document.getElementById('img_path');
                    if (res.img_path.length === 0) {
                        img.setAttribute("src", '../img/no_image.jpg');
                    } else {
                        img.setAttribute("src", '../img/' + res.img_path);
                    }
                    $("#email").val(res.email);
                    $("#password").val(res.password_view);
                    $("#firstname").val(res.firstname);
                    $("#lastname").val(res.lastname);
                    $("#id_number").val(formattedIDNumber);
                    $("#phone").val(formattedPhone);
                    $("#line").val(res.line);
                    $("#address").val(res.address);
                    $("#store").val(res.store);
                    $("#description").val(res.description);
                    $("#view_user").modal("show");
                }
            });
        }

        function get_product(user_id) {
            $.ajax({
                url: 'check/get_product.php',
                type: "POST",
                data: {
                    user_id: user_id
                },
                success: function(response) {
                    let res = JSON.parse(response);

                    // Build table
                    let table = $('<table>').addClass('table text-center'); // Add 'text-center' class to center-align the text
                    let thead = $('<thead>');
                    let tbody = $('<tbody>');

                    // Create table header
                    let headerRow = $('<tr>');
                    headerRow.append($('<th>').text('ลำดับ'));
                    headerRow.append($('<th>').text('สินค้า'));
                    headerRow.append($('<th>').text('ราคาขาย'));
                    thead.append(headerRow);
                    table.append(thead);

                    // Create table rows
                    if (res.length === 0) {
                        let noProductRow = $('<tr>');
                        let noProductCell = $('<td colspan="3">').text('ไม่มีสินค้า');
                        noProductRow.append(noProductCell);
                        tbody.append(noProductRow);
                    } else {
                        var i = 1;
                        res.forEach(function(rowData) {
                            let row = $('<tr>');
                            row.append($('<td>').text(i++));
                            row.append($('<td>').text(rowData.name));
                            let priceMinusDiscount = parseFloat(rowData.price) - parseFloat(rowData.discount);
                            row.append($('<td>').text(priceMinusDiscount));
                            tbody.append(row);
                        });
                    }
                    table.append(tbody);

                    // Clear modal body and add the table
                    $('#view_product .modal-body').empty().append(table);

                    // Show the modal
                    $("#view_product").modal("show");
                }
            });
        }

        function edit_status(user_id) {
            $.ajax({
                url: 'check/get_user.php',
                type: "POST",
                data: {
                    user_id: user_id
                },
                success: function(response) {
                    let res = JSON.parse(response);
                    $('#status option[value="' + res.status + '"]').prop('selected', true);
                    $("#user_id_edit").val(user_id);
                    $("#edit_status").modal("show");
                }
            });
        }
    </script>
</body>

</html>