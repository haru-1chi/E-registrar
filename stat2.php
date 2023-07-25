<?php
session_start();
include 'conn.php';
include 'navbar.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.min.js"
        integrity="sha512-v3ygConQmvH0QehvQa6gSvTE2VdBZ6wkLOlmK7Mcy2mZ0ZF9saNbbk19QeaoTHdWIEiTlWmrwAL4hS8ElnGFbA=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
        </script>
    <title>E-Registrar</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body>
    <br><br><br>
    <div class='container'>
        <div class="d-flex justify-content-end">
            <h5 class='px-2' id='chartSw'>สถิติการลงทะเบียน</h5>

            <form action="#">
                <label style="color: #fe965a;">คณะ</label>
                <select name="faculty" id="facultySelect">
                    <option value="">ทั้งหมด</option>
                    <?php
                    $sql = "SELECT * FROM faculty ";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)):
                        ?>
                        <option value="<?php echo $row['fac_id']; ?>">
                            <?php echo $row['fac_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label style="color: #fe965a;">สาขา</label>
                <select name="branch" id="branchSelect">
                    <option value="">ทั้งหมด</option>
                    <?php
                    $sql = "SELECT * FROM branch ";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)):
                        ?>
                        <option value="<?php echo $row['branch_id']; ?>">
                            <?php echo $row['branch_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label style="color: #fe965a;">ผู้สอน</label>
                <select name="emp" id="emp">
                    <option value='0'>ทั้งหมด</option>
                    <?php
                    $sqlem = "SELECT * FROM employee WHERE employee.ra_id = '1'";
                    $resultem = mysqli_query($conn, $sqlem);
                    while ($rowem = mysqli_fetch_assoc($resultem)):
                        ?>
                        <option value="<?php echo $rowem['user_id']; ?>">
                            <?php echo $rowem['emp_fname'] . ' ' . $rowem['emp_lname']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label style="color: #fe965a;" style="display: none;">&nbsp;&nbsp;</label>
                <select name="gender" id='gender' style="display: none;">
                    <option value="all">ทั้งหมด</option>
                    <option value="men">ชาย</option>
                    <option value="women">หญิง</option>
                </select>

                <button style="color: white;" class="btn btn-success" type="submit" name="submit" value="submit"
                    id="chartSubmit" onclick="drawChart()">ตกลง</button>
            </form>

            <div class="btn-group" role="group" aria-label="Google Charts">
                <button type="button" class="btn btn-primary" value='combo' onclick="switchToComboChart()">
                    <?php ?>Combo Chart
                </button>
                <button type="button" class="btn btn-secondary" value='donut' onclick="switchToDonutChart()">
                    <?php ?>Donut Chart
                </button>
                <button type="button" class="btn btn-info" value='area' onclick="switchToAreaChart()">
                    <?php ?>Area Chart
                </button>
            </div>


            <br>
        </div>
        <?php
        $txtKeyword = '';

        if (isset($_GET['txtKeyword'])) {
            $txtKeyword = $_GET['txtKeyword'];
        }

        $faculty = '';
        $branch = '';
        $emp = 0;
        $gender = '';

        if (isset($_GET['faculty'])) {
            $faculty = $_GET['faculty'];
        }
        if (isset($_GET['branch'])) {
            $branch = $_GET['branch'];
        }
        if (isset($_GET['emp'])) {
            $emp = $_GET['emp'];
        }
        if (isset($_GET['gender'])) {
            $gender = $_GET['gender'];
        }
        if (isset($_GET['submit'])) {
            $submit = $_GET['submit'];
        }

        $sqlnew = "SELECT * FROM registra
            INNER JOIN course ON registra.cou_id = course.cou_id 
            INNER JOIN student ON student.user_id = registra.user_id 
            INNER JOIN sche_employee ON sche_employee.sche_Emp_id = course.sche_Emp_id
            INNER JOIN employee ON sche_employee.user_id = employee.user_id
            INNER JOIN faculty ON faculty.fac_id = employee.fac_id
            INNER JOIN branch ON student.branch_id = branch.branch_id 
            WHERE 1=1 ";

        if (!empty($faculty)) {
            $sqlnew .= " AND faculty.fac_id = '$faculty'";
        }

        if (!empty($branch)) {
            $sqlnew .= " AND branch.branch_id = '$branch'";
        }

        if (!empty($emp)) {
            $sqlnew .= " AND employee.user_id = '$emp'";
        }

        $resultnew = mysqli_query($conn, $sqlnew);

        $sql_gender_count = "SELECT COUNT(*) as male_count, (SELECT COUNT(*) FROM student WHERE stu_gender = 'หญิง') as female_count FROM student WHERE stu_gender = 'ชาย'";
        $result_gender_count = mysqli_query($conn, $sql_gender_count);
        $row_gender_count = mysqli_fetch_assoc($result_gender_count);

        $rowCount_male = $row_gender_count['male_count'];
        $rowCount_female = $row_gender_count['female_count'];

        $data = array();
        if ($gender == 'all') {

            $grouped_data = array();
            $grades_total = array();

            while ($rownew = mysqli_fetch_assoc($resultnew)) {
                $cou_name = $rownew['cou_name'];


                if (!isset($grouped_data[$cou_name])) {

                    $grouped_data[$cou_name] = array(
                        'Grade in Class' => 0,
                        'Year class' => 0,
                        'men' => 0,
                        'women' => 0
                    );
                    $grades_total[$cou_name] = 0;
                }


                $grouped_data[$cou_name]['Grade in Class'] += (int) $rownew['grade'];
                $grades_total[$cou_name] += (int) $rownew['grade'];


                $grouped_data[$cou_name]['Year class']++;


                if ($rownew['stu_gender'] == 'ชาย') {
                    $grouped_data[$cou_name]['men']++;
                } elseif ($rownew['stu_gender'] == 'หญิง') {
                    $grouped_data[$cou_name]['women']++;
                }
            }


            $data[] = array('cou_name', 'Grade in Class', 'Year class', 'men', 'women');
            foreach ($grouped_data as $cou_name => $values) {

                $average_grade = ($values['Year class'] > 0) ? $grades_total[$cou_name] / $values['Year class'] : 0;

                $data[] = array(
                    $cou_name,
                    $average_grade,
                    $values['Year class'],
                    $values['men'],
                    $values['women']
                );
            }
        } elseif ($gender == 'men') {

            $grouped_data = array();
            $grades_total = array();

            while ($rownew = mysqli_fetch_assoc($resultnew)) {
                $cou_name = $rownew['cou_name'];


                if (!isset($grouped_data[$cou_name])) {

                    $grouped_data[$cou_name] = array(
                        'Grade in Class' => 0,
                        'Year class' => 0,
                        'men' => 0,
                        'women' => 0
                    );
                    $grades_total[$cou_name] = 0;
                }


                $grouped_data[$cou_name]['Grade in Class'] += (int) $rownew['grade'];
                $grades_total[$cou_name] += (int) $rownew['grade'];

                $grouped_data[$cou_name]['Year class']++;

                if ($rownew['stu_gender'] == 'ชาย') {
                    $grouped_data[$cou_name]['men']++;
                } elseif ($rownew['stu_gender'] == 'หญิง') {
                    $grouped_data[$cou_name]['women']++;
                }
            }


            $data[] = array('cou_name', 'Grade in Class', 'Year class', 'men', 'women');
            foreach ($grouped_data as $cou_name => $values) {

                $average_grade = ($values['Year class'] > 0) ? $grades_total[$cou_name] / $values['Year class'] : 0;

                $data[] = array(
                    $cou_name,
                    $average_grade,
                    $values['Year class'],
                    $values['men'],
                    $values['women']
                );
            }
        } elseif ($gender == 'women') {

            $grouped_data = array();
            $grades_total = array();

            while ($rownew = mysqli_fetch_assoc($resultnew)) {
                $cou_name = $rownew['cou_name'];


                if (!isset($grouped_data[$cou_name])) {

                    $grouped_data[$cou_name] = array(
                        'Grade in Class' => 0,
                        'Year class' => 0,
                        'men' => 0,
                        'women' => 0
                    );
                    $grades_total[$cou_name] = 0;
                }


                $grouped_data[$cou_name]['Grade in Class'] += (int) $rownew['grade'];
                $grades_total[$cou_name] += (int) $rownew['grade'];


                $grouped_data[$cou_name]['Year class']++;

                if ($rownew['stu_gender'] == 'ชาย') {
                    $grouped_data[$cou_name]['men']++;
                } elseif ($rownew['stu_gender'] == 'หญิง') {
                    $grouped_data[$cou_name]['women']++;
                }
            }


            $data[] = array('cou_name', 'Grade in Class', 'Year class', 'men', 'women');
            foreach ($grouped_data as $cou_name => $values) {

                $average_grade = ($values['Year class'] > 0) ? $grades_total[$cou_name] / $values['Year class'] : 0;

                $data[] = array(
                    $cou_name,
                    $average_grade,
                    $values['Year class'],
                    $values['men'],
                    $values['women']
                );
            }
        } elseif ($emp == 0) {

            $grouped_data = array();
            $grades_total = array();

            while ($rownew = mysqli_fetch_assoc($resultnew)) {
                $cou_name = $rownew['cou_name'];


                if (!isset($grouped_data[$cou_name])) {

                    $grouped_data[$cou_name] = array(
                        'Grade in Class' => 0,
                        'Year class' => 0,
                        'men' => 0,
                        'women' => 0
                    );
                    $grades_total[$cou_name] = 0;
                }


                $grouped_data[$cou_name]['Grade in Class'] += (int) $rownew['grade'];
                $grades_total[$cou_name] += (int) $rownew['grade'];


                $grouped_data[$cou_name]['Year class']++;


                if ($rownew['stu_gender'] == 'ชาย') {
                    $grouped_data[$cou_name]['men']++;
                } elseif ($rownew['stu_gender'] == 'หญิง') {
                    $grouped_data[$cou_name]['women']++;
                }
            }


            $data[] = array('cou_name', 'Grade in Class', 'Year class', 'men', 'women');
            foreach ($grouped_data as $cou_name => $values) {

                $average_grade = ($values['Year class'] > 0) ? $grades_total[$cou_name] / $values['Year class'] : 0;

                $data[] = array(
                    $cou_name,
                    $average_grade,
                    $values['Year class'],
                    $values['men'],
                    $values['women']
                );
            }
        } else {

            $data[] = array('cou_name', 'GPA Student', 'Grade in Class', 'grade(หาร 20)', 'Year class', 'Course credit');

            $grouped_data = array();
            $grades_total = array();

            while ($rownew = mysqli_fetch_assoc($resultnew)) {
                $cou_name = $rownew['cou_name'];


                if (!isset($grouped_data[$cou_name])) {

                    $grouped_data[$cou_name] = array(
                        'Grade in Class' => 0,
                        'Year class' => 0,
                        'men' => 0,
                        'women' => 0
                    );
                    $grades_total[$cou_name] = 0;
                }


                $grouped_data[$cou_name]['Grade in Class'] += (int) $rownew['grade'];
                $grades_total[$cou_name] += (int) $rownew['grade'];


                $grouped_data[$cou_name]['Year class']++;


                if ($rownew['stu_gender'] == 'ชาย') {
                    $grouped_data[$cou_name]['men']++;
                } elseif ($rownew['stu_gender'] == 'หญิง') {
                    $grouped_data[$cou_name]['women']++;
                }
            }


            $data[] = array('cou_name', 'Grade in Class', 'Year class', 'men', 'women');
            foreach ($grouped_data as $cou_name => $values) {

                $average_grade = ($values['Year class'] > 0) ? $grades_total[$cou_name] / $values['Year class'] : 0;

                $data[] = array(
                    $cou_name,
                    $average_grade,
                    $values['Year class'],
                    $values['men'],
                    $values['women']
                );
            }
        }

        ?>

    </div>


    <script type="text/javascript">
        google.charts.load("current", { packages: ["corechart"] });
        google.charts.setOnLoadCallback(drawChart);


        function drawChart() {
            google.charts.load('current', { 'packages': ['corechart'] });
            google.charts.setOnLoadCallback(drawVisualization);

            function drawVisualization() {

                var data = google.visualization.arrayToDataTable(<?php echo json_encode($data); ?>);

                var options = {
                    title: '',
                    vAxis: { title: 'หน่วย' },
                    hAxis: { title: 'วิชา' },
                    seriesType: 'bars',
                    series: { 5: { type: 'line' } }
                };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
            document.getElementById('chartSubmit').addEventListener('click', function () {

                var chartType = document.querySelector('chartSw').value;

                switch (chartType) {
                    case 'combo':
                        switchToComboChart();
                        break;
                    case 'donut':
                        switchToDonutChart();
                        break;
                    case 'area':
                        switchToAreaChart();
                        break;
                    default:
                        break;
                }
            });
        }

        function switchToComboChart() {

            google.charts.load('current', { 'packages': ['corechart'] });
            google.charts.setOnLoadCallback(drawVisualization);

            function drawVisualization() {

                var data = google.visualization.arrayToDataTable(<?php echo json_encode($data); ?>);

                var options = {
                    title: '',
                    vAxis: { title: 'หน่วย' },
                    hAxis: { title: 'วิชา' },
                    seriesType: 'bars',
                    series: { 5: { type: 'line' } }
                };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
        }


        function switchToDonutChart() {
            google.charts.load('current', { 'packages': ['corechart'] });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable(<?php echo json_encode($data); ?>);

                var options = {
                    title: 'Title',
                    pieHole: 0.4,
                };

                var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }

        }


        function switchToAreaChart() {
            google.charts.load('current', { 'packages': ['corechart'] });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable(<?php echo json_encode($data); ?>);

                var options = {
                    title: '',
                    hAxis: { title: 'วิชา', titleTextStyle: { color: '#333' } },
                    vAxis: { minValue: 0 }
                };

                var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

        $(document).ready(function () {

            $('#facultySelect').change(function () {
                var facultyId = $(this).val();

                $.ajax({
                    url: 'statgetbranch.php',
                    type: 'GET',
                    data: { fac_id: facultyId },
                    success: function (data) {

                        $('#branchSelect').html(data);
                    },
                    error: function () {

                    }
                });
            });
        });
    </script>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>