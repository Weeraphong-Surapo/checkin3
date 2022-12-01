<?php
// เรียกใช้งานคลาส DB และ Controller
require_once('../../Controller/TeacherController.php');
require_once('function/head.php');
require_once('function/nav.php');
$DB = new DB;
?>
<div class="container">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title mb-3">สรุปการเข้าแถว</h4>
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>รหัส</th>
                                    <th class="name">ชื่อ</th>
                                    <th>จำนวน</th>
                                    <th>เข้า</th>
                                    <th>ขาด</th>
                                    <th>เตือน</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $report = $DB->reportStudent();
                               while($row = $report->fetch_array()):
                                ?>
                                <tr>
                                    <td><?= $row['Student_id'];?></td>
                                    <td class="name"><?= $row['Name'];?></td>
                                    <td><?= $row['count_check'];?></td>
                                    <td><?= $row['count_check_in'];?></td>
                                    <td><?= $row['count_no_check'];?></td>
                                    <td>
                                        <button class="btn btn-danger btn-fw" id="warn" data-id="<?php echo $row['id'];?>" data-name="<?php echo $row['Name'];?>">เตือน</button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <br>
        </div>
    </div>
</div>

<div id="indicator" style="display:none;">
    <h3><img src="../assets/images/gmail.gif" class="img-fluid" alt=""></h3>กำลังแจ้งเตือนทาง Gmail...
</div>

<?php require_once('function/footer.php'); ?>
<script src="../assets/js/student.js"></script>
<script src="../assets/js/blockui.js"></script>