<?php
include '../conn.php';
header("Location: ../stu_show.php");
//header =  กลับไปหน้าเดิม
$user_id = $_POST['user_id'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$gender = $_POST['gender'];
$birth = $_POST['birth'];
$faculty = $_POST['faculty'];
$branch = $_POST['branch'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$address = $_POST['address'];
$advicer = $_POST['advicer'];


$sql = "UPDATE student SET 
stu_fname = '$fname',
stu_lname = '$lname',
stu_gender = '$gender',
stu_birth = '$birth',
stu_phone = '$phone',
stu_address = '$address',
stu_email = '$email',
stu_gpa = '0',
fac_id = '$faculty',
branch_id = '$branch',
ra_id= '4',
advicer_id = '$advicer' 
WHERE user_id='$user_id' ";

$result = mysqli_query($conn,$sql);

if($result){
    echo "Data updated successfully.";
    echo "<script>alert('อัพเดทข้อมูลเรียบร้อย');</script>";
    echo "<script>window.location='stu_show.php';</script>";
}else{
    echo "Error updating data: " . mysqli_error($conn);
    echo "<script>alert('ไม่สามารถอัพเดทข้อมูลได้');</script>";
}

mysqli_close($conn);

?>
