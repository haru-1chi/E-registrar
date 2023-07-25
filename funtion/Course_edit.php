<?php
include '../conn.php';
header("Location: ../Course_show.php");
//header =  กลับไปหน้าเดิม

$cou_id = $_POST['cou_id'];
$cou_name = $_POST['cou_name'];
$cou_num = $_POST['cou_num'];
$cou_sec = $_POST['cou_sec'];
$cou_secpergroup = $_POST['cou_secpergroup'];
$cou_building = $_POST['cou_building'];
$sche_Emp_id = $_POST['sche_Emp_id'];

$sql = "UPDATE course SET 
cou_name = '$cou_name',
cou_credit = '$cou_num',
cou_num_of_group = '$cou_sec',
cou_num_of_student = '$cou_secpergroup',
cou_building = '$cou_building',
sche_Emp_id = '$sche_Emp_id'
WHERE cou_id = '$cou_id'";
$result = mysqli_query($conn,$sql);

if($result){
    echo "Data updated successfully.";
    echo "<script>alert('อัพเดทข้อมูลเรียบร้อย');</script>";
    echo "<script>window.location='Course_show.php';</script>";
}else{
    echo "Error updating data: " . mysqli_error($conn);
    echo "<script>alert('ไม่สามารถอัพเดทข้อมูลได้');</script>";
}

mysqli_close($conn);

?> 