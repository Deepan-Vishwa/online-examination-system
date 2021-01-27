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

                        <a class="nav-link pb-1" href="view_result.php">
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
                            <nav class="sb-sidenav-menu-nested nav active">
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
                    <h1 class="mt-4">Fresher Data Entry</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Students year upgrade and Freshers Data Entry</li>
                    </ol>


                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Student Year Upgrade</h5>
                            <small class="text-muted">By clicking the below button 1st year students will be upgraded to
                                2nd year , 2nd year students will be upgraded to 3rd year and 3rd year students record
                                will be deleted and cannot be recovered. The button will be enabled only if 1st year
                                student data is present</small><br>
                            <button type="button" class="btn btn-danger mt-3" data-toggle="modal"
                                data-target="#upgrade_year_modal" <?php
                                 $query_check = mysqli_query($conn, "SELECT * FROM students WHERE student_year=1");
                                if(!mysqli_num_rows($query_check) > 0){

                                    echo "disabled";

                                } ?>>Upgrade year</button>
                        </div>
                    </div>
                    <div class="card mt-4 mb-3">
                    <h5 class='card-header'>Fresher Data Entry</h5>
                        <div class="card-body">
                       
                    <form id="dataForm" action="">
                        <table class="table-responsive table-bordered" width="100%" id="tblAppendGrid"></table>
                        <button id="submit" type="button" class="btn btn-primary">Submit</button>
                    </form>
                        </div>
                    </div>
                </div>





            </main>

        </div>
    </div>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
        integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/parsleyjs@2.9.1/dist/parsley.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery.appendgrid@2/dist/AppendGrid.js"></script>

    <script src="js/fresher_data_entry.js"></script>



</body>
<div class="modal fade" id="upgrade_year_modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="upgrade_year_modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header upgrade_control_btns">
                <h5 class="modal-title" id="upgrade_year_modalLabel">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div id="status_text">
                    1st year students will be upgraded to 2nd year ,
                    2nd year students will be upgraded to 3rd year and 3rd year students record will be deleted and
                    cannot
                    be recovered.
                    Are You sure want to continue ?
                </div>
                <div class="spinner-border status_spinner" style="width: 3rem; height: 3rem; display: none;"
                    role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <h3 class="status_spinner" style="display: none;">Upgrading Please Wait...</h3>
                <h3 class="status_success" style="display: none;">Upgraded successfully</h3>
                <h3 class="status_unsuccess" style="display: none;">Upgrade unsuccessfull</h3>
            </div>
            <div class="modal-footer upgrade_control_btns">
                <button type="button" class="btn btn-secondary upgrade_control_btns_No" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-secondary upgrade_control_btns_close" data-dismiss="modal"
                    style="display: none;" onclick="location.reload();">close</button>
                <button type="button" class="btn btn-primary upgrade_control_btns_yes"
                    id="upgrade_year_btn">Yes</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="data_entry_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="data_entry_modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title data_entry_header" id="data_entry_modalLabel">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="spinner-border data_entry_spinner" style="width: 3rem; height: 3rem; display: none;"
                    role="status">
                    <span class="sr-only">Loading...</span>
                </div>
        <h3 class="data_entry_status_text"></h3>
      </div>
      <div class="modal-footer data_entry_footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="data_entry_submit">Submit</button>
      </div>
    </div>
  </div>
</div>

</html>