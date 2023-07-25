<?php
include '../conn.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลพนักงาน</title>
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
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item <?=$active_admin?>">
                        <a class="nav-link text-light" href="login-page.php"></a>
                    </li>
                    <li class="nav-item <?=$active_admin?>">
                        <a class="nav-link text-light" href="login-page.php"></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container py-5">
        <br>
        <div class="col-md-auto">
            <h1 class="text-center" style="color: #fe965a;">เพิ่มข้อมูลพนักงาน</h1><br>
        </div>
        <div class="row justify-content-md-center">
            <div class="col col-lg-2"></div>
            <div class="col-md-auto">


            <form action="../funtion/emp_add.php" method="post">

                <label style="color: #fe965a;" >รหัส:</label>
                <input type="text" name="user_id" maxlength="8" required><br>
                <br>
                <label style="color: #fe965a;">ชื่อ</label>
                <input type="text" name="fname" required>

                <label style="color: #fe965a;">นามสกุล</label>
                <input type="text" name="lname" required>

                <label style="color: #fe965a;">เพศ</label>
                <select name="gender" id="gender" required>
                    <option value="ชาย">ชาย</option>
                    <option value="หญิง">หญิง</option>
                    <option value="อื่นๆ">อื่นๆ</option>
                </select>

                <label style="color: #fe965a;">วัน/เดือน/ปีเกิด</label>
                <input type="date" name="birth" min="1960-01-01" max="2001-01-01"required><br>
                <br>

                <label style="color: #fe965a;">คณะ</label>
                <select name="fac_id" require>
                <?php $sql = "SELECT * FROM faculty";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)): ?>

                <option value="<?php echo $row['fac_id']; ?>">
                <?php echo $row['fac_name']; ?></option>

                <?php endwhile; ?>
                </select>

                <label style="color: #fe965a;">ตำแหน่ง</label>
                <select name="rank" id="gender" required>
                    <option value=1>อาจารย์</option>
                    <option value=2>ฝ่ายทะเบียน</option>
                    <option value=3>อธิการบดี</option>
                </select>

                <label style="color: #fe965a;">วันที่เริ่มทำงาน</label>
                <input type="date" name="enroll" min="2022-01-01" required><br><br>
                

                <label style="color: #fe965a;">โทรศัพท์</label>
                <input type="tel" name="phone" maxlength="10" pattern="[0-9]{3}[0-9]{3}[0-9]{4}"required><br><br>

                <label style="color: #fe965a;">email</label>
                <input type="email" name="email" required>
                <br><br>
                <label style="color: #fe965a;">ที่อยู่</label><br>
                <input type="text"style="width:200px; height:80px;" name="address" required>
                <br>
                <br>
                
                <button style="color: white;" class="btn btn-success" type="submit" name="submit" value="submit">บันทึกข้อมูล</button>
                <a href="../emp_show.php" class="btn btn-danger">Cancel</a>
            </form>
</div>

<?php mysqli_close($conn); ?>

</body>

</html>
