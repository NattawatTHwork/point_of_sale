<!DOCTYPE html>
<html lang="en">

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
}
require 'include/connect.php';
include 'include/header.php';

$user_id = $_SESSION['user_id'];
$status = $connect->prepare("SELECT * FROM payment INNER JOIN record ON payment.no_receipt = record.no_receipt INNER JOIN product ON record.product_id = product.product_id WHERE user_id = '$user_id' AND DATE(timestamp) = DATE(CURRENT_DATE()) GROUP BY record.no_receipt ORDER BY status ASC");
$status->execute();
$row_report = $status->fetchAll(PDO::FETCH_ASSOC);
?>

<body id="page-top">
    <div id="wrapper">
        <?php include 'include/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'include/topbar.php'; ?>
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">ตารางรายงาน</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="Table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="10%" class="text-center">ลำดับ</th>
                                            <th width="30%" class="text-center">หมายเลขใบเสร็จ</th>
                                            <th width="30%" class="text-center">วิธีชำระเงิน</th>
                                            <th width="15%" class="text-center">ดูข้อมูล</th>
                                            <th width="15%" class="text-center">สถานะ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $all_price = 0;
                                        $j = 1;
                                        foreach ($row_report as $row) {
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $j++ ?></td>
                                                <td class="text-center"><?= $row['no_receipt'] ?></td>
                                                <td class="text-center"><?= $row['method'] == 1 ? 'QR Code' : 'เงินสด' ?></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-primary" onclick="get_record(<?= $row['no_receipt'] ?>)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                                        </svg>
                                                    </button>
                                                </td>
                                                <td class="text-center"><button class="btn <?= $row['status'] == 0 ? 'btn-danger' : 'btn-success' ?>" onclick="change_status(<?= $row['payment_id'] ?>)"><?= $row['status'] == 0 ? 'ยังไม่ได้จัดทำ' : 'จัดทำแล้ว' ?></button></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php include 'include/footer.php'; ?>
        </div>
    </div>
    <?php include 'include/scroll.php'; ?>
    <?php include 'include/modal.php'; ?>
    <?php include 'include/js.php'; ?>

    <!-- Modal -->
    <div class="modal fade" id="view_record" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="edit_product_form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ข้อมูลการขาย</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="myArray"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/file-saver@1.3.3/FileSaver.js"></script>
    <script>
        function change_status(event) {
            $.ajax({
                url: 'check/edit_status.php',
                method: 'POST',
                data: {
                    payment_id: event
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
        };

        function get_record(no_receipt) {
            $.ajax({
                url: 'check/get_record.php',
                type: "POST",
                data: {
                    no_receipt: no_receipt
                },
                success: function(response) {
                    const data = JSON.parse(response);

                    const myArrayDiv = document.getElementById("myArray");

                    const table = document.createElement('table');
                    table.classList.add('table', 'table-bordered', 'w-100');

                    const headerRow = document.createElement('tr');
                    const header1 = document.createElement('th');
                    header1.textContent = 'ชื่อสินค้า';
                    header1.style.width = '30%';
                    header1.classList.add('text-center');
                    const header2 = document.createElement('th');
                    header2.textContent = 'จำนวน';
                    header2.style.width = '20%';
                    header2.classList.add('text-center');
                    const header3 = document.createElement('th');
                    header3.textContent = 'ราคา';
                    header3.style.width = '20%';
                    header3.classList.add('text-center');
                    headerRow.appendChild(header1);
                    headerRow.appendChild(header2);
                    headerRow.appendChild(header3);
                    table.appendChild(headerRow);

                    for (let i = 0; i < data.length; i++) {
                        const row = document.createElement('tr');
                        const cell1 = document.createElement('td');
                        const cell2 = document.createElement('td');
                        const cell3 = document.createElement('td');
                        cell1.textContent = data[i].name;
                        cell1.style.width = '30%';
                        cell1.classList.add('text-center');
                        cell2.textContent = data[i].quantity;
                        cell2.style.width = '20%';
                        cell2.classList.add('text-center');
                        cell3.textContent = data[i].net_price;
                        cell3.style.width = '20%';
                        cell3.classList.add('text-center');
                        row.appendChild(cell1);
                        row.appendChild(cell2);
                        row.appendChild(cell3);
                        table.appendChild(row);
                    }

                    myArrayDiv.innerHTML = '';
                    myArrayDiv.appendChild(table);

                    $("#view_record").modal("show");
                }
            });
        }
    </script>
</body>

</html>