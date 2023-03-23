<?php
session_start();
require_once '../include/connect.php';
if (!isset($_SESSION['admin_id'])) {
    header("location: login.php");
}
$admin_id = $_SESSION['admin_id'];
$check = $connect->prepare("SELECT * FROM admin WHERE admin_id = :admin_id");
$check->bindParam(":admin_id", $admin_id);
$check->execute();
$row = $check->fetch(PDO::FETCH_ASSOC);
print_r($row);
if ($row['status'] == 1) {
    header("location: dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูล</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container-sm w-50" style="margin: 0; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div>
            <h1>เพิ่มข้อมูล</h1>
            <form id="insert_information">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="ชื่อ" value="<?= $row['firstname'] ?>" required />
                    <label for="firstname">ชื่อ</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="lastname" id="lastname" placeholder="นามสกุล" value="<?= $row['lastname'] ?>" required />
                    <label for="lastname">นามสกุล</label>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="submit">เพิ่มข้อมูล</button>
                </div>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
                $('#insert_information').submit(function(event) {
                    event.preventDefault();
                    $.ajax({
                        url: 'check/insert_information.php',
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if (response == 'success') {
                                Swal.fire({
                                    title: 'สำเร็จ',
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
                        }
                    });
                });
            });
        </script>
</body>

</html>