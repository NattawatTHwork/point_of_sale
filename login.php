<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }
    </style>
</head>

<body>
    <div class="container-sm w-50" style="margin: 0; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div>
            <h1>เข้าสู่ระบบ</h1>
            <p>
                คุณยังไม่มีบัญชีใช่ไหม <a href="register.php">ลงทะเบียน</a>
            </p>
        </div>
        <?php if (isset($_GET['status'])) { ?>
            <div class="alert alert-danger" role="alert">
                <?php
                if ($_GET['status'] == 'incorrect') {
                    echo 'รหัสผ่านไม่ถูกต้อง';
                } elseif ($_GET['status'] == 'notemail') {
                    echo 'ไม่มีอีเมลนี้ในระบบ กรุณาลงทะเบียน';
                }
                ?>
            </div>
        <?php } ?>
        <form method="post" action="check/login_check.php">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required />
                <label for="email">อีเมล</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required />
                <label for="password">รหัสผ่าน</label>
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="submit">เข้าสู่ระบบ</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>