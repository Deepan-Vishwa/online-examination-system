<?php include 'config.php';
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

if (!isset($_SESSION["userid"]) && !isset($_SESSION["end_time"]) &&  !isset($_SESSION["start_time"]) ) {
  
  header('Location: index.html');
  exit();
}

/*
//! this feature will be used later , for testing purpose its commented
date_default_timezone_set('Asia/Kolkata');

$current = strtotime(date("Y-m-d H:i:s"));
$start =   strtotime($_SESSION["start_time"]);
$end = strtotime($_SESSION["end_time"]);

  if($start > $current || $current > $end){
    header('Location: main.php');
    exit();
  } 
  */
  
  


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://kit.fontawesome.com/3535cd8d33.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/test.css">
    <link href="https://fonts.googleapis.com/css2?family=Karla&family=Noto+Sans+JP:wght@500&family=Poppins:wght@600&family=Signika+Negative:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@500&family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@500&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Bhai+2&family=Lobster&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@700&family=Playfair+Display&display=swap" rel="stylesheet">     
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <title>Online Examination System - Login</title>
</head>
<body>


  <div class="container mt-0 d-flex justify-content-center align-items-center heading-hide">
    <h1 class="h1title heading-hide">KDSG Examination System</h1>
  </div>
    <div class="container info-container" id="instructions">
      <div class="card info-card">
        <div class="card-body text-white">
          <div class="text-center">
          <img class="info-alert" src="./assets/Alert-Download-PNG.png"/>
        <h5 class="card-title text-white">Important Instructions</h5>
      </div>
       <ul>
           <li>Should not try to Exit Full Screen</li>
           <li>Should not use <strong>keyboard</strong></li>
           <li>if any key is pressed in the keyboard or if you try to exit the full screen the exam will be submited in 10 seconds</li>
       </ul>
       <div class="text-center">
        <button id="start" class="btn navbarbg text-white">Start Exam</button>
      </div>
      </div>
      </div>
    

    </div>

    <div class="container text-center mt-5" id="processing" style="display:none;">
    <img src="./assets/exam.png" alt="" width="13%" height="auto">
    <h2 id="wait">Please Wait For The Process To Be Completed...</h2>
    <h2 id="res-success" style = "display:none">Respond Recorded Successfully</h2>
    <div class="spinner-border text-danger" id="wait-load" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
      </div>
  <!--  <button class="btn btn-success mt-3"  style="display:none;" id="gotohome" href = "main.php">Go to Home</button> -->
  <a href="main.php" class="btn btn-success mt-3" role="button" id="gotohome"  style="display:none;" aria-pressed="true">Go to Home</a>

      
</div>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark navbarbg animation a1" id="nav" style="display: none;">
            <a class="navbar-brand" style="font-family: 'Baloo Bhai 2', cursive;" href="#">KDSG</a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">

              <ul class="navbar-nav ml-auto">
                
                <li class="nav-item">
                  <button type="button" class="navlink btn btn-danger  ml-auto"  data-toggle="modal" data-target="#staticBackdrop" id = "top-sub">Submit</button>
                  </li>
              </ul>
            </div>
          </nav>
    </header>
   <div class="container-fluid mt-3" id = "container_question" style="height: 89%; display: none;">
      <div class="d-flex justify-content-between h-100">
        
        <div class="card" style="height: 60% !important; width: 36%;" >
          <div class="card-header text-center" id="question_no" style="font-size: 1.1vw; font-weight: bold;">
            QUESTION: 1
          </div>
          <div class="card-body"style="font-size: 1.2vw">
            <div id="question">
             
            </div>
          </div>
        </div>
        <div class="card" style="height: 60% !important; width: 36%;" >
          <div class="card-header text-center"style="font-size: 1.1vw; font-weight:bold">
            OPTIONS
          </div>
          <div class="card-body" style="font-size: 1.2vw;">
            <div id="options">
            
            </div>
          </div>
        </div>
      
      
      
        <div class="card h-100" style="width: 25%;">
          <div class="card-header text-center"style="font-size: 1.1vw; font-weight: bold;">
            Time: <span id = "countdown" style = "color: red;">00:00:00</span>
          </div>
          <div class="card-body d-felx flex-wrap text-center" id="question_nav">
          </div>
          <div class="card-footer d-felx flex-wrap">
           <button class="btn btn-primary" id="book_mark" style="width: 48%;"><i class="fa fa-star"></i> Book Mark</button>
           <button class="btn btn-info text-white float-right" style="width: 48%;" id="remove_book_mark">Remove Mark</button>
           <button class="btn btn-success float-right mt-2 w-100"  id="next">Save & Next   <i class="fa fa-angle-double-right" aria-hidden="true"></i></button>
           <button class="btn btn-danger float-right mt-2 w-100"  data-toggle="modal" data-target="#staticBackdrop" id="sub" style=" display: none;" >Submit</button>
          </div>
        </div>
        
      </div> 
      
    </div>


    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       Are you Sure want to Submit ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-success" data-dismiss="modal" id="final_sub">Submit</button>
      </div>
    </div>
  </div>
</div>
      <script>
        var end_time = "<?php echo $_SESSION['end_time'] ?>";
        var start_time = "<?php echo $_SESSION['start_time'] ?>";
      </script>
<script src="./js/test.js"></script>

</body>
</html>