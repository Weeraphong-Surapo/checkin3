<?php
if (!isset($_SESSION)) {
  session_start();
}
// คลาส ชื่อ DB สามารถแก้ไขชื่อใด้
class DB
{
  // Properties
  public $conn;

  // เชื่อมต่อฐานข้อมูล
  function __construct()
  {
    $this->conn = new mysqli('localhost', 'root', 'root', 'Checkin_Qrcode'); 
    $this->conn->set_charset("utf8");
  }

  // โชว์ข้อมูล นักเรียนทั้งหมด
  function showData()
  {
    $sql = "SELECT * FROM tb_student";
    $result = $this->conn->query($sql);
    return $result;
  }


  // แก้ไขข้อมูลนักเรียน
  function fetchData($id)
  {
    $sql = "SELECT * FROM tb_student WHERE id = '$id'";
    $query = $this->conn->query($sql);
    $row = $query->fetch_array();
    echo json_encode($row);
  }

  // ลบข้อมูลนักเรียน
  function delData($id)
  {
    $sql = "DELETE FROM tb_student WHERE id = '$id'";
    $this->conn->query($sql);
  }

  // เพิ่มข้อมูลข้อมูล
  function insertData($student_id, $student_name, $email, $teacher_id)
  {
    $sql = "INSERT INTO tb_student(Student_id,Student_name,Email,Teacher_id)
                VALUES('$student_id','$student_name','$email','$teacher_id')";
    $this->conn->query($sql);
  }

  // อัพเดตข้อมูลข้อมูล
  function updateData($student_id, $student_name, $email, $teacher_id, $id)
  {
    $sql = "UPDATE tb_student SET Student_id = '$student_id', Student_name = '$student_name',Email = '$email',Teacher_id = '$teacher_id' WHERE id = '$id'";
    $this->conn->query($sql);
  }


  // โชว์แสดงสรุปผลรายงาน
  function reportStudent()
  {
    $sql = "SELECT * FROM tb_check_student  ORDER BY Student_id ASC";
    $result = $this->conn->query($sql);
    return $result;
  }

  // เอาอีเมล์นักเรียน
  function sendEmail($id)
  {
    $sql = "SELECT * FROM tb_check_student WHERE id = '$id'";
    $result = $this->conn->query($sql);
    return $result;
  }

  // ยกเลิกการติ้กเช็คชื่อ
  function cancelCheck($id)
  {
    $sql = "UPDATE tb_student SET status = 0 WHERE id = '$id'";
    return $sql;
  }

  // ติ้กเช็คชื่อนักเรียน
  function Checkin($id)
  {
    $sql = "UPDATE tb_student SET status = 1 WHERE id = '$id'";
    return $sql;
  }

  // เพิ่มข้อมูลการเข้าแถวของนักเรียน
  function insertStudent()
  {
    $sql = "SELECT * FROM tb_student";
    $query = $this->conn->query($sql);
    while ($row = $query->fetch_array()) {
      $result = $this->conn->query("SELECT * FROM tb_check_student WHERE Student_id = '$row[Student_id]'");
      $fetch = $result->fetch_array();
      if ($result->num_rows == 1) {
        if ($row['status'] != 0) {
          $count_check = $fetch['count_check'] + 1;
          $count_check_in = $fetch['count_check_in'] + 1;
          $count_no_check = $fetch['count_no_check'];
          $sql_check = "UPDATE tb_check_student SET count_check = $count_check, count_check_in = $count_check_in, count_no_check = $count_no_check WHERE Student_id = '$row[Student_id]'";
          $this->conn->query($sql_check);
        } else {
          $count_check = $fetch['count_check'] + 1;
          $count_check_in = $fetch['count_check_in'];
          $count_no_check = $fetch['count_no_check'] + 1;
          $sql_check = "UPDATE tb_check_student SET count_check = $count_check, count_check_in = $count_check_in, count_no_check = $count_no_check WHERE Student_id = '$row[Student_id]'";
          $this->conn->query($sql_check);
        }
      } else {
        if ($row['status'] != 0) {
          $sql_check_new = "INSERT INTO tb_check_student(Student_id,Name,Email,Teacher_id,count_check,count_check_in,count_no_check)
                                  VALUES('$row[Student_id]','$row[Student_name]','$row[Email]','$row[Teacher_id]',1,1,0)";
        } else {
          $sql_check_new = "INSERT INTO tb_check_student(Student_id,Name,Email,Teacher_id,count_check,count_check_in,count_no_check)
                VALUES('$row[Student_id]','$row[Student_name]','$row[Email]','$row[Teacher_id]',1,0,1)";
        }

        $this->conn->query($sql_check_new);
      }
    }
    $reset_status = "UPDATE tb_student SET status = 0";
    $this->conn->query($reset_status);
  }


  
  // เข้าสู่ระบบ อาจารย์
  function login($username,$password)
  {
    $query = $this->conn->query("SELECT * FROM tb_teacher WHERE username = '$username'");
    if ($query->num_rows >= 1) {
      $query_pass = $this->conn->query("SELECT * FROM tb_teacher WHERE password = '$password'");
      if ($query_pass->num_rows >= 1) {
        $query_user = $this->conn->query("SELECT * FROM tb_teacher WHERE username = '$username' AND password = '$password'");
        $user = $query_user->fetch_array();
        $_SESSION['login'] = true;
        $_SESSION['Teacher_name'] = $user['Teacher_name'];
        $_SESSION['department'] = $user['Department'];
        $_SESSION['Teacher_id'] = $user['id'];
        echo 'login success';
      } else {
        echo "passwordfail";
      }
    } else {
      echo "userfail";
    }
  }





}

