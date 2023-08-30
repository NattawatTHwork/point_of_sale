<!DOCTYPE html>
<html lang="en">

<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">นโยบายความเป็นส่วนตัว</h1>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                นโยบายความเป็นส่วนตัว
                            </h6>
                        </div>
                        <div class="card-body">
                            <p><strong>วันที่ปรับปรุงครั้งล่าสุด:</strong> 1 พฤษภาคม 2566</p>

                            <h5>1. การเปิดเผยข้อมูล</h5>
                            <p>เว็บไซต์จะไม่มีการเปิดเผยข้อมูลหรือแลกเปลี่ยนข้อมูลส่วนบุคคลของคุณกับบุคคลภายนอก เว้นแต่มีความจำเป็นเพื่อให้บริการหรือตามกฎหมาย และเราจะดำเนินการในขั้นตอนที่เหมาะสมในการปกป้องข้อมูลส่วนบุคคลของคุณ</p>

                            <h5>2. การรักษาข้อมูลส่วนบุคคล</h5>
                            <p>เว็บไซต์จะรักษาข้อมูลส่วนบุคคลของคุณเป็นความลับและปกป้องการเข้าถึงข้อมูลนั้นด้วยมาตรการที่เหมาะสม หากเว็บไซต์ไม่ได้ใช้ข้อมูลส่วนบุคคลของคุณต่อไป เราจะดำเนินการลบหรือทำให้ข้อมูลนั้นไม่สามารถระบุตัวตนได้</p>

                            <h5>3. ความสามารถในการควบคุมข้อมูลส่วนบุคคลของคุณ</h5>
                            <p>คุณมีสิทธิในการเข้าถึง แก้ไข หรือลบข้อมูลส่วนบุคคลของคุณที่เราเก็บรวบรวมไว้ คุณสามารถแก้ไขการตั้งค่าการแจ้งเตือนและการติดต่อในการตลาดที่เกี่ยวข้องกับข้อมูลของคุณได้ตลอดเวลา</p>

                            <h5>4. การปรับปรุงนโยบายความเป็นส่วนตัว</h5>
                            <p>เราอาจปรับปรุงนโยบายความเป็นส่วนตัวเมื่อจำเป็น เราขอแนะนำให้คุณตรวจสอบนโยบายนี้เป็นครั้งคราวเพื่อทราบข้อมูลล่าสุดเกี่ยวกับวิธีการปกป้องข้อมูลส่วนบุคคลของคุณ</p>

                            <h5>5. การติดต่อเรา</h5>
                            <p>หากคุณมีคำถาม เรื่องร้องเรียน หรือข้อสงสัยใด ๆ เกี่ยวกับนโยบายความเป็นส่วนตัวนี้ โปรดติดต่อเราทางอีเมลที่ <a href="mailto:nattawatth.work@gmail.com">อีเมลติดต่อ</a> คุณสามารถดูข้อมูลการติดต่อเพิ่มเติมในเว็บไซต์ของเราที่ <a href="[URL ของเว็บไซต์]">Beverage Management</a></p>
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
</body>

</html>