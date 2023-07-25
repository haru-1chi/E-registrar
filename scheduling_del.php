<?php
include 'conn.php';
session_start();
//header =  กลับไปหน้าเดิม

$id = $_GET['cdtID'];
$sql = "DELETE FROM cou_date_time WHERE cdt_id='$id' ";
//echo $sql;
$result = mysqli_query($conn,$sql);

if($result){
    echo "<script>alert('ลบข้อมูลเรียบร้อย');</script>";
    echo "<script>window.location='scheduling.php';</script>";
}else{
    echo "<script>alert('ไม่สามารถลบข้อมูลได้');</script>";
}

mysqli_close($conn)

?>