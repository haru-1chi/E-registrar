<?php
include '../conn.php';
//header =  กลับไปหน้าเดิม

$id = $_GET['userID'];
$sql = "DELETE FROM registra WHERE reg_id='$id' ";
//echo $sql;
$result = mysqli_query($conn,$sql);

if($result){
    echo "<script>alert('ลบข้อมูลเรียบร้อย');</script>";
    echo "<script>window.location='../enroll.php';</script>";
}else{
    echo "<script>alert('ไม่สามารถลบข้อมูลได้');</script>";
}

mysqli_close($conn)

?>