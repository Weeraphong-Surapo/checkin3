<?php
// เรียกใช้งานคลาส DB และ Controller
require_once('../../Controller/TeacherController.php');
require_once('function/headlogin.php');
$DB = new DB;
if(isset($_SESSION['login']) && isset($_SESSION['Teacher_id'])){
    header('Location: index.php');
}
?>

<form action="">
    <img src="../assets/images/logo2.jpg" alt="">
    <br>
        <span class="fs-3" id="">เข้าสู่ระบบ</span><br>
        <!-- <span class="text-mute">สำหรับอาจารย์</span> -->
        <div class="txt_field">
            <input type="text" id="username" name="username" required>
            <span></span>
            <label>Username</label>
        </div>
        <span id="error-username"></span>
        <div class="txt_field">
            <input type="text"  id="password" name="password" required>
            <span></span>
            <label>Password</label>
        </div>
        <span id="error-password"></span>
        <button onclick="loginTeacher(event)">Submit</button>
    </form>


<?php require_once('function/footer.php'); ?>
<script src="../assets/js/login.js"></script>
<script src="../assets/js/blockui.js"></script>