<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">คุณต้องการออกจากระบบใช่ไหม</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">ถ้าคุณต้องการออกจากระบบ กดปุ่ม "ออกจากระบบ"</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
                <?php
                if (isset($_SESSION['admin_id'])) {
                    echo '<a class="btn btn-primary" href="../admin/check/logout.php">ออกจากระบบ</a>';
                } else {
                    echo '<a class="btn btn-primary" href="../check/logout.php">ออกจากระบบ</a>';
                }
                ?>
            </div>
        </div>
    </div>
</div>