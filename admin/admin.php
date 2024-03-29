<!DOCTYPE html>
<html lang="en">

<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("location: login.php");
}
require '../include/connect.php';
include '../include/header.php';

$user_data = $connect->prepare("SELECT * FROM admin");
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
                        <h1 class="h3 mb-0 text-gray-800">Admins</h1>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">ตารางรายชื่อผู้ดูแลระบบ</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="text-center">
                                        <tr>
                                            <th width="20%">ชื่อ</th>
                                            <th width="20%">นามสกุล</th>
                                            <th width="30%">อีเมล</th>
                                            <th width="20%">สถานะ</th>
                                            <th width="10%">ตัวเลือก</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php foreach ($row_user as $row) { ?>
                                            <tr>
                                                <td><?= $row['firstname'] ?></td>
                                                <td><?= $row['lastname'] ?></td>
                                                <td><?= $row['email'] ?></td>
                                                <?php if ($row['status'] == 0) { ?>
                                                    <td class="text-danger">ใข้งานไม่ได้</td>
                                                <?php } else { ?>
                                                    <td class="text-success">ใช้งานได้</td>
                                                <?php } ?>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                            ตัวเลือก
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <button class="dropdown-item" type="button" onclick="get_admin(<?= $row['admin_id'] ?>)">ดูข้อมูล</button>
                                                            <button class="dropdown-item" type="button" onclick="edit_status(<?= $row['admin_id'] ?>)">เปลี่ยนสถานะ</button>
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
    <div class="modal fade" id="view_admin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ข้อมูลผู้ดูแลระบบ</h5>
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
                        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="lastname">นามสกุล</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="" disabled>
                    </div>
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
                        <h5 class="modal-title" id="exampleModalLabel">ข้อมูลผู้ดูแลระบบ</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" class="form-control" name="admin_id" id="admin_id_edit">
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
                    url: 'check/edit_admin.php',
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

        function get_admin(admin_id) {
            $.ajax({
                url: 'check/get_admin.php',
                type: "POST",
                data: {
                    admin_id: admin_id
                },
                success: function(response) {
                    let res = JSON.parse(response);
                    for (let key in res) {
                        if (res[key] === null) {
                            res[key] = "";
                        }
                    }
                    $("#email").val(res.email);
                    $("#password").val(res.password_view);
                    $("#firstname").val(res.firstname);
                    $("#lastname").val(res.lastname);
                    $("#view_admin").modal("show");
                }
            });
        }

        function edit_status(admin_id) {
            $.ajax({
                url: 'check/get_admin.php',
                type: "POST",
                data: {
                    admin_id: admin_id
                },
                success: function(response) {
                    let res = JSON.parse(response);
                    $('#status option[value="' + res.status + '"]').prop('selected', true);
                    $("#admin_id_edit").val(admin_id);
                    $("#edit_status").modal("show");
                }
            });
        }
    </script>
</body>

</html>