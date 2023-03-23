<!DOCTYPE html>
<html lang="en">

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
}
require '../include/connect.php';
include '../include/header.php';
?>

<body id="page-top">
    <div id="wrapper">
        <?php include '../include/sidebar_admin.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include '../include/topbar.php'; ?>
                <div class="container-fluid">
                    <form id="insert_information">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="firstname" id="firstname" placeholder="ชื่อ" value="<?= $check_profile->rowCount() > 0 ? $row_profile['firstname'] : '' ?>" required />
                            <label for="firstname">ชื่อ</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="lastname" id="lastname" placeholder="นามสกุล" value="<?= $check_profile->rowCount() > 0 ? $row_profile['lastname'] : '' ?>" required />
                            <label for="lastname">นามสกุล</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="store" id="store" placeholder="ชื่อร้านค้า" value="<?= $check_profile->rowCount() > 0 ? $row_profile['store'] : '' ?>" required />
                            <label for="store">ชื่อร้านค้า</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="description" id="description" placeholder="รายละเอียด" style="height: 150px" required><?= $check_profile->rowCount() > 0 ? $row_profile['description'] : '' ?></textarea>
                            <label for="description">รายละเอียด</label>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="submit"><?= $check_profile->rowCount() > 0 ? 'แก้ไขข้อมูล' : 'เพิ่มข้อมูล' ?></button>
                        </div>
                    </form>
                </div>
            </div>
            <?php include '../include/footer.php'; ?>
        </div>
    </div>
    <?php include '../include/scroll.php'; ?>
    <?php include '../include/modal.php'; ?>
    <?php include '../include/js.php'; ?>
</body>

</html>