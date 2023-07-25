<?php
include 'conn.php';
session_start(); 
$txtKeyword = "";
if(isset($_GET['txtKeyword'])){
    $txtKeyword = $_GET['txtKeyword'];
} else {
    $_GET['txtKeyword'] = "";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลนิสิต</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</head>

<body>


<?php include "navbar.php"; ?>
    <div class="container py-5">
        <br>
        <div class="col-md-auto">
            <h1 class="text-center" style="color: #fe965a;">ข้อมูลนิสิต</h1><br>
        </div>

        <form class="d-flex" method="get">
        <input class="form-control me-2" type="text" placeholder="ค้นหา" aria-label="Search" name="txtKeyword" value="<?=$txtKeyword?>">
        <button class="btn btn-outline-success" type="submit">ค้นหา</button>
        
    </form>
    <br>
    <a href="form/stu_addForm.php" class="btn btn-success">เพิ่มข้อมูลนิสิต</a>

        <?

        ?>
        <table class="table">
            <thead>
                <tr>
                    <th class="col-1">รหัสนิสิต</th>
                    <th class="col-1">ชื่อจริง</th>
                    <th class="col-1">นามสกุล</th>
                    <th>เพศ</th>
                    <th>คณะ</th>
                    <th>สาขา</th>
                    <th class="col-1">วันเกิด</th>
                    <th>อายุ</th>
                    <th>โทรศัพท์</th>
                    <th class="col-1">อีเมล</th>
                    <th class="col-1">ที่อยู่</th>
                    <th class="col-5">อาจารย์ที่ปรึกษา</th>
                    <th class="col-1">แก้ไข</th>
                    <th class="col-1">ลบ</th>
                </tr>
            </thead>
            <tbody>
                <?php $sql = "SELECT * ,student.user_id AS student_user_id FROM student
                INNER JOIN employee ON
                student.advicer_id = employee.user_id
                INNER JOIN faculty ON 
                student.fac_id = faculty.fac_id
                INNER JOIN branch ON 
                student.branch_id = branch.branch_id
                WHERE (student.user_id LIKE '%".$_GET["txtKeyword"]."%' or branch_name LIKE '%".$_GET["txtKeyword"]."%' 
                or fac_name LIKE '%".$_GET["txtKeyword"]."%' or stu_gender LIKE '%".$_GET["txtKeyword"]."%'
                or stu_fname LIKE '%".$_GET["txtKeyword"]."%'
                or stu_lname LIKE '%".$_GET["txtKeyword"]."%' 
                or emp_fname LIKE '%".$_GET["txtKeyword"]."%'
                or emp_lname LIKE '%".$_GET["txtKeyword"]."%'
                )";
                

                $result = mysqli_query($conn,$sql);
                while ($row = mysqli_fetch_assoc($result)): 
                    
                $birthdate = $row['stu_birth'];
                // Create a DateTime object for the birthdate
                $dob = new DateTime($birthdate);

                // Get the current date
                $now = new DateTime();

                // Calculate the difference between the birthdate and the current date
                $diff = $now->diff($dob);

                // Get the age from the difference object
                $age = $diff->y;
                ?>
                <tr>
                    <td>
                        <?php echo $row['student_user_id']; ?>
                    </td>
                    <td>
                        <?php echo $row['stu_fname']; ?>
                    </td>
                    <td>
                        <?php echo $row['stu_lname']; ?>
                    </td>
                    <td>
                        <?php echo $row['stu_gender']; ?>
                    </td>
                    <td>
                        <?php echo $row['fac_name']; ?>
                    </td>
                    <td>
                        <?php echo $row['branch_name']; ?>
                    </td>
                    <td>
                        <?php echo $row['stu_birth']; ?>
                    </td>
                    <td>
                        <?php echo $age; ?>
                    </td>
                    <td>
                        <?php echo $row['stu_phone']; ?>
                    </td>
                    <td>
                        <?php echo $row['stu_email']; ?>
                    </td>
                    <td>
                        <?php echo $row['stu_address']; ?>
                    </td>
                    <td>

                    <?php echo $row['emp_fname']; ?>
                    <?php echo $row['emp_lname']; ?>


                    </td>
                    <td><a href="JavaScript:if(confirm('Confirm Edit?')==true){window.location='form/stu_editForm.php?userID=<?php echo $row['student_user_id'];?>';}" class="btn btn-warning">แก้ไข</a></td>
                    <td><a href="JavaScript:if(confirm('Confirm Delete?')==true){window.location='funtion/stu_del.php?userID=<?php echo $row['student_user_id'];?>';}" class="btn btn-danger">Delete</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>



    </div>



</body>

</html>