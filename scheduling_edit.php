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
    <title>แก้ไขข้อมูลนิสิต</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</head>

<body>
    
    <div class="container py-5">
        <br>
        <div class="col-md-auto">
            <h1 class="text-center" style="color: #fe965a;">แก้ไขตารางเรียน</h1><br>
        </div>
        <div class="row justify-content-md-center">
            <div class="col col-lg-2"></div>
            <div class="col-md-auto">

            <?php
            $id = $_GET['cdtID'];
            $sql = "SELECT * FROM course
                INNER JOIN cou_date_time ON course.cou_id = cou_date_time.cou_id
                INNER JOIN sche_employee ON course.sche_Emp_id = sche_employee.sche_Emp_id
                INNER JOIN employee ON employee.user_id = sche_employee.user_id
                WHERE cdt_id = '$id'";
            $query = mysqli_query($conn,$sql);
            $result = mysqli_fetch_array($query,MYSQLI_ASSOC);
            ?>

        <form action="scheduling_edit_save.php" method="post">
        <input type="hidden" type="text" name="cdt_id" require value="<?php echo $result["cdt_id"]; ?>">​
        <label style="color: #fe965a;">รหัสวิชา</label>
        <input type="hidden" type="text" name="cou_id" maxlength="6" require value="<?php echo $result["cou_id"]; ?>">​
                        <?php echo $result["cou_id"]; ?><br>

            <label style="color: #fe965a;">ชื่อวิชา</label>
            <?php echo $result["cou_name"]; ?>
            <br>

            <label style="color: #fe965a;">วัน</label>
                <select name="cdt_date" required>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                </select><br>

            <label style="color: #fe965a;">เริ่ม</label>
            <input type="time" name="cdt_startTime" min="08:00" max="16:50" required>
            <label style="color: #fe965a;">น. ถึง</label>
            <input type="time" name="cdt_endTime" min="08:00" max="16:50" required>
            <label style="color: #fe965a;">น.</label>

            <br>
            <br>

            <button style="color: white;" class="btn btn-success" type="submit" name="submit" value="submit">บันทึกข้อมูล</button>
            <a href="scheduling.php" class="btn btn-danger">Cancel</a>
            </form>
            
</div>

<?php mysqli_close($conn); ?>

</body>

</html>