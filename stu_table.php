<?php
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
            .fs-6 p{
                margin-top: -15px;
            }
    </style>
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
<?php 
        include 'conn.php';
        $ID = $_SESSION["user_id"];
        $sql = "SELECT * FROM student 
                INNER JOIN faculty ON student.fac_id = faculty.fac_id
                INNER JOIN branch ON student.branch_id = branch.branch_id
                INNER JOIN employee ON student.advicer_id = employee.user_id 
                WHERE student.user_id = '$ID'";
        
        $result = mysqli_query($conn,$sql);
        // $i = 0;
        // while ($row = mysqli_fetch_assoc($result)):
        $row = mysqli_fetch_assoc($result)
        // $i++;
        ?>
        <div class="container mt-5">
        <h2 class="text-center py-5"  style="color: #fe965a;">ตารางเรียน</h2>
        
        <div style="color:black;" >
            <span class="fw-bold">ชื่อ</span> &emsp;&emsp; <span><?php echo $row['stu_fname'].' '.$row['stu_lname']?></span><br>
            <span class="fw-bold">คณะ</span> &emsp;&nbsp; <span><?php echo $row['fac_name']?></span><br>
            <span class="fw-bold">สาขา</span> &emsp; <span><?php echo $row['branch_name']?></span><br>
            <span class="fw-bold">อาจารย์ที่ปรึกษา</span> &emsp; <span><?php echo $row['emp_fname'].' '.$row['emp_lname']; ?></span><br><br>
            <span class="fw-bold">รายวิชาที่ลงทะเบียนไว้แล้ว</span><br>
        </div>
        
        <div class="container">
		<table class="table table-bordered text-center">
        <thead>
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
                    $sql3 = "SELECT * FROM registra
                            INNER JOIN student ON registra.user_id = student.user_id
                            INNER JOIN faculty ON student.fac_id = faculty.fac_id
                            INNER JOIN branch ON student.branch_id = branch.branch_id
                            INNER JOIN course ON registra.cou_id = course.cou_id
                            INNER JOIN cou_date_time ON registra.cou_id = cou_date_time.cou_id
                            INNER JOIN employee ON student.advicer_id = employee.user_id 
                            WHERE cdt_date = '{$day}' AND cdt_startTime <= '{$time_slot}' 
                            AND cdt_endTime >= '{$time_slot}' AND registra.user_id = '$ID'";
                    $result3 = mysqli_query($conn, $sql3);
                    
                    if (mysqli_num_rows($result3) > 0) {
                        // class scheduled for this time slot
                        $row3 = mysqli_fetch_assoc($result3);
                        $class_name = $row3['cou_name'];
                        $lecturer_name = $row3['cou_id'];
                        echo '<td colspan="1" style="background-color: #fe965a;" class="text-white small">' . $class_name . '<br>' . $lecturer_name . '</td>';
                    } else {
                        // no class scheduled for this time slot
                        echo "<td></td>";
                    }
                    $start_time = strtotime('+1 hour', $start_time);
                }
                echo "</tr>";
            }
            ?>
        </tbody>
        </table>
	</div>
	<!-- Bootstrap JS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>