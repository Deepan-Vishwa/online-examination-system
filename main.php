<?php include 'config.php';
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

if (!isset($_SESSION["userid"])) {
    header('Location: index.html');
    exit();
}
date_default_timezone_set('Asia/Kolkata');
$current = date("Y-m-d H:i:s");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://kit.fontawesome.com/57c22c66dc.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>   
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <title>Online Examination System - Login</title>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark navbarbg " id="nav">
           <a class="navbar-brand"  href="main.php">KDSG</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="main.php">Home<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="instruction.html">Instruction</a>
              </li>

                  <li class="nav-item">
                    <a class="nav-link" href="result.php">Results</a>
                  </li>

                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Account</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown" style=" min-width: 9rem !important;">
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
    <div class="container mt-5">
    
    <?php


$query = 
"
SELECT online_exam.online_exam_title, DATE_FORMAT(online_exam.online_exam_datetime, '%d-%m-%Y') 
AS date,online_exam.total_questions,online_exam.passing_score,DATE_FORMAT(online_exam.online_exam_datetime,'%h:%i %p') 
as starting_time,online_exam.marks_per_right_answer,online_exam.online_exam_datetime,DATE_FORMAT(online_exam.end_time,'%h:%i %p')
 as ending_time,exam_enrollment.*,students.student_id,total_questions*marks_per_right_answer AS maximum_marks 
 from online_exam INNER JOIN exam_enrollment ON online_exam.online_exam_id=exam_enrollment.online_exam_id INNER JOIN 
students on exam_enrollment.section=students.student_section 
AND exam_enrollment.year=students.student_year WHERE students.student_id=".$_SESSION['userid']. "
AND online_exam.online_exam_status='active' AND online_exam.end_time > '".$current."' AND NOT EXISTS (SELECT attendance.online_exam_id ,
 attendance.student_id From attendance WHERE attendance.online_exam_id = online_exam.online_exam_id 
 and students.student_id = attendance.student_id) ORDER BY online_exam.online_exam_datetime ASC
"; 

$result = mysqli_query($conn, $query); 

if(mysqli_num_rows($result)===0) 
{

  echo'<p class="text-center  animation a3 " style="margin-top:5%"><img class="image" src="./assets/logo_transparent.png"></img></p>';
  echo'<h1 class=" norecords text-center  animation a4 ">
  
  No Exams Alloted For You !!!!!

</h1>';
  
} 

  $i = 0.9;
while($row = mysqli_fetch_assoc($result))
{
  
 
   

         echo "<div class='card m-3 border border-primary animation shadow-lg bg-white' style = '-webkit-animation-delay:".$i."s';
            animation-delay:".$i.";>";
            ?>
            <div class="card-header d-flex justify-content-between align-items-center cardheaderbg text-white">
              <h6 class="fontsize">
               <strong>Subject: </strong><?php echo $row['online_exam_title'];?>
              </h6>
              <h6 class="fontsize">
                <strong>Date: </strong><?php echo $row['date'];?>
              </h6>
            </div>
            <div class="card-body">

                <div class="container">
                    <div class="row">
                      <div class="col-sm">
                      <p><strong style="color: darkblue;">Total No Of Questions: </strong><?php echo $row['total_questions'];?></p>
                      <p><strong style="color: darkblue;">Marks Per Right Answer: </strong> <?php echo $row['marks_per_right_answer'];?></p>
                      </div>
                      <div class="col-sm border-darkblue">
                        <p><strong style="color: darkblue;">Passing Score: </strong> <?php echo $row['passing_score'];?></p>
                        <p><strong style="color: darkblue;">Maximum marks: </strong> <?php echo $row['maximum_marks'];?></p>
                      </div>
                      <div class="col-sm border-darkblue">
                        <p><strong style="color: darkblue;">Starting Time: </strong> <?php echo $row['starting_time'];?></p>
                        <p><strong style="color: darkblue;">Ending Time: </strong><?php echo $row['ending_time'];?></p>
                      </div>
                    </div>
                  </div>
                   
       
                  <div class="container mt-3 d-flex justify-content-center align-items-center">
                    <button style="display:none;"  class="btn cardheaderbg text-white mt-2 float-right startbtn" data-online_exam_id ="<?php echo $row['online_exam_id'];?>"  id="main_start-<?php echo $row['online_exam_id'];?>">Start</button>
                    <p class="text-center" data-btnid="main_start-<?php echo $row['online_exam_id'];?>" data-countdown="<?php echo $row['online_exam_datetime']; ?>" id="start_timer_<?php echo $row['online_exam_id'];?>"></p>
                </div>
            </div>
          </div>
          <?php
         $i = $i+0.1;

        }
      
      
        
        ?>
          
    </div> 

    <div class="modal fade" id="alert-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Alert</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             Sorry You cannot Attend Your exam in Mobile !!
            </div>
            <div class="modal-footer">
              <button type="button" class="btn navbarbg text-white" data-dismiss="modal">Understood</button>
             
            </div>
          </div>
        </div>
      </div>
    <script src="./js/main.js"></script>

</body>
</html>
<?php
if(isset($_SESSION["attendance"])){

  unset($_SESSION["attendance"]);

}
if(isset($_POST["online_exam_id"])){
  session_start();
            $_SESSION['online_exam_id'] = $_POST["online_exam_id"];
}

if(isset($_POST["online_exam_id"])){
  session_start();
            $_SESSION['online_exam_id'] = $_POST["online_exam_id"];

            $time_query = "SELECT end_time,online_exam_datetime FROM online_exam where online_exam_id=". $_POST["online_exam_id"];

            $get_time = mysqli_query($conn, $time_query); 

            while ($row_time = mysqli_fetch_assoc($get_time))
            {
            $end_time = $row_time['end_time'];
            $start_time = $row_time['online_exam_datetime'];
            }

            $_SESSION['end_time']= $end_time;
            $_SESSION['start_time'] = $start_time;

            
}


          ?>

        