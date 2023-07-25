<?php
include '../conn.php';
header("Location: ../emp_show.php");
//header =  กลับไปหน้าเดิม

$id = $_GET['userID'];
$sql = "DELETE FROM employee WHERE user_id='$id' ";
//echo $sql;
$result = mysqli_query($conn,$sql);

$sql_user = "DELETE FROM user WHERE user_id='$id' ";
$result_user = mysqli_query($conn,$sql_user);

$sql_user1 = "DELETE FROM sche_employee WHERE user_id='$id' ";
$result_user1 = mysqli_query($conn,$sql_user1);

if($result){
    echo "<script>alert('ลบข้อมูลเรียบร้อย');</script>";
    echo "<script>window.location='../emp_show.php';</script>";
}else{
    echo "<script>alert('ไม่สามารถลบข้อมูลได้');</script>";
}

mysqli_close($conn)

?>