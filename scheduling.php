<?php
session_start();
include 'conn.php';
include "navbar.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดตารางสอนอาจารย์</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</head>

<body>
    <div class="container mt-5">
        <br>
        <div class="col-md-auto">
            <h2 class="text-center py-5" style="color: #fe965a;">จัดตารางเรียน</h2><br>
        </div>
        <div class="row justify-content-md-left">
            <div class="col col-lg-2"></div>
            <div class="col-md-auto">

            <div class="bd-example">
            <table id="regisTable" class="table table-bordered text-center">
                <thead>

            <tbody>
              <tr>
              <?php 
        $sql = "SELECT * FROM course 
		INNER JOIN cou_date_time ON course.cou_id = cou_date_time.cou_id
        INNER JOIN sche_employee ON sche_employee.sche_Emp_id  = course.sche_Emp_id
        INNER JOIN employee ON employee.user_id = sche_employee.user_id
        INNER JOIN faculty ON employee.fac_id = faculty.fac_id 
        INNER JOIN branch ON faculty.fac_id = branch.fac_id";

        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($result);
        ?>      
		<table class="table table-bordered text-center" >
        <thead >
            <tr class="text-white small" style="background-color: grey;">
                <th scope="col">Date/Time</th>
                <th scope="col">08.00-08.50</th>
                <th scope="col">09.00-09.50</th>
                <th scope="col">10.00-10.50</th>
                <th scope="col">11.00-11.50</th>
                <th scope="col">12.00-13.00</th>
                <th scope="col">13.00-13.50</th>
                <th scope="col">14.00-14.50</th>
                <th scope="col">15.00-15.50</th>
                <th scope="col">16.00-16.50</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php
            // loop through each day of the week
            $days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
            foreach ($days as $day) {
                echo "<tr>";
                echo '<th scope="row" style="background-color: silver;" class="text-white small">' . $day . '</th>';
                // loop through each time slot
                $start_time = strtotime('08:00:00');
                $end_time = strtotime('17:00:00');
                while ($start_time < $end_time) {
                    $time_slot = date('H:i:s', $start_time) . '-' . date('H:i:s', strtotime('+50 minutes', $start_time));

                    // get the class schedule for the current day and time slot
                    $sql3 = "SELECT * FROM course 
                                INNER JOIN cou_date_time ON course.cou_id = cou_date_time.cou_id
                                INNER JOIN sche_employee ON sche_employee.sche_Emp_id  = course.sche_Emp_id
                                INNER JOIN employee ON employee.user_id = sche_employee.user_id
                                INNER JOIN faculty ON employee.fac_id = faculty.fac_id 
                                INNER JOIN branch ON faculty.fac_id = branch.fac_id
                                WHERE cdt_date = '{$day}' AND cdt_startTime <= '{$time_slot}' 
                                AND cdt_endTime >= '{$time_slot}'";
                    $result3 = mysqli_query($conn, $sql3);
                    
                    if (mysqli_num_rows($result3) > 0) {
                        // class scheduled for this time slot
                        $row3 = mysqli_fetch_assoc($result3);
                        $class_name = $row3['cou_name'];
                        $lecturer_name = $row3['cou_id'];
                        $emp_name = $row3['emp_fname']." ".$row3['emp_lname'];
                        echo '<td colspan="1" style="background-color: #fe965a;" class="text-white small">' . $class_name . '<br>' . $lecturer_name . '<br>'. $emp_name . '</td>';
                    } else {
                        // no class scheduled for this time slot
                        echo "<td></td>";
                    }
                    $start_time = strtotime('+1 hour', $start_time);
                }
                echo "</tr>";
            }
            ?>
                
                <!-- <td scope="row"><a class="text-gray" style="color: #fe965a;" href="#">ถอน</a></td> -->
              </tr>
              
            </tbody>
          
            </table>
          </div>

            <form action="scheduling_add.php" method="post">
                <label style="color: #fe965a;">ชื่อวิชา</label>
                <select name="cou_id" require>
                <?php $sql = "SELECT * FROM course";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)): ?>
                <option value="<?php echo $row['cou_id']; ?>">
                <?php echo $row['cou_name']; ?></option>
                <?php endwhile; ?>
                </select>
                
                <label style="color: #fe965a;">วัน</label>
                <select name="cdt_date" required>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                </select>
                
                <label style="color: #fe965a;">เริ่ม</label>
                <input type="time" name="cdt_startTime" min="08:00" max="16:50" required>
                <label style="color: #fe965a;">น. ถึง</label>
                <input type="time" name="cdt_endTime" min="08:00" max="16:50" required>
                <label style="color: #fe965a;">น.</label>
                <br>
                <button style="color: white;" class="btn btn-success" type="submit" name="submit" value="submit">บันทึกข้อมูล</button>
                <a href="scheduling.php" class="btn btn-danger">Cancel</a>
            </form>
            

            <table class="table table-bordered text-center" >
            <br><br>
            <span class="fw-bold">วิชาที่กำหนดตารางเรียนแล้ว</span><br>
        <thead>
            <tr class="text-white" style="background-color: #fe965a;">
                <th scope="col">รหัสประจำตัว</th>
                <th scope="col">ชื่อ-นามสกุล</th>
                <th scope="col">รหัสวิชา</th>
                <th scope="col">ชื่อวิชา</th>
                <th scope="col">วัน/เวลา</th>
                <th scope="col"></th>
                <th scope="col"></th>
              </tr>
            </thead>
                <?php 
                $sql = "SELECT * FROM course
                INNER JOIN cou_date_time ON course.cou_id = cou_date_time.cou_id
                INNER JOIN sche_employee ON course.sche_Emp_id = sche_employee.sche_Emp_id
                INNER JOIN employee ON employee.user_id = sche_employee.user_id";
        
                $result = mysqli_query($conn,$sql);
                while ($row = mysqli_fetch_assoc($result)):
              ?>

                <tr>
                    <td>
                        <?php echo $row['user_id']; ?>
                    </td>
                    <td>
                        <?php echo $row['emp_fname']." ".$row['emp_lname']; ?>
                    </td>
                    <td>
                        <?php echo $row['cou_id']; ?>
                    </td>
                    <td>
                        <?php echo $row['cou_name']; ?>
                    </td>
                    <td>
                        <?php echo $row['cdt_date'].' : '.$row['cdt_startTime'].' - '.$row['cdt_endTime']; ?>
                    </td>
                    <td>
                    <a href="JavaScript:if(confirm('Confirm Edit?')==true){window.location='scheduling_edit.php?cdtID=<?php echo $row['cdt_id'];?>';}" class="btn btn-warning">แก้ไข</a>
                    </td>
                    <td>
                    <a href="JavaScript:if(confirm('Confirm Delete?')==true){window.location='scheduling_del.php?cdtID=<?php echo $row['cdt_id'];?>';}" class="btn btn-danger">ลบ</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                </thead>
</div>

<?php mysqli_close($conn); ?>

</body>

</html>
