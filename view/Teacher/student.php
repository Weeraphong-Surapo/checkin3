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
            <span class="fs-5 d-block mb-1">นักเรียนทั้งหมด</span>
            <button class="btn btn-insert" onclick="insertStudent()">เพิ่มนักเรียน</button>
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>เลข</th>
                            <th>รหัส</th>
                            <th>จัดการ</th>
                        </tr>
                        <tbody>
                            <?php foreach($DB->showData() as $data): ?>
                            <tr>
                                <td><?= $data['Student_id'];?></td>
                                <td><?= $data['Student_name'];?></td>
                                <td>
                                    <button class="btn btn-edit" data-id="<?php echo $data['id'];?>"><i class='bx bx-edit icon'></i></button>
                                    <button class="btn btn-danger btn-del" data-id="<?= $data['id']; ?>" data-name="<?= $data['Student_name']; ?>"><i class='bx bx-task-x icon'></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="ModalStudent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">เพิ่มนักเรียน</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="formStudent">
                    <input type="hidden" name="id-student" id="id-student">
                    <div class="mb-2">
                        <input type="text" name="student_id" id="student_id" class="form-control mb-1" placeholder="รหัสประจำตัวนักศึกษา">
                        <p id="error-student_id"></p>
                    </div>
                    <div class="mb-2">
                        <input type="text" name="student_name" id="student_name" class="form-control mb-1" placeholder="ชื่อ-สกุล นักศึกษา">
                        <p id="error-student_name"></p>
                    </div>
                    <div class="mb-2">
                        <input type="email" name="email" id="email" class="form-control mb-1" placeholder="อีเมลล์นักศึกษา">
                        <p id="error-email"></p>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-save">บันทึก</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php require_once('function/footer.php'); ?>
<script src="../assets/js/student.js"></script>