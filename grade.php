<?php
include 'conn.php';
session_start(); 
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
    <title>ผลการเรียน</title>
</head>

<body>
<?php include "navbar.php"; ?>
    <br><br><br><br>
<center><h2 class="display-7 " style="color: #fe965a;">ผลการเรียน</h2><br>
    <div class="bd-example">
        <style>
            table#t45 {
                width :80%;
            }
            </style>
        <table id="t45">
            <thead>
                <th class="text-white" style="background-color: #fe965a;" colspan="4">ภาคเรียนที่ 1/2565</th>
                <tr class="text-white" style="background-color: grey;"></tr>
                <tr class="text-center" style="background-color: #ffe2d3;">
                    <th scope="col">รหัสวิชา</th>
                    <th scope="col">ชื่อวิชา</th>
                    <th scope="col">หน่วยกิต</th>
                    <th scope="col">เกรด</th>
                </tr>
            </thead>

        <tbody class="text-center">
          <tr>
            <?php 
                include 'conn.php';
                $ID = $_SESSION['user_id'];
                $sql = "SELECT * FROM registra
                INNER JOIN student ON 
                registra.user_id = student.user_id
                INNER JOIN course ON 
                registra.cou_id = course.cou_id
                INNER JOIN cou_date_time ON registra.cou_id = cou_date_time.cou_id                
                WHERE registra.user_id = '$ID'" ;
                $result = mysqli_query($conn,$sql);
                while ($row = mysqli_fetch_assoc($result)):
              ?>
            <td><?php echo $row['cou_id']; ?></td>
            <td><?php echo $row['cou_name']; ?></td>
            <td><?php echo $row['cou_credit']; ?></td>
            <td><?php echo $row['grade']; ?></td>
          </tr>
          <?php endwhile; ?>
          <tr>
            <th style="background-color: #ffe2d3;"></th>
            <th style="background-color: #ffe2d3;"></th>
            <td style="background-color: #ffe2d3;">รวมหน่วยกิต</td>
            <td style="background-color: #ffe2d3;">GPA</td>
          </tr>  
          <tr>
            <th></th>
            <th></th>

            <td>
            <?php
            $result = mysqli_query($conn,"SELECT SUM(cou_credit) AS total_credit FROM registra
            INNER JOIN student ON 
            registra.user_id = student.user_id
            INNER JOIN course ON 
            registra.cou_id = course.cou_id                
            WHERE registra.user_id = '$ID'") or die(mysqli_error($conn));
            $row = mysqli_fetch_assoc($result);
            $sum_credit = $row['total_credit'];
            echo $row['total_credit'];

            
            ?></td>

            <td>
            <?php
            $result = mysqli_query($conn,"SELECT student.stu_gpa FROM student WHERE student.user_id = '$ID'");
            $row = mysqli_fetch_assoc($result);
            echo number_format($row['stu_gpa'],2);
            ?>
            </td>
            
          </tr> 
        </tbody>
        </table>
<br>     
        <br>
    </div>
    </center>
    </body>
</html>