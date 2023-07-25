<div class="container">
  <nav class="navbar navbar-expand-lg fixed-top" style="background-color: #fe965a;">
    <div class="container">
      <a class="navbar-brand text-light" href="./index.php">ระบบลงทะเบียนเรียน</a>
      
    <?php
    if(isset($_SESSION["ra_id"])){

      if($_SESSION["ra_id"] == 4){ 

         ?>
    <!-- student -->
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="navbar-brand text-light" href="enroll.php">ลงทะเบียนเรียน</a>
          </li>
          <li class="nav-item">
            <a class="navbar-brand text-light" href="stu_table.php">ตารางเรียน</a>
          </li>
          <li class="nav-item">
            <a class="navbar-brand text-light" href="grade.php">ผลการเรียน</a>
          </li>
          <li class="nav-item">
            <a class="navbar-brand text-light" href="logout.php">ออกจากระบบ</a>
          </li>
        </ul>
      </div>
    <?php }else if($_SESSION["ra_id"] == 1){ ?>
    <!-- teacher -->
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="navbar-brand text-light" href="emp_table.php">ตารางสอนอาจารย์</a>
          </li>
          <li class="nav-item">
              <a class="navbar-brand text-light" href="namelist_std.php">ข้อมูลรายวิชาที่สอน</a>
            </li>
          <li class="nav-item">
            <a class="navbar-brand text-light" href="fill_in_stu_scores.php">กรอกคะแนน</a></li>
          <li class="nav-item">
            <a class="navbar-brand text-light" href="logout.php">ออกจากระบบ</a>
          </li>
        </ul>
      </div>
      <?php }else if($_SESSION["ra_id"] == 2){ ?>
    <!-- Admin -->
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="navbar-brand text-light" href="stu_show.php">ข้อมูลนิสิต</a>
          </li>
          <li class="nav-item">
              <a class="navbar-brand text-light" href="emp_show.php">ข้อมูลพนักงาน</a>
            </li>
          <li class="nav-item">
            <a class="navbar-brand text-light" href="Course_show.php">ข้อมูลรายวิชา</a>
          </li>
          <li class="nav-item">
            <a class="navbar-brand text-light" href="scheduling.php">จัดตารางเรียน</a>
          </li>
          <li class="nav-item">
            <a class="navbar-brand text-light" href="logout.php">ออกจากระบบ</a>
          </li>
        </ul>
      </div>
      <?php }else if($_SESSION["ra_id"] == 3){ ?>
    <!-- Admin -->
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
              <a class="navbar-brand text-light" href="stat2.php">สถิติภายในมหาวิทยาลัย</a>
            </li>
          <li class="nav-item">
            <a class="navbar-brand text-light" href="logout.php">Log-Out</a>
          </li>
        </ul>
      </div>
    <?php }
       }else{?>
      <!-- orther -->
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="navbar-brand text-light" href="Course_show_index.php">โครงสร้างหลักสูตร</a>
            </li>
            <li class="nav-item">
                <a class="navbar-brand text-light" href="login-page.php">เข้าสู่ระบบ</a>
            </li>
          </ul>
        </div>

    <?php }?>
    </div>
  </nav>
</div>  
