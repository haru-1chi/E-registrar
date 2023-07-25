<?php
include '../conn.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลรายวิชา</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top" style="background-color: #fe965a;">

        <div class="container">

            <a class="navbar-brand text-light" href="../index.php">ระบบลงทะเบียนเรียน</a>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto justify-content-end">
                    <li class="nav-item <?=$active_admin?>">
                        <a class="nav-link text-light" href="overview.php"></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container py-5">
        <br>
        <div class="col-md-auto">
        <h1 class="text-center" style="color: #fe965a;">แก้ไขข้อมูลรายวิชา</h1><br>
        </div>
            
            <div class="row justify-content-md-center">
                <div class="col col-lg-2"></div>
                <div class="col-md-auto">
                
                <?php
                $id = $_GET['couID'];
                $sql = "SELECT * FROM course
                INNER JOIN sche_employee ON course.sche_Emp_id = sche_employee.sche_Emp_id
                INNER JOIN employee ON sche_employee.user_id = employee.user_id
                WHERE cou_id = $id";
                $query = mysqli_query($conn, $sql);
                $result = mysqli_fetch_array($query, MYSQLI_ASSOC);
                ?>
                    <form action="../funtion/Course_edit.php" method="post">

                        <label style="color: #fe965a;">รหัสวิชา</label>
                        <input type="hidden" type="text" name="cou_id" maxlength="6" require value="<?php echo $result["cou_id"]; ?>">​
                        <?php echo $result["cou_id"]; ?><br>
                        <br>
                        <label style="color: #fe965a;">ชื่อวิชา</label>
                        <input type="text" name="cou_name" value="<?php echo $result["cou_name"];?>" require>

                        <label style="color: #fe965a;">หน่วยกิจ</label>
                        <input type="number" name="cou_num" maxlength="1"  value="<?php echo $result["cou_credit"];?>" require>

                        <label style="color: #fe965a;">จำนวนกลุ่ม</label>
                        <input type="number"  name="cou_sec" value="<?php echo $result["cou_num_of_group"];?>" require><br>
                        <br>
                        <label style="color: #fe965a;">จำนวนที่รับ(ต่อกลุ่ม)</label>
                        <input type="text"  name="cou_secpergroup" value="<?php echo $result["cou_num_of_student"];?>" require> <label style="color: #fe965a;" > คน</label>
                        
                        <label style="color: #fe965a;">อาคารเรียน</label>
                        <input type="text"  name="cou_building" value="<?php echo $result["cou_building"];?>" require></label>

                        <label style="color: #fe965a;">อาจารย์ผู้สอน</label>
                        <select name="sche_Emp_id">
                        <?php $sql = "SELECT * FROM sche_employee
                        INNER JOIN employee ON sche_employee.user_id = employee.user_id";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)): ?>
                        <option value="<?php echo $row['sche_Emp_id']; ?>">
                        <?php echo $row['emp_fname']." ".$row['emp_lname']; ?></option>
                        <?php endwhile; ?>
                        </select>

                        <br>
                        <br>
                        <button style="color: white;" class="btn btn-success" type="submit" name="submit" value="submit">บันทึกข้อมูล</button>
                        <a href="../Course_show.php" class="btn btn-danger">Cancel</a>
                            
                        </div>
                    </form>
                </div>

        </div>


    </body>

</html>