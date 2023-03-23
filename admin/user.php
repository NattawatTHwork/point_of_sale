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
$user_data->execute();
$row_user = $user_data->fetchAll(PDO::FETCH_ASSOC);

?>

<body id="page-top">
    <div id="wrapper">
        <?php include '../include/sidebar_admin.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include '../include/topbar.php'; ?>
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">สมาชิก</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> เพิ่มประเภท</a> -->
                        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#insert_type">
                            <i class="fas fa-download fa-sm text-white-50"></i> เพิ่มประเภท
                        </button> -->
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">ตารางรายชื่อสมาชิก</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="20%">ชื่อ</th>
                                            <th width="20%">นามสกุล</th>
                                            <th width="20%">อีเมล</th>
                                            <th width="20%">ชื่อร้านค้า</th>
                                            <th width="20%">สถานะ</th>
                                            <th width="10%">ตัวเลือก</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($row_user as $row) { ?>
                                            <tr>
                                                <td><?= $row['firstname'] ?></td>
                                                <td><?= $row['lastname'] ?></td>
                                                <td><?= $row['email'] ?></td>
                                                <td><?= $row['store'] ?></td>
                                                <?php if ($row['status'] == 0) { ?>
                                                    <td class="text-danger text-center">ใข้งานไม่ได้</td>
                                                <?php } else { ?>
                                                    <td class="text-success text-center">ใช้งานได้</td>
                                                <?php } ?>
                                                ?>
                                                <td class="text-center">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                            ตัวเลือก
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <button class="dropdown-item" type="button" onclick="get_user(<?= $row['user_id'] ?>)">ดูข้อมูล</button>
                                                            <button class="dropdown-item" type="button" onclick="edit_status(<?= $row['user_id'] ?>)">เปลี่ยนสถานะ</button>
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
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ข้อมูลผู้ใช้งาน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="firstname">ชื่อ</label>
                        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="ประเภท" disabled>
                    </div>
                    <div class="form-group">
                        <label for="lastname">นามสกุล</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="ประเภท" disabled>
                    </div>
                    <div class="form-group">
                        <label for="store">ชื่อร้านค้า</label>
                        <input type="text" class="form-control" name="store" id="store" placeholder="ประเภท" disabled>
                    </div>
                    <div class="form-floating">
                        <label for="description">รายละเอียด</label>
                        <textarea class="form-control" name="description" id="description" placeholder="รายละเอียด" style="height: 150px" disabled></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_status" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form id="edit_status_form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ข้อมูลผู้ใช้งาน</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" class="form-control" name="user_id" id="user_id_edit" placeholder="ประเภท">
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
                    $("#firstname").val(res.firstname);
                    $("#lastname").val(res.lastname);
                    $("#store").val(res.store);
                    $("#description").val(res.description);
                    $("#view_user").modal("show");
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