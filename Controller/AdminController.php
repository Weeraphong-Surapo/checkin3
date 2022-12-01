<?php 
require_once('TeacherController.php');
class DB_Admin extends DB{
    
    // โชว์คำนำหน้าทั้งหมด
    function showTitle(){
        $sql = "SELECT * FROM tb_title";
        $result = $this->conn->query($sql);
        return $result;
    }

    // เพิ่มคำนำหน้า || อัพเดตคำนำหน้า
    function insertORupdateTitle($id,$title){
        if(!empty($id)){
            $sql = "UPDATE tb_title SET title = '$title' WHERE id = '$id'";
        }else{
            $sql = "INSERT INTO tb_title(title) VALUE('$title')";
        }
        $this->conn->query($sql);
    }

    // ลบคำนำหน้า
    function delTitle($id){
        $sql = "DELETE FROM tb_title WHERE id = '$id'";
        $this->conn->query($sql);
    }

    // แก้ไขคำนำหน้า
    function editTitle($id){
        $sql = "SELECT * FROM tb_title WHERE id = '$id'";
        $query = $this->conn->query($sql);
        $row = $query->fetch_array();
        echo json_encode($row);
    }

    // โชว์ระดับชั้น
    function showLavel(){
        $sql = "SELECT * FROM tb_lavel";
        $result = $this->conn->query($sql);
        return $result;
    }

    // เพิ่มระดับชั้น
    function insertLavel($id,$lavel){
        if(!empty($id)){
            $sql = "UPDATE tb_lavel SET lavel = '$lavel' WHERE id = '$id'";
        }else{
            $sql = "INSERT INTO tb_lavel(lavel) VALUE('$lavel')";
        }
        $this->conn->query($sql);
    }

    // ลบระดับชั้น
    function delLavel($id){
        $sql = "DELETE FROM tb_lavel WHERE id = '$id'";
        $this->conn->query($sql);
    }

    // แก้ไขระดับชั้น
    function editLavel($id){
        $query = $this->conn->query("SELECT * FROM tb_lavel WHERE id = '$id'");
        $row = $query->fetch_array();
        echo json_encode($row);
    }

    // โชว์สาขางาน
    function showDepartment(){
        $sql = "SELECT * FROM tb_department";
        $result = $this->conn->query($sql);
        return $result;
    }

    // เพิ่มสาขางาน และ อัพเดตสาขางาน
    function insertDepartment($id,$department){
        if(!empty($_POST['id_edit'])){
            $sql = "UPDATE tb_department SET Department = '$department' WHERE id = '$id'";
        }else{
            $sql = "INSERT INTO tb_department(Department) VALUE('$department')";
        }
        $this->conn->query($sql);
    }

    // แก้ไขสาขางาน
    function editDepartment($id){
        $sql = "SELECT * FROM tb_department WHERE id = '$id'";
        $query = $this->conn->query($sql);
        $row = $query->fetch_array();
        $arr = array('Department'=>$row['Department'],'id'=>$row['id']);
        echo json_encode($arr);
    }

    // ลบสาขางาน
    function delDepartment($id){
        $sql = "DELETE FROM tb_department WHERE id = '$id'";
        $this->conn->query($sql);
    }

    // โชว์อาจารย์ทั้งหมด
    function showTeacher(){
        $sql = "SELECT * FROM tb_teacher";
        $result = $this->conn->query($sql);
        return $result;
    }

    // เพิ่มอาจารย์
    function insertTeacher($id,$title,$name,$username,$pass,$phone,$department,$lavel){
        if(!empty($_POST['id'])){
            $sql = "UPDATE tb_teacher SET title = '$title' , Teacher_name = '$name' , username = '$username',
                    password = '$pass' ,phone = '$phone', Department = '$department',lavel = '$lavel' WHERE id = '$id'";   
        }else{
            $sql = "INSERT INTO tb_teacher(title,Teacher_name,username,password,phone,Department,lavel)
                VALUES('$title','$name','$username','$pass','$phone','$department','$lavel')";
        }
        $this->conn->query($sql);
    }

    // แก้ไขอาจารย์
    function editTeacher($id){
        $sql = "SELECT * FROM tb_teacher WHERE id = '$id'";
        $query = $this->conn->query($sql);
        $row = $query->fetch_array();
        echo json_encode($row);
    }

    // ลบข้อมูลอาจารย์
    function delTeacher($id){
        $sql = "DELETE FROM tb_teacher WHERE id = '$id'";
        $this->conn->query($sql);
    }


    // ดูข้อมูลอาจารย์
    function viewTeacher($id){
        $sql = "SELECT * FROM tb_teacher WHERE id = '$id'";
        $query = $this->conn->query($sql);
        $outp = '';
        while($row = $query->fetch_array()){
            $outp .= '<p>สาขางาน : '.$row['Department'].' / '.$row['lavel'].'</p>';
            $outp .= '<p>ชื่อ : '.$row['title'].$row['Teacher_name'].'</p>';
            $outp .= '<p>เบอร์โทร : '.$row['phone'].'</p>';
            $outp .= '<p>ชื่อผู้ใช้ : '.$row['username'].'</p>';
            $outp .= '<p>รหัสผ่าน : '.$row['password'].'</p>';
        }
        echo $outp;
    }

}
?>