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
if (!empty($row['id_number'])) {
    $idNumber = $row['id_number'];
    $row['id_number'] = substr($idNumber, 0, 1) . '-' . substr($idNumber, 1, 4) . '-' . substr($idNumber, 5, 5) . '-' . substr($idNumber, 10, 2) . '-' . substr($idNumber, 12);
}
if (!empty($row['phone'])) {
    $phone_Number = $row['phone'];
    $row['phone'] = substr($phone_Number, 0, 2) . '-' . substr($phone_Number, 2, 4) . '-' . substr($phone_Number, 6);
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
                        <input type="text" class="form-control" name="id_number" id="id_number" placeholder="หมายเลขบัตรประชาชน" value="<?= $row['id_number'] ?>" pattern=".{17,}" required />
                        <label for="id_number">หมายเลขบัตรประชาชน</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="เบอร์โทร" value="<?= $row['phone'] ?>" pattern=".{12,}" required />
                        <label for="phone">เบอร์โทร</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="address" id="address" placeholder="ที่อยู่" value="<?= $row['address'] ?>" required />
                        <label for="address">ที่อยู่</label>
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
            $('#id_number').on('input', function() {
                var IDNumber = $(this).val().replace(/[^0-9]/g, ''); // Remove existing hyphens
                if (IDNumber.length > 13) {
                    IDNumber = IDNumber.slice(0, 13); // Limit to 13 digits
                }
                var formattedIDNumber = '';
                for (var i = 0; i < IDNumber.length; i++) {
                    if (i === 1 || i === 5 || i === 10 || i === 12) {
                        formattedIDNumber += '-';
                    }
                    formattedIDNumber += IDNumber[i];
                }
                $(this).val(formattedIDNumber);
            });

            $('#phone').on('input', function() {
                var phoneNumber = $(this).val().replace(/[^0-9]/g, ''); // Remove existing hyphens
                if (phoneNumber.length > 10) {
                    phoneNumber = phoneNumber.slice(0, 10); // Limit to 10 digits
                }
                var formattedNumber = '';
                for (var i = 0; i < phoneNumber.length; i++) {
                    if (i === 2 || i === 6) {
                        formattedNumber += '-';
                    }
                    formattedNumber += phoneNumber[i];
                }
                $(this).val(formattedNumber);
            });

            $('form').on('submit', function() {
                var idNumber = $('#id_number').val().replace(/-/g, ''); // Remove hyphens from ID number
                var phoneNumber = $('#phone').val().replace(/-/g, ''); // Remove hyphens from phone number
                $('#id_number').val(idNumber);
                $('#phone').val(phoneNumber);
            });

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