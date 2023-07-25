<?php
include 'conn.php';
header("Location: fill_in_stu_scores.php");

$reg_id = mysqli_real_escape_string($conn, $_POST['reg_id']);
$reg_score = mysqli_real_escape_string($conn, $_POST['reg_score']);

if ($reg_score >= 80 && $reg_score <= 100) {
    $grade = '4';
} elseif ($reg_score >= 75 && $reg_score <= 79) {
    $grade = '3.5';
} elseif ($reg_score >= 70 && $reg_score <= 74) {
    $grade = '3';
} elseif ($reg_score >= 65 && $reg_score <= 69) {
    $grade = '2.5';
} elseif ($reg_score >= 60 && $reg_score <= 64) {
    $grade = '2';
} elseif ($reg_score >= 55 && $reg_score <= 59) {
    $grade = '1.5';
} elseif ($reg_score >= 50 && $reg_score <= 54) {
    $grade = '1';
} else {
    $grade = '0';
}

$sql = "UPDATE registra SET
        reg_score = '$reg_score',
        grade = '$grade'
        WHERE reg_id = '$reg_id'";

$result = mysqli_query($conn,$sql);

$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
// Calculate GPA for the student
$result1 = mysqli_query($conn,"SELECT SUM(cou_credit) AS total_credit, SUM(cou_credit*grade) AS total_grade FROM registra
INNER JOIN student ON registra.user_id = student.user_id
INNER JOIN course ON registra.cou_id = course.cou_id
WHERE registra.user_id = '$user_id'") or die(mysqli_error($conn));
$row = mysqli_fetch_assoc($result1);
$sum_credit = $row['total_credit'];
$sum_grade = $row['total_grade'];
$GPA = $sum_grade/$sum_credit;

// Update the GPA field in the student table
$sql1 = "UPDATE student SET stu_gpa = '$GPA' WHERE user_id = '$user_id'";
$result1 = mysqli_query($conn,$sql1);

if($result1 && $result){
    // redirect back to the form page after updating the data
    echo "Data updated successfully.";
    echo "<script>alert('อัพเดทข้อมูลเรียบร้อย');</script>";
    echo "<script>window.location='fill_in_stu_scores.php';</script>";
}else{
    echo "Error updating data: " . mysqli_error($conn);
    echo "<script>alert('ไม่สามารถอัพเดทข้อมูลได้');</script>";
}

mysqli_close($conn);
?>