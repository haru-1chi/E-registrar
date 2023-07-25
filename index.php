<?php
session_start();
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <title>Registra</title>
</head>

<body>
<?php include "navbar.php"; ?>


<!--
    <nav class="navbar navbar-expand-lg fixed-top" style="background-color: #fe965a;">
        <div class="container">
            <a class="navbar-brand text-light" href="index.php">ระบบลงทะเบียนเรียน</a>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="navbar-brand text-light" href="Course_show_index.php">รายวิชา</a>
                        <a class="navbar-brand text-light" href="stu_show_index.php">ข้อมูลนิสิต</a>
                        <a class="navbar-brand text-light" href="emp_show_index.php">ข้อมูลพนักงาน</a>
                        <a class="navbar-brand text-light" href=""></a>
                        <a class="navbar-brand text-light" href=""></a>
                        <a class="navbar-brand text-light" href=""></a>
                        <a class="navbar-brand text-light" href="login/login-page.php">เข้าสู่ระบบ</a>
                        <a class="navbar-brand text-light" href="../login/logout.php">ออกจากระบบ</a>
                        
                    </li>
                </ul>
            </div>
        </div>
    </nav><br><br> -->

<br>
<br>
<br>
<?php 
          include 'conn.php';
          
          
          
          ?>
          
          <?php
    if(isset($_SESSION["ra_id"])){

      if($_SESSION["ra_id"] == 4){
        $userID = $_SESSION["user_id"];
        $sql = "SELECT * FROM student
        WHERE student.user_id = '$userID'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($result);
        $stu_fname = $row['stu_fname'];
        $stu_lname = $row['stu_lname'];
         ?>
    <!-- student -->
    <nav  aria-label="breadcrumb" role="navigation">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><?=$user_id." ".$stu_fname." ".$stu_lname?></li>
      </ol>
    </nav>
    <?php }else if($_SESSION["ra_id"] == 1){
        $userID = $_SESSION["user_id"];
        $sql = "SELECT * FROM employee
        WHERE employee.user_id = '$userID'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($result);
        $emp_fname = $row['emp_fname'];
        $emp_lname = $row['emp_lname'];
        ?>
    <!-- teacher -->
    <nav  aria-label="breadcrumb" role="navigation">
      <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><?=$user_id." ".$emp_fname." ".$emp_lname?></li>
      </ol>
    </nav>
      <?php }else if($_SESSION["ra_id"] == 2){
         $userID = $_SESSION["user_id"];
         $sql = "SELECT * FROM employee
         WHERE employee.user_id = '$userID'";
         $result = mysqli_query($conn,$sql);
         $row = mysqli_fetch_assoc($result);
         $emp_fname = $row['emp_fname'];
         $emp_lname = $row['emp_lname'];
         ?>
    <!-- Admin -->
    <nav  aria-label="breadcrumb" role="navigation">
      <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><?=$user_id." ".$emp_fname." ".$emp_lname?></li>
      </ol>
    </nav>
      <?php }else if($_SESSION["ra_id"] == 3){ 
         $userID = $_SESSION["user_id"];
         $sql = "SELECT * FROM employee
         WHERE employee.user_id = '$userID'";
         $result = mysqli_query($conn,$sql);
         $row = mysqli_fetch_assoc($result);
         $emp_fname = $row['emp_fname'];
         $emp_lname = $row['emp_lname'];
         ?>
    <!-- Admin -->
    <nav  aria-label="breadcrumb" role="navigation">
      <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><?=$user_id." ".$emp_fname." ".$emp_lname?></li>
      </ol>
    </nav>
    <?php }
       }else{?>
    <?php }?>
    
<br>
<br>



<br>
<br>
    <div class="container mt-5">
        <center><h1 class="display-5"  style="color: #fe965a;">E-Rigistrar</h1></center>
        <center><h6 style="font-size:20px;" style = "color: #000000;">home page</h6></center>
    </div>
    
</body>
</html>