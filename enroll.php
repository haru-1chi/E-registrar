<!DOCTYPE html>
<html lang="en">
<?php session_start(); ?>
<?php include "navbar.php"; ?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <title>ระบบลงทะเบียนเรียน</title>
</head>
<body>

    <div class="container mt-5">
        <h2 class="text-center py-5"  style="color: #fe965a;">ลงทะเบียนเรียน</h2>
        
        <div style="color:grey;" >
            <span class="fw-bold">รายวิชาที่เลือกอยู่ปัจจุบัน</span>
        </div>
       

        <div class="bd-example">
            <table id="regisTable" class="table table-bordered text-center">
                <thead>
              <tr class="text-white" style="background-color: #fe965a;">
                <th scope="col">รหัสวิชา</th>
                <th scope="col">ชื่อวิชา</th>
                <th scope="col">หน่วยกิต</th>
                <th scope="col">กลุ่ม</th>
                <th scope="col">วัน/เวลา</th>
                <th scope="col">ห้องเรียน</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <tr>
              <!-- แสดงการลงทะเบียน และสามารถถอนรายวิชาตรงนี้ได้ -->
              <?php 
                include 'conn.php';
                $ID = $_SESSION['user_id'];
                $sql = "SELECT * FROM registra 
                INNER JOIN course ON 
                registra.cou_id = course.cou_id
                INNER JOIN cou_date_time ON registra.cou_id = cou_date_time.cou_id 
                WHERE registra.user_id = '$ID'" ;
        
                $result = mysqli_query($conn,$sql);
                while ($row = mysqli_fetch_assoc($result)):
              ?>

                <tr>
                    <td>
                        <?php echo $row['cou_id']; ?>
                    </td>
                    <td>
                        <?php echo $row['cou_name']; ?>
                    </td>
                    <td>
                        <?php echo $row['cou_credit']; ?>
                    </td>
                    <td>
                        <?php echo $row['cou_num_of_group']; ?>
                    </td>
                    <td>
                        <?php echo $row['cdt_date'].' : '.$row['cdt_startTime'].' - '.$row['cdt_endTime']; ?>
                    </td>
                    <td>
                        <?php echo $row['cou_building']; ?>
                    </td>
                    <td><a href="JavaScript:if(confirm('ต้องการถอนใช่หรือไม่?')==true){window.location='funtion/enroll_withdraw.php?userID=
                      <?php echo $row['reg_id'];?>';}" class="btn btn-warning">ถอน</a></td>
                </tr>
                <?php endwhile; ?>
                
                <!-- <td scope="row"><a class="text-gray" style="color: #fe965a;" href="#">ถอน</a></td> -->
              </tr>
              <tr class="text" style="background-color: #ffd3ba;">
                <th scope="col"></th>
                <th scope="col">จำนวนหน่วยกิตรวม</th>
                <th scope="col">
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
            ?>
                </th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
              </tr>
              
            </tbody>
          
            </table>
          </div>
        <!-- Form for searching data V3 HOTFIX--> 
        <!-- Form for searching data -->
<form method="POST" action="">
  <label class="fw-bold">เลือกวิชาที่ต้องการลงทะเบียน:</label>
  <input type="text" name="search_value" >
  <input type="submit" name="search" value="Search">
</form>

<div class="bd-example">
  <table name=""class="table table-bordered text-center">
    <thead>
      <tr class="text-white" style="background-color: #fe965a;">
        <th scope="col">รหัสวิชา</th>
        <th scope="col">ชื่อวิชา</th>
        <th scope="col">หน่วยกิต</th>
        <th scope="col">กลุ่ม</th>
        <th scope="col">วัน/เวลา</th>
        <th scope="col">ห้องเรียน</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      <!-- แสดงวิชาที่มีให้ลงทะเบียน และสามารถลงทะเบียนได้ -->
      <?php
       // ติดต่อกัย ฐานข้อมูล
        include "conn.php";
        if(isset($_POST['search'])) {
          $search_value = $_POST['search_value'];
  // Check if search value is empty, if yes, retrieve all data
        if(empty($search_value)) {
          $sql = "SELECT * FROM course 
          INNER JOIN cou_date_time ON course.cou_id = cou_date_time.cou_id";
          } else {// Query to search for data
          $sql = "SELECT * FROM course 
            INNER JOIN cou_date_time ON course.cou_id = cou_date_time.cou_id
            WHERE course.cou_id LIKE '%$search_value%' OR course.cou_name LIKE '%$search_value%'";
          }
        $result = $conn->query($sql);
        
          // Query to search for data
        $sql = "SELECT * FROM course 
                  INNER JOIN cou_date_time ON course.cou_id = cou_date_time.cou_id
                  WHERE course.cou_id LIKE '%$search_value%' OR course.cou_name LIKE '%$search_value%'";
        $result = $conn->query($sql);
        
          // Checking if any data is found
          if ($result->num_rows > 0) {
            // Outputting each row of data
            while($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>".$row['cou_id']."</td>";
              echo "<td>".$row['cou_name']."</td>";
              echo "<td>".$row['cou_credit']."</td>";
              echo "<td>".$row['cou_num_of_group']."</td>";
              echo "<td>".$row['cdt_date'].' : '.$row['cdt_startTime'].' - '.$row['cdt_endTime']."</td>";
              echo "<td>".$row['cou_building']."</td>";
              echo '<td><a href="JavaScript:if(confirm(\'ยืนยันลงทะเบียน?\')==true){window.location=\'enroll_save.php?couID='.$row['cou_id'].'\';}" class="btn btn-success">ลงทะเบียน</a></td>';
              echo "</tr>";
            }
          } else { // If no data is found
            echo "<tr><td colspan='7'>ไม่พบข้อมูล</td></tr>";
          }
        } else { // If search button is not clicked, show all data
          // Query to retrieve all data from the course and cou_date_time tables
          $sql = "SELECT * FROM course 
                  INNER JOIN cou_date_time ON course.cou_id = cou_date_time.cou_id";
          $result = $conn->query($sql);
        
          // Checking if any data is found
          if ($result->num_rows > 0) {
            // Outputting each row of data
            while($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>".$row['cou_id']."</td>";
              echo "<td>".$row['cou_name']."</td>";
              echo "<td>".$row['cou_credit']."</td>";
              echo "<td>".$row['cou_num_of_group']."</td>";
              echo "<td>".$row['cdt_date'].' : '.$row['cdt_startTime'].' - '.$row['cdt_endTime']."</td>";
              echo "<td>".$row['cou_building']."</td>";
              echo '<td><a href="JavaScript:if(confirm(\'ยืนยันลงทะเบียน?\')==true){window.location=\'enroll_save.php?couID='.$row['cou_id'].'\';}" class="btn btn-success">ลงทะเบียน</a></td>';
              echo "</tr>";
            }
          } else { // If no data is found
            echo "<tr><td colspan='7'>ไม่พบข้อมูล</td></tr>";
          }
        }
            ?>
        </tbody>
    </table>
</div>
            </tr>
            </thead>
            <tr class="text" style="background-color: #ffd3ba;">
              <th scope="col"></th>
              <th scope="col"></th>
              <th scope="col"></th>
              <th scope="col"></th>
              <th scope="col"></th>
              <th scope="col"></th>
              <th scope="col"></th>
            </tr>
          </tbody>
          </table>
        </div>
    </div>
</body>
</html>