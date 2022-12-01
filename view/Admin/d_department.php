<?php
// เรียกใช้งาน DB และ Controller
require_once('../../Controller/AdminController.php');
require_once('function/head.php');
require_once('function/nav.php');
$DB = new DB_Admin;
$detail = isset($_GET['d']) ? $_GET['d'] : '';
$sql = $detail != '' ? "SELECT * FROM tb_teacher WHERE Department = '$detail' " : '';
$query = $DB->conn->query($sql);
?>

<div class="container">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title">รายละเอียด</h4>
                    <?php 
                    if($query->num_rows > 0){
                        $row = $query->fetch_array();
                        $count_student = "SELECT * FROM tb_student WHERE Teacher_id = '$row[id]'";
                        $query2 = $DB->conn->query($count_student);
                        $count = $query2->num_rows;
                        echo "<table class='table text-center'>
                            <tr>
                                <th>อาจารย์ที่ดูแล</th>
                                <th>จำนวนนักเรียน</th>
                            </tr>
                            <tr>
                                <td>{$row['title']} {$row['Teacher_name']}</td>
                                <td>{$count} คน</td>
                            </tr>
                        </table>";
                    }else{
                        echo "<table class='table text-center'>
                            <tr>
                                <th>อาจารย์ที่ดูแล</th>
                                <th>จำนวนนักเรียน</th>
                            </tr>
                            <tr>
                                <td colspan='3'><h4>ไม่มีอาจารย์ที่ดูแลสาขา</h4></td>
                            </tr>
                        </table>";
                    }
                    ?>
        </div>
    </div>
</div>

<?php require_once('function/footer.php'); ?>