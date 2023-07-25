<?php
include '../conn.php';
header("Location: ../emp_show.php");
//header =  กลับไปหน้าเดิม

$user_id = $_POST['user_id'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$gender = $_POST['gender'];
$birth = $_POST['birth'];
$faculty = $_POST['faculty'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$address = $_POST['address'];
$enroll =$_POST['enroll'];

$sql = "UPDATE employee SET 
emp_fname = '$fname',
emp_lname = '$lname',
emp_gender = '$gender',
emp_birth = '$birth',
emp_phone = '$phone',
emp_address = '$address',
emp_email = '$email',
fac_id = '$faculty',
emp_enroll = '$enroll'
WHERE user_id='$user_id' ";

$result = mysqli_query($conn,$sql);

if($result){
    echo "Data updated successfully.";
    echo "<script>alert('อัพเดทข้อมูลเรียบร้อย');</script>";
    echo "<script>window.location='../emp_show.php';</script>";
}else{
    echo "Error updating data: " . mysqli_error($conn);
    echo "<script>alert('ไม่สามารถอัพเดทข้อมูลได้');</script>";
}

mysqli_close($conn);

?> 

