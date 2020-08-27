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
    <link href=".css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <link href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/57c22c66dc.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark" style="background-color: #1a1a49 !important;">
        <a class="navbar-brand" href="index.html">KDSG Admin</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i
                class="fas fa-bars"></i></button>

        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">

                    <a class="dropdown-item" href="login.html">Logout</a>

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
                <div class="sb-sidenav-footer" style="background-color: #040432;">
                    <div class="small">Logged in as:</div>
                    Deepan Vishwa
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Create Exam</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item">Core</li>
                        <li class="breadcrumb-item active">Create Exam</li>
                    </ol>
                    <div class="container-fluid mb-5">

                        <form class="needs-validation" novalidate id="exam_details_form">
                            <div class="container-fluid m-0 p-0" id="exam_details">
                                <!-- Delete this disp none -->
                                <h4>Exam Details</h4>
                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label for="exam_title">Exam Title</label>
                                        <input type="text" class="form-control" id="exam_title" name="exam_title"
                                            required>

                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="start_date">Start Date & Time</label>
                                        <input type="datetime-local" class="form-control" id="start_date"
                                            name="start_date" required>

                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="end_date">End Date & Time</label>
                                        <input type="datetime-local" class="form-control" id="end_date" name="end_date"
                                            required>

                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom03">Total No of Questions</label>
                                        <input type="number" min="0" class="form-control" id="no_of_questions"
                                            onchange="render_questions()" name="no_of_questions" required>


                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom03">Marks Per Right Answer</label>
                                        <input type="number" min="1" class="form-control" id="marks_per_answer"
                                            name="marks_per_answer" required>

                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom03">Passing Mark</label>
                                        <input type="number" min="1" class="form-control" id="passing_mark"
                                            name="passing_mark" required>

                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom05">Exam Code</label>
                                        <input type="text" class="form-control" id="exam_code" name="exam_code"
                                            required>

                                    </div>
                                </div>
                                <button class="btn btn-success float-right mb-3" id="exam_details_next"
                                    type="button">Next
                                </button>
                            </div>



                            <div class="container-fluid m-0 p-0" id="prepare_questions" style="display: none;">
                                <h4>Prepare Questions</h4>
                                <!-- <div class="container-fluid p-0 m-0">
                                    <hr style="border: 1px solid grey">
                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label for="exam_title">Question No 1</label>
                                            <textarea class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-7 mb-3">
                                            <div class="card">
                                                <div class="card-header d-flex justify-content-between ">
                                                    <div>
                                                        Options
                                                    </div>
                                                    <button class="badge badge-dark add_options" type="button">
                                                        <i class="fas fa-plus-circle"> ADD</i>
                                                    </button>
                                                </div>
                                                <div class="card-body">
                                                    <input type="text" class="form-control mb-3">
                                                    <input type="text" class="form-control mb-3">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3 mt-0 col-md-7">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text">Answer</label>
                                            </div>
                                            <select class="custom-select select_answer">

                                            </select>
                                        </div>
                                    </div>
                                </div> -->

                                <!-- <div class="container-fluid p-0 m-0">
                                    <hr style="border: 1px solid grey">
                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label for="exam_title">Question No 2</label>
                                            <textarea class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-7 mb-3">
                                            <div class="card">
                                                <div class="card-header d-flex justify-content-between ">
                                                    <div>
                                                        Options
                                                    </div>
                                                    <button class="badge badge-dark add_options" type="button">
                                                        <i class="fas fa-plus-circle"> ADD</i>
                                                    </button>
                                                </div>
                                                <div class="card-body">
                                                    <input type="text" class="form-control mb-3">
                                                    <input type="text" class="form-control mb-3">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3 mt-0 col-md-7">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text">Answer</label>
                                            </div>
                                            <select class="custom-select select_answer">

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="container-fluid p-0 m-0">
                                    <hr style="border: 1px solid grey">
                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label for="exam_title">Question No 3</label>
                                            <textarea class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-7 mb-3">
                                            <div class="card">
                                                <div class="card-header d-flex justify-content-between ">
                                                    <div>
                                                        Options
                                                    </div>
                                                    <button class="badge badge-dark add_options" type="button">
                                                        <i class="fas fa-plus-circle"> ADD</i>
                                                    </button>
                                                </div>
                                                <div class="card-body">
                                                    <input type="text" class="form-control mb-3">
                                                    <input type="text" class="form-control mb-3">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3 mt-0 col-md-7">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text">Answer</label>
                                            </div>
                                            <select class="custom-select select_answer">

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="container-fluid p-0 m-0">
                                    <hr style="border: 1px solid grey">
                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label for="exam_title">Question No 4</label>
                                            <textarea class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-7 mb-3">
                                            <div class="card">
                                                <div class="card-header d-flex justify-content-between ">
                                                    <div>
                                                        Options
                                                    </div>
                                                    <button class="badge badge-dark add_options" type="button">
                                                        <i class="fas fa-plus-circle"> ADD</i>
                                                    </button>
                                                </div>
                                                <div class="card-body">
                                                    <input type="text" class="form-control mb-3">
                                                    <input type="text" class="form-control mb-3">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3 mt-0 col-md-7">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text">Answer</label>
                                            </div>
                                            <select class="custom-select select_answer">

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="container-fluid p-0 m-0">
                                    <hr style="border: 1px solid grey">
                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label for="exam_title">Question No 5</label>
                                            <textarea class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-7 mb-3">
                                            <div class="card">
                                                <div class="card-header d-flex justify-content-between ">
                                                    <div>
                                                        Options
                                                    </div>
                                                    <button class="badge badge-dark add_options" type="button">
                                                        <i class="fas fa-plus-circle"> ADD</i>
                                                    </button>
                                                </div>
                                                <div class="card-body">
                                                    <input type="text" class="form-control mb-3">
                                                    <input type="text" class="form-control mb-3">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3 mt-0 col-md-7">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text">Answer</label>
                                            </div>
                                            <select class="custom-select select_answer">

                                            </select>
                                        </div>
                                    </div>
                                </div> -->

                            </div>
                            <div class="container-fluid m-0 p-0" id="button_control" style="display: none;">
                                <hr style="border: 1px solid grey">
                                <button class="btn btn-danger float-left mb-3" id="back_questions" type="button">Back
                                </button>
                                <button class="btn btn-success float-right mb-3" type="button" id="submit_form">Next
                                </button>
                            </div>

                        </form>
                    </div>




                    <div class="table-responsive mb-3" id="exam_table">
                        <!-- Delete this disp none -->
                        <hr style="border: 1px solid grey">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>No Of Questions</th>
                                    <th>makrs/answer</th>
                                    <th>Min Marks</th>
                                    <th>Created On</th>
                                    <th>Status</th>
                                    <th>Code</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $query = "SELECT `online_exam_title`,
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

                                while ($row = mysqli_fetch_assoc($result)) {

                                ?>

                                <tr>
                                    <td><?php echo ucwords($row['online_exam_title'], ' '); ?></td>
                                    <td><?php echo $row['date']; ?></td>
                                    <td><?php echo $row['starting_time'] . " to " . $row['ending_time']; ?></td>
                                    <td><?php echo $row['total_questions']; ?></td>
                                    <td><?php echo $row['marks_per_right_answer']; ?></td>
                                    <td><?php echo $row['passing_score']; ?></td>
                                    <td><?php echo $row['created_date']; ?></td>
                                    <td><?php echo $row['online_exam_status']; ?></td>
                                    <td><?php echo $row['online_exam_code']; ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>

                        </table>



                    </div>
                </div>
            </main>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src=" https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js" crossorigin="anonymous">
    </script>
    <script src="js/datatables-demo.js"></script>
    <script src="./js/create_exam.js"></script>
</body>

</html>