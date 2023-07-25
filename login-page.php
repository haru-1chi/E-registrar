<?php
session_start();

// check if the form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // include database connection
    require_once "conn.php";

    // get input values
    $user_id = mysqli_real_escape_string($conn,$_POST['user_id']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    // create sql query to select user from database
    $sql = "SELECT * FROM user WHERE user_id = '$user_id' AND password = '$password' LIMIT 1";
    
    // execute sql query
    $result = mysqli_query($conn,$sql);
    // check if user exists
    $user = mysqli_fetch_assoc($result);

        // store user data in session variables
        $_SESSION["user_id"] = $user_id;
        $_SESSION["ra_id"] = $user['ra_id'];

        if(!is_null($user)){
          switch ($_SESSION['ra_id']) {
            case 1:
              $_SESSION["ra_id"] = $user['ra_id'];
              $_SESSION["id"] = $user->user_id; 
                header("location: index.php");
                break;
            case 2:
              $_SESSION["ra_id"] = $user['ra_id'];
              $_SESSION["id"] = $user->user_id; 
                header("location: index.php");
                break;
            case 3:
              $_SESSION["ra_id"] = $user['ra_id'];
              $_SESSION["id"] = $user->user_id; 
                header("location: index.php");
                break;
            case 4:
              $_SESSION["ra_id"] = $user['ra_id'];
              $_SESSION["id"] = $user->user_id; 
                header("location: index.php");
                break;
            default:
          }
        }else{
          $_SESSION["check"] = 0;
        }
        // redirect to dashboard page based on user's role
    // close database connection
    mysqli_close($conn);
}
?>



<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <title>เข้าสู่ระบบ</title>
</head>

<body>
<?php include "navbar.php"; ?>
  <br><br><br><br><br>





  <div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <h2 class="text-center mb-4" style="color: #fe965a;">เข้าสู่ระบบ</h2>
      <?php if(isset($_SESSION["check"])){ unset($_SESSION["check"]) ?>
         <div class="alert alert-danger" role="alert">
           Username และ Password ไม่ถูกต้อง!
         </div> <?php }?>

      <form method="POST" action="">
        <div class="form-group">
          <label for="user_id">รหัสประจำตัว</label>
          <input type="text" name="user_id" id="user_id" class="form-control" placeholder="รหัสประจำตัว" required>
        </div>
        <div class="form-group">
          <label for="password">รหัสผ่าน</label>
          <input type="password" name="password" id="password" class="form-control" placeholder="รหัสผ่าน" required>
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
        </div>
      </form>
      
    </div>
  </div>
</div>


  </body>
</html>
