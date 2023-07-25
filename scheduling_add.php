<?php
include 'conn.php';
session_start();
    // Get the form data
    $cou_id = $_POST['cou_id'];
    $cdt_date = $_POST['cdt_date'];
    $cdt_startTime = $_POST['cdt_startTime'];
    $cdt_endTime = $_POST['cdt_endTime'];
    // $fac_id = $_POST['fac']

    $sql = "INSERT INTO cou_date_time (cou_id, cdt_date, cdt_startTime, cdt_endTime)
        SELECT * FROM (SELECT '$cou_id', '$cdt_date', '$cdt_startTime', '$cdt_endTime') AS tmp
        WHERE NOT EXISTS (
            SELECT cdt_date, cdt_startTime, cdt_endTime FROM cou_date_time
            WHERE cdt_date = '$cdt_date' 
            AND ((cdt_startTime >= '$cdt_startTime' AND cdt_startTime < '$cdt_endTime') OR
                 (cdt_endTime > '$cdt_startTime' AND cdt_endTime <= '$cdt_endTime') OR
                 (cdt_startTime < '$cdt_startTime' AND cdt_endTime > '$cdt_endTime'))
        ) LIMIT 1";

    $result = mysqli_query($conn, $sql);
    // echo "$result" ;
    if($result){
        if(mysqli_affected_rows($conn) == 0) {
            // Duplicate record exists
            echo "<script>alert('วัน/เวลาซ้ำกับวิชาอื่น!!');</script>";
        } else {
            echo "<script>alert('บันทึกข้อมูลสำเร็จ');</script>";
        }
        echo "<script>window.location='scheduling.php';</script>";
    } else{
        echo "<script>alert('ไม่สามารถบันทึกข้อมูล!');</script>";
        echo "<script>window.location='scheduling.php';</script>";
    }

// Close the database connection
mysqli_close($conn);
?>

