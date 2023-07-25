<?php
include 'conn.php';
session_start(); 

// Calculate the GPA
$ID = $_SESSION['user_id'];
$result = mysqli_query($conn,"SELECT SUM(cou_credit) AS total_credit FROM registra
INNER JOIN student ON 
registra.user_id = student.user_id
INNER JOIN course ON 
registra.cou_id = course.cou_id                
WHERE registra.user_id = '$ID'") or die(mysqli_error($conn));
$row = mysqli_fetch_assoc($result);
$sum_credit = $row['total_credit'];

$result = mysqli_query($conn,"SELECT SUM(cou_credit*grade) AS total_grade FROM registra
INNER JOIN student ON 
registra.user_id = student.user_id
INNER JOIN course ON 
registra.cou_id = course.cou_id                
WHERE registra.user_id = '$ID'") or die(mysqli_error($conn));
$row = mysqli_fetch_assoc($result);
$sum_grade = $row['total_grade'];
$GPA = $sum_grade/$sum_credit;

// Update the GPA field in the student table
$sql = "UPDATE student SET stu_gpa = '$GPA' WHERE user_id = '$ID'";
$result = mysqli_query($conn,$sql);
if($result){
    echo "Data updated successfully.";
    echo "<script>alert('อัพเดทข้อมูลเรียบร้อย');</script>";
    echo "<script>window.location='grade.php';</script>";
}else{
    echo "Error updating data: " . mysqli_error($conn);
    echo "<script>alert('ไม่สามารถอัพเดทข้อมูลได้');</script>";
}

mysqli_close($conn);
?>
