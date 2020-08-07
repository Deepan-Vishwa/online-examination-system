<?php 
session_start();
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

        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://kit.fontawesome.com/57c22c66dc.js" crossorigin="anonymous"></script>

    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark" style="background-color: darkblue !important;">
            
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <a class="navbar-brand ml-auto" href="index.html">KDSG Examination System Admin</a>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                       
                        <a class="dropdown-item" href="login.html">Logout</a>
    
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" style="background-color: navy !important;" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading pb-0">Core</div>
                            <a class="nav-link pb-1" href="main.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i>
                                </div>
                                Dashboard
                            </a>
                            <a class="nav-link pb-1" href="#">
                                <div class="sb-nav-link-icon"><i class="fas fa-plus"></i>
                                </div>
                                Create Exam
                            </a>
                            <a class="nav-link pb-1" href="#">
                                <div class="sb-nav-link-icon"><i class="fas fa-redo"></i>
                                </div>
                                Re-Exam
                            </a>
                            <a class="nav-link pb-1" href="#">
                                <div class="sb-nav-link-icon"><i class="fas fa-poll"></i>
                                </div>
                                View Result
                            </a>
                            <div class="sb-sidenav-menu-heading pb-0">Control</div>
                            <a class="nav-link pb-1" href="#">
                                <div class="sb-nav-link-icon"><i class="fas fa-pencil-ruler"></i>
                                </div>
                                Exams
                            </a>
                            <a class="nav-link pb-1" href="#">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-graduate"></i>
                                </div>
                                Students
                            </a>
                            <a class="nav-link pb-1" href="#">
                                <div class="sb-nav-link-icon"><i class="fas fa-poll"></i>
                                </div>
                                Results
                            </a>
                            <a class="nav-link pb-1" href="#">
                                <div class="sb-nav-link-icon"><i class="fas fa-list"></i>
                                </div>
                             Attendance
                            </a>
                           
                        </div>
                    </div>
                    <div class="sb-sidenav-footer" style="background-color: darkblue;">
                        <div class="small">Logged in as:</div>
                       Deepan Vishwa
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
                       
                        
                        
                                <div class="table-responsive">
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
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-demo.js"></script>
    </body>
</html>
