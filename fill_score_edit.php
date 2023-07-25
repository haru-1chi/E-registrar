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
    <title>กรอกคะแนนนิสิต</title>
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
            <h1 class="text-center" style="color: #fe965a;">กรอกคะแนนนิสิต</h1><br>
        </div>
        <div class="row justify-content-md-center">
            <div class="col col-lg-2"></div>
            <div class="col-md-auto">

            <?php
            $id = $_GET['reg_id'];
            $sql = "SELECT * FROM registra
                INNER JOIN student ON 
                registra.user_id = student.user_id
                INNER JOIN course ON 
                registra.cou_id = course.cou_id
                INNER JOIN faculty ON 
                student.fac_id = faculty.fac_id
                INNER JOIN branch ON 
                student.branch_id = branch.branch_id
                WHERE reg_id = '$id'";
            $query = mysqli_query($conn,$sql);
            $result = mysqli_fetch_array($query,MYSQLI_ASSOC);
            ?>
        <form action="fill_score_save.php" method="post">
        <input type="hidden" type="text" name="reg_id" require value="<?php echo $result["reg_id"]; ?>">​
        <label style="color: #fe965a;">รหัสนิสิต</label>
        <input type="hidden" type="text" name="user_id" require value="<?php echo $result["user_id"]; ?>">​
            <?php echo $result["user_id"];?>
            <br>

            <label style="color: #fe965a;">ชื่อ</label>
            <?php echo $result['stu_fname'].' '.$result['stu_lname'];?><br>

            <label style="color: #fe965a;">คณะ</label>
            <?php echo $result["fac_name"];?><br>
            <label style="color: #fe965a;">สาขา</label>
            <?php echo $result["branch_name"];?><br>
            <label style="color: #fe965a;">วิชาที่เรียน</label>
            <?php echo $result["cou_name"];?><br>
            <label style="color: #fe965a;">คะแนน</label>
            <input type="number" name="reg_score" value="<?php echo $result["reg_score"];?>" max="100" required>

            <br>
            <br>

            <button style="color: white;" class="btn btn-success" type="submit" name="submit" value="submit">บันทึกข้อมูล</button>
            <a href="fill_in_stu_scores.php" class="btn btn-danger">Cancel</a>
            </form>
            
</div>

<?php mysqli_close($conn); ?>

</body>

</html>