<?php
include '../conn.php';
header("Location: ../stu_show.php");
//header =  กลับไปหน้าเดิม
$id = $_GET['userID'];


$sql = "DELETE FROM student WHERE user_id='$id' ";
$result = mysqli_query($conn,$sql);

$sql_user = "DELETE FROM user WHERE user_id='$id' ";
$result_user = mysqli_query($conn,$sql_user);

if($result){
    echo "<script>alert('ลบข้อมูลเรียบร้อย');</script>";
    echo "<script>window.location='../stu_show.php';</script>";
}else{
    echo "<script>alert('ไม่สามารถลบข้อมูลได้');</script>";
}

mysqli_close($conn);

?>
