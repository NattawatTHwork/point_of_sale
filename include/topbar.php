<?php
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $profile = $connect->prepare("SELECT * FROM user WHERE user_id = :user_id");
    $profile->bindParam(":user_id", $user_id);
    $profile->execute();
    $row_profile = $profile->fetch(PDO::FETCH_ASSOC);
} else {
    $admin_id = $_SESSION['admin_id'];
    $profile = $connect->prepare("SELECT * FROM admin WHERE admin_id = :admin_id");
    $profile->bindParam(":admin_id", $admin_id);
    $profile->execute();
    $row_profile = $profile->fetch(PDO::FETCH_ASSOC);
}

?>
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= isset($_SESSION['user_id']) ? $row_profile['store'] : $row_profile['firstname'] . ' ' . $row_profile['lastname'] ?></span>
                <img class="img-profile rounded-circle" src="<?= isset($_SESSION['admin_id']) ? '../img/undraw_profile.svg' : 'img/undraw_profile.svg' ?>">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <?php if (isset($_SESSION['user_id'])) { ?>
                    <a class="dropdown-item" href="profile.php">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        โปรไฟล์
                    </a>
                    <a class="dropdown-item" href="history.php">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        ประวัติการใช้บริการ
                    </a>
                <?php } ?>
                <a class="dropdown-item" href="check/logout.php">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    ออกจากระบบ
                </a>
            </div>
        </li>

    </ul>

</nav>