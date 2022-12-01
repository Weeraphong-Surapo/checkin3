<?php 
    session_start();
    require_once('../../../Controller/TeacherController.php');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require '../../assets/phpmailer/src/Exception.php';
    require '../../assets/phpmailer/src/PHPMailer.php';
    require '../../assets/phpmailer/src/SMTP.php';
    
    function smtp_mailer($to, $subject, $msg)
    {
        $mail = new PHPMailer(true);
    
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'shopphp147852@gmail.com';
        $mail->Password = 'xuvbfmckomlptvst';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
    
        $mail->setFrom('shopphp147852@gmail.com');
    
        $mail->addAddress($to);
    
        $mail->isHTML(true);
    
        $mail->Subject = $subject;
        $mail->Body = $msg;
        $mail->send();
    }
    $DB = new DB;

    // แก้ไขข้อมูล
    if(isset($_POST['editstudent'])){
        $id = $_POST['id'];
        $DB->fetchData($id);
    }

    // ลบข้อมูลนักเรียน
    if(isset($_POST['delStudent'])){
        $id = $_POST['id'];
        $DB->delData($id);
    }

    // เพิ่มข้อมูลนักเรียน
    if(isset($_POST['insertStudent'])){
        $id = $_POST['id'];
        $student_id = $_POST['student_id'];
        $student_name = $_POST['student_name'];
        $email = $_POST['email'];
        $teacher = $_SESSION['Teacher_id'];
        echo $student_id;
        echo $student_name;
        echo $email;
        echo $teacher;
        if(!empty($id)){
            $DB->updateData($student_id,$student_name,$email,$teacher,$id);
        }else{
            $DB->insertData($student_id,$student_name,$email,$teacher);
        }
    }


    // ส่งอีเมลล์หานักเรียน
    if(isset($_POST['warn'])){
        $id = $_POST['id'];
        $email =$DB->sendEmail($id);
        $row = $email->fetch_array();
        $email = $row['Email'];
        $htmnl = "แจ้งเตือน {$row['Name']} คุณขาดแถวมากเกินไป กรุณามาเข้าแถวด้วย";
        smtp_mailer($email, 'CHECK IN WARNING', $htmnl);
    }

    // เช็คชื่อนักเรียน
    if(isset($_POST['checkin'])){
        $id = $_POST['id'];
        if(isset($_POST['update'])){
            $sql = $DB->cancelCheck($id);
        }else{
            $sql = $DB->Checkin($id);
        }
        $DB->conn->query($sql);
    }

    // บันทึกข้อมูลลงสรุปผลเข้าแถว 
    if (isset($_POST['insert'])) {
        $DB->insertStudent();
    }

    // เข้าสู่ระบบอาจารย์
    if(isset($_POST['loginTeacher'])){
        $username = $_POST['username'];
        $pass = $_POST['password'];
        $DB->login($username,$pass);
    }


    // ออกจากระบบ
    if(isset($_POST['logout'])){
        session_destroy();
    }
