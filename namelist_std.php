<?php
session_start(); 
include 'conn.php';
include "navbar.php";
error_reporting(E_ERROR | E_PARSE);
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
    <title>รายชื่อนิสิตที่ลงทะเบียนเรียน</title>
</head>

<body>
<?php 
          include 'conn.php';
          $teacherID = $_SESSION["user_id"];
          $sql = "SELECT *, student.user_id AS stu_user_id FROM registra
          INNER JOIN student ON registra.user_id = student.user_id
          INNER JOIN faculty ON student.fac_id = faculty.fac_id
          INNER JOIN branch ON student.branch_id = branch.branch_id
          INNER JOIN course ON registra.cou_id = course.cou_id
          INNER JOIN sche_employee ON course.sche_Emp_id = sche_employee.sche_Emp_id
          INNER JOIN cou_date_time ON registra.cou_id = cou_date_time.cou_id
          WHERE sche_employee.user_id = '$teacherID'";
          $result = mysqli_query($conn,$sql);
          $row = mysqli_fetch_assoc($result);
          $cou_id = $row['cou_id'];
          $cou_name = $row['cou_name'];
          ?>
    <div class="container mt-5">
        <h2 class="text-center py-5"  style="color: #fe965a;">รายชื่อนิสิตที่ลงทะเบียนเรียน</h2>

        <div class="bd-example">
            <table class="table table-bordered text-center">
                <thead>
            <tr class="text-white" style="background-color: #fe965a;">
                <th scope="col">ลำดับ</th>
                <th scope="col">รหัสนิสิต</th>
                <th scope="col">ชื่อ-นามสกุล</th>
                <th scope="col">คณะ</th>
                <th scope="col">สาขา</th>
                <th scope="col">วิชาที่เรียน</th>
            </tr>
            </thead>
            <tbody>
            <tr>

              <?php 
                include 'conn.php';
                $teacherID = $_SESSION["user_id"];
                $sql = "SELECT *, student.user_id AS stu_user_id FROM registra
                INNER JOIN student ON registra.user_id = student.user_id
                INNER JOIN faculty ON student.fac_id = faculty.fac_id
                INNER JOIN branch ON student.branch_id = branch.branch_id
                INNER JOIN course ON registra.cou_id = course.cou_id
                INNER JOIN sche_employee ON course.sche_Emp_id = sche_employee.sche_Emp_id
                INNER JOIN cou_date_time ON registra.cou_id = cou_date_time.cou_id
                WHERE sche_employee.user_id = '$teacherID'";
                $result = mysqli_query($conn,$sql);
                $i = 0;
                while ($row = mysqli_fetch_assoc($result)):
              $i++;
              ?>

                <tr>
                    <td>
                    <?=$i;?>
                    </td>
                    <td>
                        <?php echo $row['stu_user_id']; ?>
                    </td>
                    <td>
                        <?php echo $row['stu_fname'].' '.$row['stu_lname']; ?>
                    </td>
                    <td>
                        <?php echo $row['fac_name']; ?>
                    </td>
                    <td>
                        <?php echo $row['branch_name']; ?>
                    </td>
                    <td>
                        <?php echo $row['cou_name']; ?>
                    </td>
                    
                </tr>
                <?php endwhile; ?>
              </tr>
            </tbody>
        
            </table>
        </div>

        
    </div>



</body>

</html>