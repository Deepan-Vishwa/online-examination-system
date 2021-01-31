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
                        <a class="nav-link pb-1" href="exam_edit.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-pencil-ruler"></i>
                            </div>
                            Exams
                        </a>
                        <a class="nav-link collapsed active" href="#" data-toggle="collapse" data-target="#collapsestudents" aria-expanded="false" aria-controls="collapsestudents"
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
                    <h1 class="mt-4">Students Record</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Students / Students Record</li>
                    </ol>



                    <div class="table-responsive mb-4">
                        <div class="flex-row-reverse ml-3 d-flex">
                            <?php $apage = array('student_id'=>'','student_name'=>'');?>
                            <script>
                            var page_0 = <?php echo json_encode($apage)?>
                            </script>
                            <h3><a data="page_0" class="model_form btn btn-sm btn-danger" href="#">
                                    <i class="fas fa-plus mr-1"></i> Add new Student</a>
                            </h3>
                        </div>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Setion</th>
                                    <th>Year</th>
                                    <th>Father Name</th>
                                    <th>Parent Number</th>
                                    <th>Student Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                            $query="SELECT * FROM students";
                                            $result = mysqli_query($conn, $query); 
            
                                            while($row = mysqli_fetch_assoc($result))
                                            {

                                            ?>

                                <tr>
                                    <td><?php echo $row['student_id']; ?></td>
                                    <td><?php echo $row['student_name']; ?></td>
                                    <td><?php echo $row['student_email']; ?></td>
                                    <td><?php echo $row['student_pass']; ?></td>
                                    <td><?php echo $row['student_section']; ?></td>
                                    <td><?php echo $row['student_year']; ?></td>
                                    <td><?php echo $row['father_name']; ?></td>
                                    <td><?php echo $row['parent_number']; ?></td>
                                    <td><?php echo $row['student_number'];?></td>

                                    <script>
                                    var page_<?php echo $row['student_id']; ?> = <?php echo json_encode($row);?>
                                    </script>
                                    <td>
                                        <a data="<?php echo 'page_'.$row['student_id']; ?>"
                                            class="model_form btn btn-primary btn-sm" href="#"> <i
                                                class="fas fa-edit"></i></a>
                                        <a data="<?php echo  $row['student_id']; ?>"
                                            title="Delete <?php echo $row['student_name'];?>"
                                            class="tip delete_check btn btn-primary btn-sm "><i
                                                class=" text-white far fa-trash-alt"></i></a>
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
</body>

<script type="text/javascript">
$(document).ready(function() {
    $(document).on('click', '.model_form', function() {
        $('#form_modal').modal({
            keyboard: false,
            show: true,
            backdrop: 'static'
        });
        var data = eval($(this).attr('data'));
        $('#student_id').val(data.student_id);
        $('#student_name').val(data.student_name);
        $('#student_email').val(data.student_email);
        $('#student_pass').val(data.student_pass);
        $('#student_section').val(data.student_section);
        $('#student_year').val(data.student_year);
        $('#father_name').val(data.father_name);
        $('#parent_number').val(data.parent_number);
        $('#student_number').val(data.student_number);

        if (data.student_id != "")
            $('#pop_title').html('Edit');
        else
            $('#pop_title').html('Add');

    });
    $(document).on('click', '.delete_check', function() {
        var current_element = $(this);
        $("#del_confirm_modal").modal("show");

        $(document).on('click', '#confirm_del', function() {
            $("#del_confirm_modal").modal("hide");

            url = "student_crud.php";
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    ct_id: $(current_element).attr('data')
                },
                success: function(data) {

                    // $('.' + $(current_element).attr('data') + '_del').animate({
                    //     backgroundColor: "#003"
                    // }, "slow").animate({
                    //     opacity: "hide"
                    // }, "slow");

                    $("#del_modal").modal("show");
                }
            });

        });

    });
});
</script>


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

<div class="modal fade" id="del_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    onclick=" location.reload();">Close</button>
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
                <h4 class="modal-title"><i class="icon-paragraph-justify2"></i><span id="pop_title">Add</span> Student
                    information</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="student_crud.php" id="cat_form">
                <div class="modal-body with-padding">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Name :</label>
                                <input type="text" name="student_name" id="student_name" class="form-control required" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Email :</label>
                                <input type="email" name="student_email" id="student_email"
                                    class="form-control required" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Password :</label>
                                <input type="text" name="student_pass" id="student_pass"
                                    class="form-control required" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Section :</label>
                                <div class="input-group mb-3">
                                    <select class="custom-select required" name="student_section" id="student_section" required>
                                        <option Value="" selected>Choose...</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                    </select>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Year :</label>
                                <div class="input-group mb-3">
                                    <select class="custom-select required" name="student_year" id="student_year" required>
                                        <option value="" selected>Choose...</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Father Name :</label>
                                <input type="text" name="father_name" id="father_name"
                                    class="form-control required number" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Parent Number :</label>
                                <input type="tel" name="parent_number" id="parent_number"
                                    class="form-control required number" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Student Number :</label>
                                <input type="tel" name="student_number" id="student_number"
                                    class="form-control required number" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" required>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                    <span id="add">
                        <input type="hidden" name="student_id" value="" id="student_id">
                        <button type="submit" name="form_data" class="btn btn-primary">Submit</button>
                </div>
            </form>


        </div>
    </div>
</div>


</html>