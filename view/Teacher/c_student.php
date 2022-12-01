<?php
// เรียกใช้งาน DB และ Controller
require_once('../../Controller/TeacherController.php');
require_once('function/head.php');
require_once('function/nav.php');
$DB = new DB;

date_default_timezone_set('Asia/bangkok');
$date = date('d-m-y');

if (isset($_GET['date']) && $_GET['date'] == $date) {
    $sql = "UPDATE tb_student SET status = 1 WHERE Student_id = '{$_GET['Student_id']}'";
    $query = $DB->conn->query($sql);
    if($query){
        echo '<script>alertsuccess("success","เช็คเรียบร้อย","")</script>';
    }
}


?>
<style>
    div span a {
        display: none;
    }

    #qr-reader__status_span {
        display: none;
        /* width: auto !important; */
    }

    div#qr-reader {
        border: none !important;
    }

    div#qr-reader__dashboard_section_csr div button {
        background-color: red;
        border: none;
        padding: 10px;
        color: white;
        border-radius: 5px;
    }
</style>
<div class="container col-lg-12 col-12 col-md-12 ">
    <div id="qr-reader"></div>


    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">รายชื่อนักเรียน</h4>
                    <table class="table text-center p-0">
                        <thead>
                            <tr>
                                <th>เลข</th>
                                <th>รหัส</th>
                                <th class="name">ชื่อ</th>
                                <th>สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $sql = "SELECT * FROM tb_student ORDER BY Student_id ASC";
                            $check_time = "SELECT * FROM tb_check_student";
                            $time = $DB->conn->query($check_time);
                            $time_check = $time->fetch_array();

                            $day_result = '';
                            if ($time->num_rows >= 1) {
                                $date_check = $time_check['check_time'];
                                $day = date($date_check);
                                $day_result .= date('d-m-y', strtotime($day));
                            }
                            $query = $DB->conn->query($sql);
                            if ($day_result != $date) {
                                while ($row = $query->fetch_array()) :
                            ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $row['Student_id']; ?></td>
                                        <td class="name"><?= $row['Student_name'];?></td>
                                        <td>
                                            <div class="form-check" style="margin-left: 47%;">
                                                <label class="form-check-label">
                                                    <input class="checkbox checkin" type="checkbox" <?php echo $row['status'] == 1 ? 'checked' : ''; ?> data-id="<?=$row['id'];?>"></label>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                endwhile;
                            } else { ?>
                                <tr class="p-3">
                                    <td colspan="4" class="fw-bold fs-6">เช็คชื่อวันที่ <?= $date; ?> แล้ว</td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                    <br>
                    <?php if ($day_result != $date) { ?>
                    <button class="add btn btn-insert" onclick="Swalconfrim()">บันทึก</button>
                        <?php }else{
                           echo  '<a href="report.php" class="btn btn-primary w-100" >ดูสรุปผล</a>';
                        } ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?php require_once('function/footer.php'); ?>
<script src="../assets/js/swal.js"></script>
<script>

    $('.checkin').click(function(){
        let id = $(this).attr('data-id')
        let attr_ = $(this).is(':checked')
        if(attr_){
            $.ajax({
                url: 'function/action.php',
                type: 'post',
                data: {
                    id: id,
                    checkin: 1
                },
                success: function(res) {
                    // location.reload();
                    window.location.href="c_student.php"
                }
            })
        }else{
            $.ajax({
                url: 'function/action.php',
                type: 'post',
                data: {
                    id: id,
                    checkin: 1,
                    update: 1
                },
                success: function(res) {
                    location.reload();
                }
            })
        }
    })

    function Swalconfrim() {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'บันทึกข้อมูลใช่ไหม?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ใช่',
            cancelButtonText: 'ไม่',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'function/action.php',
                    type: 'post',
                    data: {
                        insert: 1
                    },
                    success: function(data) {

                        swalWithBootstrapButtons.fire(
                            'บันทึกสำเร็จ!',
                            '',
                            'success'
                        )
                        setTimeout(window.location.reload.bind(window.location), 1500)
                    },
                    error: function(xhr, text) {
                        alert(text)
                    }
                })
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'ไม่ใด้บันทึกข้อมูล',
                    '',
                    'error'
                )
            }
        })
    }

    function onScanSuccess(decodedResult) {
        window.location.href = decodedResult;
    }

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", {
            fps: 20,
            qrbox: 200
        });
    html5QrcodeScanner.render(onScanSuccess);

    $(function() {
        $('div#qr-reader__dashboard_section_csr div button').text('สแกนเช็คชื่อ')
    })


    function alertsuccess(type, title, text) {
    Swal.fire(
        title,
        text,
        type
      )
}
</script>