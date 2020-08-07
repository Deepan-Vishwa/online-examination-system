<?php include 'config.php';
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

if (!isset($_SESSION["userid"])) {
    header('Location: index.html');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/result.css">
    <link rel="stylesheet" href="./css/animation.css">
    <script src="https://kit.fontawesome.com/57c22c66dc.js" crossorigin="anonymous"></script>
    <link href=  "https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet"> 
    <link href=  "https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css" rel="stylesheet"> 
    <link href=  "https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css" rel="stylesheet"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
   
    <title>Online Examination System - Login</title>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark navbarbg " id="nav">
           <a class="navbar-brand" href="main.php">KDSG</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                  <a class="nav-link" href="main.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="instruction.html">Instruction</a>
                </li>
                
                  <li class="nav-item">
                    <a class="nav-link active" href="result.php">Results<span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Account</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="min-width: 9rem !important;">
                   <a class="dropdown-item" href="profile.php"> <i class="fa fa-user" aria-hidden="true"></i> Profile</a>
                   <a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
                   
                  </li>

                <li class="nav-item">
                  <a class="nav-link" href="help-main.html">Help</a>
                </li>
              </ul>
            </div>
          </nav>
    </header>
    <div class="container mt-3 d-flex justify-content-center align-items-center">
        <h1 class="h1title animation a2" id="title">KDSG Examination System</h1>
    </div>
          <div class="container-fluid mt-3 container-table animation a3">
      
    
         
              <div class="table-responsive">
                  <table class="table table-striped responsive table-bordered " id="example" width="100%" cellspacing="0">
                      <thead class="table-header">
                          <tr class="table-header-font">
                              <th>Subject</th>
                              <th>Date</th>
                              <th>Min marks</th>
                              <th>Marks per Right Answer</th>
                              <th>Marks obtained</th>
                              <th>Score percentage</th>
                              <th>Result</th>
                          </tr>
                      </thead>
                     
                      <tbody>

                      <?php
                      
date_default_timezone_set('Asia/Kolkata');
                      $curent_time = date("Y-m-d H:i:s");
                      $query = "
                      SELECT
    online_exam.online_exam_title,
      students.student_id,
    DATE_FORMAT(
        online_exam.online_exam_datetime,
        '%d-%m-%Y'
    ) AS date,
    online_exam.passing_score,
    online_exam.marks_per_right_answer,
    online_exam.total_questions*online_exam.marks_per_right_answer as maximum_marks,
    result.marks_obtained,
    TRUNCATE
    (
        (
            result.marks_obtained /(
                online_exam.total_questions * online_exam.marks_per_right_answer
            )
        ) * 100,
        0
    ) AS percent,
    (CASE
    WHEN result.marks_obtained >= online_exam.passing_score THEN 'PASS'
      WHEN result.marks_obtained IS NULL THEN 'ABSENT'
    ELSE 'FAIL'
     END
    ) as result_final
    
    
FROM
    online_exam
INNER JOIN exam_enrollment ON online_exam.online_exam_id = exam_enrollment.online_exam_id
INNER JOIN students ON exam_enrollment.section = students.student_section AND exam_enrollment.year = students.student_year LEFT JOIN result on online_exam.online_exam_id = result.online_exam_id
AND students.student_id = result.student_id where online_exam.end_time <= '".$curent_time."'
  And students.student_id = ".$_SESSION["userid"]." ORDER BY online_exam.end_time ASC";

                      $result = mysqli_query($conn, $query); 
            
                        while($row = mysqli_fetch_assoc($result))
                        {
                          ?>
                          <tr>
                              <td><?php echo $row["online_exam_title"]; ?></td>
                              <td><?php echo $row["date"]; ?></td>
                              <td><?php echo $row["passing_score"]; ?></td>
                              <td><?php echo $row["marks_per_right_answer"]; ?></td>
                              <td>
                              <?php
                              if(is_null($row['marks_obtained']))
                              {
                                echo "NULL";
                              }
                              else{
                              
                              echo $row["marks_obtained"]."/".$row["maximum_marks"] ;
                            }
                              ?>
                              </td>
                              <td><?php
                              if(is_null($row['percent']))
                              {
                                echo "NULL";
                              }
                              else{
                              echo $row["percent"]."%" ;
                              }
                              ?>
                              </td>
                              <td><a href="#" class="badge" data-result="<?php echo $row["result_final"]; ?>"><?php echo $row["result_final"]; ?></a></td>
                          </tr>
                         <?php 
                         }
                         ?>
                          
                      </tbody>
                  </table>
              </div>
        </div>
  

<script src=" https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="  https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/colreorder/1.5.2/js/dataTables.colReorder.min.js" crossorigin="anonymous"></script>
  <script src=" https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js" crossorigin="anonymous"></script>

  <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
      <script>
      $(document).ready(function() {
    $('#example').DataTable( {
  "pageLength": 5,
  "lengthMenu": [ [5, 10, 25, -1], [5, 10, 25, "All"] ],
 
        responsive: true,
        "aaSorting": []
       
} );

} );





$('[data-result]').each(function() {

var $this = $(this),
result_text = $(this).data('result');


if (result_text == "PASS"){
 $(this).addClass(" badge badge-success");
}
else if (result_text == "ABSENT"){
 $(this).addClass(" badge badge-warning");
}
else{
  $(this).addClass(" badge badge-danger");
  console.log("dai");
}




});
    </script>  
  </body>
   </html>