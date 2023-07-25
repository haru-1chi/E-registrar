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
    <title>แสดงข้อมูลพนักงาน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
<?php include "navbar.php"; ?>
<div class="container-fluid py-5">
        <br>
        <div class="col-md-auto">
            <h1 class="text-center" style="color: #fe965a;">ข้อมูลพนักงาน</h1><br>
        </div>

        <form class="d-flex" method="get">
        <input class="form-control me-2" type="text" placeholder="ค้นหา" aria-label="Search" name="txtKeyword" value="<?=$txtKeyword?>">
        <button class="btn btn-outline-success" type="submit">ค้นหา</button>
    </form>
    <br>
    <a href="form/emp_addForm.php" class="btn btn-success" >เพิ่มข้อมูลพนักงาน</a>


        <table class="table">
            <thead>
                <tr>
                    <th class="col-1">รหัสประจำตัว</th>
                    <th class="col-1">ชื่อ</th>
                    <th class="col-1">นามสกุล</th>
                    <th>ตำแหน่ง</th>
                    <th>เบอร์</th>
                    <th>อายุ</th>
                    <th>วันแรกที่ทำงาน</th>
                    <th class="col-1">อีเมล</th>
                    <th class="col-1">ที่อยู่</th>
                    <th class="col-1">คณะ</th>
                    <th class="col-1">แก้ไข</th>
                    <th class="col-1">ลบ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM employee
                INNER JOIN faculty ON 
                employee.fac_id = faculty.fac_id
                WHERE (user_id LIKE '%".$_GET["txtKeyword"]."%' or fac_name LIKE '%".$_GET["txtKeyword"]."%' or emp_gender LIKE '%".$_GET["txtKeyword"]."%' )";
                $result = mysqli_query($conn,$sql);
                while ($row = mysqli_fetch_assoc($result)): 

                $birthdate = $row['emp_birth'];
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
                        <?php echo $row['user_id']; ?>
                    </td>
                    <td>
                        <?php echo $row['emp_fname']; ?>
                    </td>
                    <td>
                        <?php echo $row['emp_lname']; ?>
                    </td>
                    <td>
                        <?php
                        if($row['ra_id'] == 1){echo 'อาจารย์';}
                        else if($row['ra_id'] == 2){echo 'ฝ่ายทะเบียน';}
                        else if($row['ra_id'] == 3){echo 'อธิการบดี';}
                        ?>
                    </td>
                    <td>
                        <?php echo $row['emp_phone']; ?>
                    </td>
                    <td>
                        <?php echo $age; ?>
                    </td>
                    <td>
                        <?php echo $row['emp_enroll']; ?>
                    </td>
                    <td>
                        <?php echo $row['emp_email']; ?>
                    </td>
                    <td>
                        <?php echo $row['emp_address']; ?>
                    </td>
                    <td>
                        <?php echo $row['fac_name']; ?>
                    </td>
                    <td ><a href="JavaScript:if(confirm('Confirm Edit?')==true){window.location='form/emp_editForm.php?userID=<?php echo $row['user_id'];?>';} "class="btn btn-warning">Edit</a></td>
                    <td ><a href="JavaScript:if(confirm('Confirm Delete?')==true){window.location='funtion/emp_delete.php?userID=<?php echo $row['user_id'];?>';}"class="btn btn-danger">Delete</a></td>
                
                
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
  


    </div>





</body>

</html>
