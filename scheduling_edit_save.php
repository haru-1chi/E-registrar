<?php
include 'conn.php';
session_start();
$cdt_id = $_POST['cdt_id'];
$cdt_date = $_POST['cdt_date'];
$cdt_startTime = $_POST['cdt_startTime'];
$cdt_endTime = $_POST['cdt_endTime'];

// Check if the new date and time combination already exists in the table
$sql = "SELECT * FROM cou_date_time
        WHERE cdt_date = '$cdt_date' AND cdt_id != '$cdt_id'
        AND ((cdt_startTime >= '$cdt_startTime' AND cdt_startTime < '$cdt_endTime')
        OR (cdt_endTime > '$cdt_startTime' AND cdt_endTime <= '$cdt_endTime')
        OR ('$cdt_startTime' >= cdt_startTime AND '$cdt_startTime' < cdt_endTime)
        OR ('$cdt_endTime' > cdt_startTime AND '$cdt_endTime' <= cdt_endTime))";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
    // Record already exists, show error message and redirect
    echo "<script>alert('วัน/เวลาซ้ำกับวิชาอื่น!!');</script>";
    echo "<script>window.location='scheduling.php';</script>";
} else {
    // Update the record
    $sql = "UPDATE cou_date_time SET 
            cdt_date = '$cdt_date',
            cdt_startTime = '$cdt_startTime',
            cdt_endTime = '$cdt_endTime'
            WHERE cdt_id = '$cdt_id'";
    $result = mysqli_query($conn, $sql);

    if($result){
        // Record updated successfully, show success message and redirect
        echo "<script>alert('อัพเดทข้อมูลเรียบร้อย');</script>";
        echo "<script>window.location='scheduling.php';</script>";
    } else {
        // Error updating record, show error message and redirect
        echo "<script>alert('ไม่สามารถอัพเดทข้อมูลได้');</script>";
        echo "<script>window.location='scheduling.php';</script>";
    }
}

// Close the database connection
mysqli_close($conn);

?>