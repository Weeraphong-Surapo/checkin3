<?php
require_once('../../../Controller/AdminController.php');
// สร้างออปเจ็คจากคลาส DB_Admin
$DB = new DB_Admin;

// เพิ่มคำนำหน้า
if(isset($_POST['addTitle'])){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $DB->insertORupdateTitle($id,$title);
}

// ลบคำนำหน้า
if(isset($_POST['deltitle'])){
    $id = $_POST['id'];
    $DB->delTitle($id);
}

// แก้ไขคำนำหน้า
if(isset($_POST['editTitle'])){
    $id = $_POST['id'];
    $DB->editTitle($id);
}

// เพิ่มระดับชั้น
if(isset($_POST['addLavel'])){
    $id = $_POST['id'];
    $lavel = $_POST['lavel'];
    $DB->insertLavel($id,$lavel);
}

// ลบระดับชั้น
if(isset($_POST['delLavel'])){
    $id = $_POST['id'];
    $DB->delLavel($id);
}

// โชว์ระดับชั้น
if(isset($_POST['showLavel'])){
    $id = $_POST['lavel'];
    $DB->editLavel($id);
}

// เพิ่มสาขางาน และ อัพเดตสาขางาน
if(isset($_POST['insertDepartment'])){
    $id = $_POST['id_edit'];
    $department = $_POST['department'];
    $DB->insertDepartment($id,$department);
}

// ลบสาขางาน
if(isset($_POST['delDepartment'])){
    $id = $_POST['id'];
    $DB->delDepartment($id);
}

// แก้ไขสาขางาน
if(isset($_POST['editDepartment'])){
    $id = $_POST['id'];
    $DB->editDepartment($id);
}

// เพิ่มอาจารย์
if(isset($_POST['add_teacher'])){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $name = $_POST['teacher'];
    $username = $_POST['username'];
    $pass = $_POST['password'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $lavel = $_POST['lavel'];
    $DB->insertTeacher($id,$title,$name,$username,$pass,$phone,$department,$lavel);
}

// ลบอาจารย์
if(isset($_POST['delTeacher'])){
    $id = $_POST['id'];
    $DB->delTeacher($id);
}

// แก้ไขอาจารย์
if(isset($_POST['edit_teacher'])){
    $id = $_POST['id'];
    $DB->editTeacher($id);
}

// ดูข้อมูลอาจารย์
if(isset($_POST['view_teacher'])){
    $id = $_POST['id'];
    $DB->viewTeacher($id);
}

?>