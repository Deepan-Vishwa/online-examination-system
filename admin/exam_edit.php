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
                        <a class="nav-link pb-1 active" href="exam_edit.php">
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


                        <a class="nav-link pb-1 " href="attendance.php">
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
                    <h1 class="mt-4">Edit Exams</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Exams List</li>
                    </ol>



                    <div class="table-responsive mb-4">
                        <?php $apage = array('online_exam_id'=>'','online_exam_title'=>'');?>
                        <script>
                        var page_0 = <?php echo json_encode($apage)?>
                        </script>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>No Of Questions</th>
                                    <th>makrs/answer</th>
                                    <th>Minimum Marks</th>
                                    <th>Class</th>
                                    <th>Created On</th>
                                    <th>Status</th>
                                    <th>Code</th>
                                    <th>Admin ID</th>
                                    <th>Action</th>
                                    <th>Edit Questions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                            $query="SELECT 
	
                                            `online_exam_title`,
                                            online_exam.online_exam_id,
                                            `online_exam_datetime`,
                                            `end_time`,
                                            GROUP_CONCAT(concat(exam_enrollment.year,'',exam_enrollment.section)) as class,
                                            DATE_FORMAT(`online_exam_datetime`, '%Y-%m-%d') as start_date_form,
                                            DATE_FORMAT(`online_exam_datetime`, '%H:%i') as start_time_form,
                                            DATE_FORMAT(`end_time`, '%Y-%m-%d') as end_date_form,
                                            DATE_FORMAT(`end_time`, '%H:%i') as end_time_form,
                                            DATE_FORMAT(`online_exam_datetime`, '%d-%m-%Y') as date,
                                            DATE_FORMAT(`online_exam_datetime`,'%h:%i %p') as starting_time,
                                            DATE_FORMAT(`end_time`,'%h:%i %p') as ending_time,
                                            `total_questions`,
                                            `marks_per_right_answer`,
                                            `passing_score`,
                                            `admin_id`,
                                            DATE_FORMAT(`exam_created_on`, '%d-%m-%Y') as created_date,
                                            `online_exam_status`,
                                            `online_exam_code` 
                                            
                                        FROM `online_exam` 
                                        INNER join exam_enrollment on online_exam.online_exam_id = exam_enrollment.online_exam_id group by exam_enrollment.online_exam_id";
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
                                    <td><?php echo $row['class']; ?></td>
                                    <td><?php echo $row['created_date']; ?></td>
                                    <td><a href="#" class="badge"
                                            data-status="<?php echo $row['online_exam_status']; ?>"><?php echo $row['online_exam_status']; ?></a>
                                    </td>
                                    <td><?php echo $row['online_exam_code'];?></td>
                                    <td><?php echo $row['admin_id'];?></td>


                                    <script>
                                    var page_<?php echo $row['online_exam_id']; ?> = <?php echo json_encode($row);?>
                                    </script>
                                    <td>
                                        <a data="<?php echo 'page_'.$row['online_exam_id']; ?>"
                                            class="model_form btn btn-primary btn-sm" href="#"> <i
                                                class="fas fa-edit"></i></a>
                                        <a data="<?php echo  $row['online_exam_id']; ?>"
                                            title="Delete <?php echo $row['online_exam_title'];?>"
                                            class="tip delete_check btn btn-primary btn-sm "><i
                                                class=" text-white far fa-trash-alt"></i></a>
                                    </td>
                                    <td>
                                        <button data="<?php echo 'page_'.$row['online_exam_id']; ?>"
                                            class="model_form_question btn btn-danger btn-sm" type="button">
                                            <i class="fas fa-edit"></i>
                                            <span class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true" style="display: none;"></span>
                                        </button>

                                    </td>
                                </tr>
                                <?php 
                                            }
                                            ?>
                            </tbody>

                        </table>
                        <?php
              if(isset($_SESSION['flash_msg2'])){ 
               $message = $_SESSION['flash_msg2'];
               echo "
               <script type=\"text/javascript\">
               $(document).ready(function(){
               $(\"#msg_body\").text(\"".$message."\");
               $(\"#msg_modal\").modal(\"show\");
               });
               </script>"
               ;
               unset($_SESSION['flash_msg2']);
              }
          ?>




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


    <script src="js/exam_edit.js"></script>


</body>
<div class="modal fade" id="del_confirm_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are You Sure To Delete Data ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="confirm_del">Yes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="del_modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" role="alert"><i class="fas fa-check"></i> <strong> Record Deleted
                        Sucessfully !</strong> </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="msg_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" role="alert"><i class="fas fa-check"></i> <strong
                        id="msg_body"></strong> </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>






<div class="modal fade" id="form_modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="icon-paragraph-justify2"></i><span id="pop_title">Add</span> Exam
                    information</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="exam_edit_sql.php" id="cat_form">
                <div class="modal-body with-padding">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Exam Title :</label>
                                <input type="text" name="online_exam_title" id="online_exam_title"
                                    class="form-control required" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Date & Time :</label>
                                <input type="datetime-local" name="online_exam_datetime" id="online_exam_datetime"
                                    class="form-control required" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>End Date & Time :</label>
                                <input type="datetime-local" name="end_time" id="end_time" class="form-control required"
                                    required>
                            </div>
                        </div>
                    </div>



                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Select Class :</label><br>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input reset_check" type="checkbox" name="1A"
                                                id="1A" value="1A">
                                            <label class="form-check-label" for="1A">1A</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input reset_check" type="checkbox" name="1B"
                                                id="1B" value="1B">
                                            <label class="form-check-label" for="1B">1B</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input reset_check" type="checkbox" name="1C"
                                                id="1C" value="1C">
                                            <label class="form-check-label" for="1C">1C</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input reset_check" type="checkbox" name="2A"
                                                id="2A" value="2A">
                                            <label class="form-check-label" for="2A">2A</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input reset_check" type="checkbox" name="2B"
                                                id="2B" value="2B">
                                            <label class="form-check-label" for="2B">2B</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input reset_check" type="checkbox" name="2C"
                                                id="2C" value="2C">
                                            <label class="form-check-label" for="2C">2C</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input reset_check" type="checkbox" name="3A"
                                                id="3A" value="3A">
                                            <label class="form-check-label" for="3A">3A</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input reset_check" type="checkbox" name="3B"
                                                id="3B" value="3B">
                                            <label class="form-check-label" for="3B">3B</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input reset_check" type="checkbox" name="3C"
                                                id="3C" value="3C">
                                            <label class="form-check-label" for="3C">3C</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Marks Per Right Answer :</label>
                                <input type="number" name="marks_per_right_answer" id="marks_per_right_answer"
                                    class="form-control required" required>


                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Passing Score :</label>
                                <input type="number" name="passing_score" id="passing_score"
                                    class="form-control required" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Exam Status :</label>
                                <div class="input-group mb-3">
                                    <select class="custom-select required" name="online_exam_status"
                                        id="online_exam_status" required>

                                        <option value="active">active</option>
                                        <option value="inactive">inactive</option>

                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Exam Code :</label>
                                <input type="text" name="online_exam_code" id="online_exam_code"
                                    class="form-control required" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Admin ID :</label>
                                <div class="input-group mb-3">
                                    <select class="custom-select required" name="admin_id" id="admin_id" required>



                                        <?php
                                        $admin_query = "SELECT admin_id FROM `admin`";
                                        $result = $conn->query($admin_query);
                                         if ($result->num_rows > 0) {

                                        while($row = $result->fetch_assoc()) {
                                        echo " <option value=\"".$row["admin_id"]."\">".$row["admin_id"]."</option>";
                                        }
                                    }
                                        ?>

                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                    <span id="add">
                        <input type="hidden" name="online_exam_id" value="" id="online_exam_id">
                        <button type="submit" name="form_data" class="btn btn-primary">Submit</button>
                </div>
            </form>


        </div>
    </div>
</div>


<div class="modal fade" id="edit_question_modal" data-keyboard="false" tabindex="-1"
    aria-labelledby="edit_question_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_question_modalLabel">Edit Questions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <input type="hidden" id="examid" name="examid" value="">
                <div class="container-fluid m-0 p-0" id="prepare_questions">
               

                </div>
            </div>
            <div class="modal-footer">
                <div class="alert alert-danger" id="empty_error" style="display: none;" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>Please Fill all Fields
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning questions_edit_submit_btn">Submit</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="empty_check_modal" tabindex="-1" aria-labelledby="empty_check_modalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>Please Fill all Fields
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="question_edit_process_modal" tabindex="-1"
    aria-labelledby="question_edit_process_modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="question_edit_process_modalLabel">Status</h5>
            </div>
            <div class="modal-body text-center">
                <h4 id="question_update_status"></h4>
                <div class="spinner-border question_update_spinner" style="display: none;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            </div>

            <div class="modal-footer question_update_modal_footer" style="display: none;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>

</html>