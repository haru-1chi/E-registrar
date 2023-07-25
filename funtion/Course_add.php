<?php
include '../conn.php';
header("Location: ../Course_show.php");

// Get the form data
$cou_id = $_POST['cou_id'];
$cou_name = $_POST['cou_name'];
$cou_num = $_POST['cou_num'];
$cou_sec = $_POST['cou_sec'];
$cou_secper = $_POST['cou_secpergroup'];
$cou_building = $_POST['cou_building'];
$sche_Emp_id = $_POST['sche_Emp_id'];

// Insert the data into the database for course table
$sql = "INSERT INTO course (cou_id, cou_name, cou_credit, cou_num_of_group, cou_num_of_student,cou_building, sche_Emp_id) 
        VALUES ('$cou_id', '$cou_name', '$cou_num ', '$cou_sec', '$cou_secper', '$cou_building', '$sche_Emp_id')";
$result = mysqli_query($conn, $sql);

// Insert the data into the database for cou_date_time table
#$sql2 = "INSERT INTO cou_date_time (cou_id, cdt_date, cdt_startTime, cdt_endTime) 
#        VALUES ('$cou_id', '', '', '')";
#$result2 = mysqli_query($conn, $sql2);

if($result){
    echo "<script>alert('บันทึกข้อมูลสำเร็จ');</script>";
    echo "<script>window.location='../Course_show.php';</script>";
} else{
    echo "<script>alert('ไม่สามารถบันทึกข้อมูล!');</script>";
    echo "<script>window.location='../Course_addForm.php';</script>";
}

// Close the database connection
mysqli_close($conn);
?>