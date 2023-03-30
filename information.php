<?php
session_start();
require_once 'include/connect.php';
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
}
$user_id = $_SESSION['user_id'];
$check = $connect->prepare("SELECT * FROM user WHERE user_id = :user_id");
$check->bindParam(":user_id", $user_id);
$check->execute();
$row = $check->fetch(PDO::FETCH_ASSOC);
if ($row['status'] == 1) {
    header("location: index.php");
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
    <div class="container">
        <div class="text-end">
            <a href="./check/logout.php" type="button" class="btn btn-danger m-3">ออกจากระบบ</a>
        </div>
        <!-- <div class="container-sm w-50" style="margin: 0; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"> -->
        <div class="container-sm w-50" style="margin-top: 20px; margin-bottom: 20px;">
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
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="store" id="store" placeholder="ชื่อร้านค้า" value="<?= $row['store'] ?>" required />
                        <label for="store">ชื่อร้านค้า</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="description" id="description" placeholder="รายละเอียด" style="height: 150px" required><?= $row['description'] ?></textarea>
                        <label for="description">รายละเอียด</label>
                    </div>
                    <div class="form-floating mb-3">
                        <img id="showpic" src="./img/<?= !empty($row['img_path']) ? $row['img_path'] : 'add_image.png' ?>" class="rounded col-sm-12" onclick="document.getElementById('preimg').click();" style="cursor: pointer; width: 300px; display: block; margin: auto;">
                    </div>
                    <div class="text-center">
                        <input type="hidden" name="checkpreimg" value="<?= $row['img_path'] ?>">
                        <input type="file" class="sr-only" id="preimg" name="preimg" accept="image/*" onchange="readURL(this);" style="display: none;">
                    </div>
                    <a onclick="$('#preimg').click();" class="m-2 mb-5 btn btn-success d-block mx-auto">เพิ่มรูป QR Code</a>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit">เพิ่มข้อมูล</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#insert_information').submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: 'check/insert_information.php',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response == 'success') {
                            Swal.fire({
                                title: 'สำเร็จ',
                                text: 'กรุณารอสักครู่ กำลังตรวจสอบข้อมูลจากผู้ดูแล',
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
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
        });
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
    </script>
</body>

</html>