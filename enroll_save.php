<?php
include 'conn.php';
session_start();

// Get the form data
$user_id = $_SESSION['user_id'];
$cou_id = $_GET['couID'];

// Attempt to insert the record
$sql = "INSERT INTO registra (user_id, cou_id) 
        SELECT * FROM (SELECT '$user_id', '$cou_id') AS tmp
        WHERE NOT EXISTS (
            SELECT user_id, cou_id FROM registra WHERE user_id = '$user_id' AND cou_id = '$cou_id'
        ) LIMIT 1";
$result = mysqli_query($conn, $sql);

// Calculate GPA for the student


// Update the GPA field in the student table

// Check if the insert was successful
if($result){
    if(mysqli_affected_rows($conn) == 0) {
        // Duplicate record exists
        echo "<script>alert('ข้อมูลซ้ำ');</script>";
    } else {
        $result1 = mysqli_query($conn,"SELECT SUM(cou_credit) AS total_credit, SUM(cou_credit*grade) AS total_grade FROM registra
        INNER JOIN student ON registra.user_id = student.user_id
        INNER JOIN course ON registra.cou_id = course.cou_id
        WHERE registra.user_id = '$user_id'") or die(mysqli_error($conn));
        $row = mysqli_fetch_assoc($result1);
        $sum_credit = $row['total_credit'];
        $sum_grade = $row['total_grade'];
        $GPA = $sum_grade/$sum_credit;
        $sql1 = "UPDATE student SET stu_gpa = '$GPA' WHERE user_id = '$user_id'";
        $result1 = mysqli_query($conn,$sql1);
        echo "<script>alert('บันทึกข้อมูลสำเร็จ');</script>";
    }
    echo "<script>window.location='enroll.php';</script>";
} else{
    echo "<script>alert('ไม่สามารถบันทึกข้อมูล!');</script>";
    echo "<script>window.location='enroll.php';</script>";
}

// Close the database connection
mysqli_close($conn);
?>