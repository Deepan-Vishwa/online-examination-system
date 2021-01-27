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

<script src="https://kit.fontawesome.com/57c22c66dc.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous">
</script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark" style="background-color: #1a1a49 !important;">
            
            
            <a class="navbar-brand" href="main.php">KDSG Admin</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                       
                        <a class="dropdown-item" href="logout.php">Logout</a>
    
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" style="background-color: #0e3964 !important;" id="sidenavAccordion">
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



                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsestudents" aria-expanded="false" aria-controls="collapsestudents"
                                ><div class="sb-nav-link-icon"><i class="fas fa-user-graduate"></i></div>
                                Students
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                            ></a>
                            <div class="collapse" id="collapsestudents" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="student.php">Students Record</a>
                                    <a class="nav-link" href="fresher_data_entry.php">Freshers Data Entry</a></nav>
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
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Exams List</li>
                        </ol>
                       
                        
                        
                                <div class="table-responsive mb-4">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>No Of Questions</th>
                                                <th>makrs/answer</th>
                                                <th>Minimum Marks</th>
                                                <th>Created On</th>
                                                <th>Status</th>
                                                <th>Code</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <?php
                                            $query="SELECT `online_exam_title`,
                                            DATE_FORMAT(`online_exam_datetime`, '%d-%m-%Y') as date,
                                            DATE_FORMAT(`online_exam_datetime`,'%h:%i %p') as starting_time,
                                            DATE_FORMAT(`end_time`,'%h:%i %p') as ending_time,
                                            `total_questions`,
                                            `marks_per_right_answer`,
                                            `passing_score`,
                                            DATE_FORMAT(`exam_created_on`, '%d-%m-%Y') as created_date,
                                            `online_exam_status`,
                                            `online_exam_code` FROM `online_exam`";
                                            $result = mysqli_query($conn, $query); 
            
                                            while($row = mysqli_fetch_assoc($result))
                                            {

                                            ?>
                                            
                                            <tr>
                                                <td><?php echo ucwords($row['online_exam_title'],' '); ?></td>
                                                <td><?php echo $row['date']; ?></td>
                                                <td><?php echo $row['starting_time']." to ".$row['ending_time']; ?></td>
                                                <td><?php echo $row['total_questions']; ?></td>
                                                <td><?php echo $row['marks_per_right_answer']; ?></td>
                                                <td><?php echo $row['passing_score']; ?></td>
                                                <td><?php echo $row['created_date']; ?></td>
                                                <td><?php echo $row['online_exam_status']; ?></td>
                                                <td><?php echo $row['online_exam_code'];?></td>
                                            </tr>
                                            <?php 
                                            }
                                            ?>
                                        </tbody>
                                        
                                    </table>
                                
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

    <script src="js/datatables-demo.js"></script>
    </body>
</html>
