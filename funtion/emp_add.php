<?php
include '../conn.php';
 header("Location: ../emp_show.php");
//header =  กลับไปหน้าเดิม
?>
<?php
    // Get the form data
    $user_id = $_POST['user_id'];
    $password = $_POST['user_id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $birth = $_POST['birth'];
    $fac_id = $_POST['fac_id'];
    $rank = $_POST['rank'];
    $enroll = $_POST['enroll'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    // $fac_id = $_POST['fac']

    
    $sql1 = "INSERT INTO user (user_id,password,ra_id) 
            VALUES ('$user_id', '$password','$rank')";
    $result1 = mysqli_query($conn, $sql1);
    // Insert the data into the databaseuser_id	
    $sql2 = "INSERT INTO employee (user_id, emp_fname, emp_lname,emp_gender, emp_birth, emp_phone, ra_id, emp_enroll, emp_email, emp_address,fac_id) 
            VALUES ('$user_id', '$fname', '$lname', '$gender', '$birth','$phone', '$rank', '$enroll', '$email', '$address', '$fac_id')";
    $result2 = mysqli_query($conn, $sql2);

    if($rank == 1){
    $sql = "INSERT INTO sche_employee (user_id) 
            VALUES ('$user_id')";
    $result = mysqli_query($conn, $sql);
    }

    // echo "$result" ;
    if($result && $result2 && $result1){
        echo "<script>alert('บันทึกข้อมูลสำเร็จ');</script>";
        echo "<script>window.location='../emp_show.php';</script>";
    } else{
        echo "<script>alert('ไม่สามารถบันทึกข้อมูล!');</script>";
        echo "<script>window.location='../emp_show.php';</script>";
    }

// Close the database connection
mysqli_close($conn);
?>