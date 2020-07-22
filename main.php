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
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Bhai+2&family=Lobster&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@700&family=Playfair+Display&display=swap" rel="stylesheet">     
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <title>Online Examination System - Login</title>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark navbarbg animation a1" id="nav">
            <a class="navbar-brand" style="font-family: 'Baloo Bhai 2', cursive;" href="#">KDSG</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="main.php">Home<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Profile</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="result.html">Results</a>
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
as starting_time,online_exam.marks_per_wrong_answer,DATE_FORMAT(online_exam.end_time,'%h:%i %p')
 as ending_time,exam_enrollment.*,students.student_id,total_questions*marks_per_right_answer AS maximum_marks 
 from online_exam INNER JOIN exam_enrollment ON online_exam.online_exam_id=exam_enrollment.online_exam_id INNER JOIN 
students on exam_enrollment.section=students.student_section 
AND exam_enrollment.year=students.student_year WHERE students.student_id=".$_SESSION['userid']." AND online_exam.online_exam_status='active';
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
  
 
   

         echo "<div class='card m-3 border border-primary animation' style = '-webkit-animation-delay:".$i."s';
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
                      <p><strong style="color: darkblue;">Negative Marks: </strong> <?php echo $row['marks_per_wrong_answer'];?></p>
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
                    <button  class="btn cardheaderbg text-white mt-2 float-right startbtn" data-online_exam_id ="<?php echo $row['online_exam_id'];?>"  id="main_start-<?php echo $row['online_exam_id'];?>">Start</button>
                </div>
            </div>
          </div>
          <?php
         $i = $i+0.1;

        }
      
      
        
        ?>
          
    </div> 
    <script>
      $(document).ready(function(){

        $(".startbtn").click(function(e){

          var idClicked = e.target.id;
         var online_exam_id = $(`#${idClicked}`).data("online_exam_id");
         $.ajax({ // hey go to test.php and get me whatever its printed there 
            url: "main.php",
            type: "POST",
            data:{
              online_exam_id:online_exam_id
            },
            success: function(dataResult){
              console.log(online_exam_id);
              window.location.href="test.html";
            }
           
        })

         
        });

      });
    </script>

</body>
</html>
<?php

if(isset($_POST["online_exam_id"])){
  session_start();
            $_SESSION['online_exam_id'] = $_POST["online_exam_id"];
}

if(isset($_POST["online_exam_id"])){
  session_start();
            $_SESSION['online_exam_id'] = $_POST["online_exam_id"];

            $time_query = "SELECT end_time FROM online_exam where online_exam_id=". $_POST["online_exam_id"];

            $get_time = mysqli_query($conn, $time_query); 

            while ($row_time = mysqli_fetch_assoc($get_time))
            $end_time = $row_time['end_time'];

            $_SESSION['end_time']= $end_time;

            
}


          ?>

          ?>