<?php 
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

if (!isset($_SESSION["adminid"])) {
    header('Location: index.html');
    exit();
}
extract($_POST);
date_default_timezone_set('Asia/Kolkata');
include '../config.php';



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>KDSG Admin</title>
    <link href="css/styles.css" rel="stylesheet" />

    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <link href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://kit.fontawesome.com/57c22c66dc.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous">

    </script>



</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark" style="background-color: #1a1a49 !important;">


        <a class="navbar-brand" href="main.php">KDSG Admin</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">

                    <a class="dropdown-item" href="logout.php">Logout</a>

            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" style="background-color: #0e3964 !important;"
                id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading pb-0">Core</div>
                        <a class="nav-link pb-1" href="main.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i>
                            </div>
                            Dashboard
                        </a>
                        <a class="nav-link pb-1" href="create_exam.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-plus"></i>
                            </div>
                            Create Exam
                        </a>

                        <a class="nav-link pb-1 active" href="view_result.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-poll"></i>
                            </div>
                            View Result
                        </a>
                        <div class="sb-sidenav-menu-heading pb-0">Control</div>
                        <a class="nav-link pb-1" href="exam_edit.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-pencil-ruler"></i>
                            </div>
                            Exams
                        </a>



                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsestudents"
                            aria-expanded="false" aria-controls="collapsestudents">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-graduate"></i></div>
                            Students
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsestudents" aria-labelledby="headingOne"
                            data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="student.php">Students Record</a>
                                <a class="nav-link" href="fresher_data_entry.php">Freshers Data Entry</a>
                            </nav>
                        </div>

                        <a class="nav-link pb-1" href="attendance.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-list"></i>
                            </div>
                            Attendance
                        </a>
                        <a class="nav-link pb-1" href="admin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users-cog"></i>
                                </div>
                             Admin
                            </a>

                    </div>
                </div>
                <div class="sb-sidenav-footer" style="background-color: #040432;">
                    <div class="small">Logged in as:</div>
                    <?php echo $_SESSION['adminname']; ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Results</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">View Exam Results</li>
                    </ol>


                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Select Exam To view Results</h5>



                            <form>
                                <div class="row">
                                    <div class="col">
                                        <select class="form-control" id="exam_select">
                                            <?php 
                                    $options_query = "SELECT DISTINCT online_exam.online_exam_title,online_exam.online_exam_code,online_exam.online_exam_id
 
                                    from students INNER JOIN exam_enrollment on
                                     students.student_section = exam_enrollment.section AND 
                                     students.student_year = exam_enrollment.year inner JOIN online_exam on
                                      exam_enrollment.online_exam_id = online_exam.online_exam_id ";
                                    $result = mysqli_query($conn, $options_query);
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<option value = '".$row['online_exam_id']."'>".$row['online_exam_title']."-".$row['online_exam_code']."</option>";
                                    }
                                    ?>


                                        </select>
                                    </div>
                                    <div class="col">
                                        <button type="button" id="get_exam_id"
                                            class="btn btn-primary mb-2">Submit</button>
                                        <div class="spinner-border" style="display: none;" id="get_exam_id_spinner"
                                            role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </form>



                        </div>
                    </div>

                    <div id="content_render">
                        <!-- <div class="card mt-3">
                            <h5 class="card-header">Count</h5>

                            <div class="card-body">


                                <div class="row">
                                    <div class="col-md">
                                        <span><b>Total Students: </b>20</span>
                                    </div>
                                    <div class="col-md">
                                        <span><b>No of Students Present: </b>20</span>
                                    </div>
                                    <div class="col-md">
                                        <span><b>No of Students Absent: </b>20</span>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="table-responsive mb-4 mt-4">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Exam Name</th>
                                        <th>Student ID</th>
                                        <th>Student Name</th>
                                        <th>Student Section</th>
                                        <th>Student year</th>
                                        <th>Status</th>
                                        <th>Entry Time</th>

                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>

                            </table>

                        </div> -->
                    </div>


            </main>

        </div>
    </div>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src=" https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
        integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>



    <script>
    $(document).ready(function() {
        table = $("#dataTable").DataTable({
            responsive: true,
        });

        $("#get_exam_id").click(function() {
            $("#get_exam_id").hide();
            $("#get_exam_id_spinner").show();
            var online_exam_id = $('#exam_select').find(":selected").val();
            console.log(online_exam_id);

            $.ajax({
                url: "get_results.php",
                type: "POST",
                data: {
                    online_exam_id: online_exam_id
                },

                success: function(dataResult) {
                    table.destroy();
                    $("#content_render").html(dataResult);
                    table = $("#dataTable").DataTable({
                        responsive: true,
                    });
                    $("#get_exam_id_spinner").hide();
                    $("#get_exam_id").show();

                }

            })
        });
    });
    </script>

</body>


</html>