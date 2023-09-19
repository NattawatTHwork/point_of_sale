<!DOCTYPE html>
<html lang="en">

<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("location: login.php");
}
require '../include/connect.php';
include '../include/header.php';

$type_data = $connect->prepare("SELECT * FROM type");
$type_data->execute();
$row_type = $type_data->fetchAll(PDO::FETCH_ASSOC);

?>

<body id="page-top">
    <div id="wrapper">
        <?php include '../include/sidebar_admin.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include '../include/topbar.php'; ?>
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Types</h1>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#insert_type">
                            <i class="fas fa-download fa-sm text-white-50"></i> เพิ่มประเภท
                        </button>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">ตารางประเภท</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="text-center">
                                        <tr>
                                            <th width="80%">ประเภท</th>
                                            <th width="20%">ตัวเลือก</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($row_type as $row) { ?>
                                            <tr>
                                                <td><?= $row['type'] ?></td>
                                                <td class="text-center">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                            ตัวเลือก
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <button class="dropdown-item" type="button" onclick="get_type(<?= $row['type_id'] ?>)">แก้ไข</button>
                                                            <button class="dropdown-item" type="button" onclick="delete_type(<?= $row['type_id'] ?>)">ลบ</button>
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
    <div class="modal fade" id="insert_type" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="insert_type_form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">เพิ่มประเภท</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="formGroupExampleInput">ชื่อประเภท</label>
                            <input type="text" class="form-control" name="type" id="type" placeholder="ประเภท" required>
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

    <div class="modal fade" id="edit_type" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="edit_type_form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">แก้ไขประเภท</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" class="form-control" name="type_id" id="type_id_edit" placeholder="ประเภท">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="formGroupExampleInput">ชื่อประเภท</label>
                            <input type="text" class="form-control" name="type" id="type_edit" placeholder="ประเภท">
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
            $('#insert_type_form').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: 'check/insert_type.php',
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

            $('#edit_type_form').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: 'check/edit_type.php',
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

        function get_type(type_id) {
            $.ajax({
                url: 'check/get_type.php',
                type: "POST",
                data: {
                    type_id: type_id
                },
                success: function(response) {
                    let res = JSON.parse(response);
                    $("#type_edit").val(res.type);
                    $("#type_id_edit").val(type_id);
                    $("#edit_type").modal("show");
                }
            });
        }

        function delete_type(type_id) {
            $.ajax({
                url: 'check/get_type.php',
                type: "POST",
                data: {
                    type_id: type_id
                },
                success: function(response) {
                    let res = JSON.parse(response);
                    Swal.fire({
                        title: res.type,
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
                                url: 'check/delete_type.php',
                                method: 'POST',
                                data: {
                                    type_id: type_id
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