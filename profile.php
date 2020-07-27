<?php include 'config.php';
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

if (!isset($_SESSION["userid"])) {
    header('Location: index.html');
    exit();
}

$query = "select * from students where student_id=".$_SESSION["userid"];
$result = mysqli_query($conn, $query); 
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
                <li class="nav-item">
                  <a class="nav-link" href="main.php">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="instruction.html">Instruction</a>
              </li>
                  <li class="nav-item">
                    <a class="nav-link" href="result.html">Results</a>
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
    <div class="container d-flex justify-content-center align-items-center animation a3" style="margin-top: 3%;">
      <div class="card mb-3 shadow-lg p-3 mb-5 bg-white rounded" style="max-width: 700px;">
        <div class="row no-gutters">
          <div class="col-md-4 p-3 d-flex align-items-center justify-content-center" style="background: #2e5b82;">
            <img src="./assets/user.png" class="card-img pro-img">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title text-center animation a4">Student Details</h5>
              <table class="table">
                
                <tbody>
                  <?php
                  while($row = mysqli_fetch_assoc($result))
                  {
                  ?>
                  <tr class="animation a5">
                    <th scope="row">Name:</th>
                    <td><?php echo  $row["student_name"]; ?></td>
                  </tr>
                  <tr class="animation a6">
                    <th scope="row">Reg Number:</th>
                    <td><?php echo  $row["student_id"]; ?></td>
                  </tr>
                  <tr class="animation a7">
                    <th scope="row">Email-ID</th>
                    <td><?php echo  $row["student_email"]; ?></td>
                  </tr>
                  <tr class="animation a8">
                    <th scope="row">Year</th>
                    <td><?php echo  $row["student_year"]; ?></td>
                  </tr>
                  <tr class="animation a9">
                    <th scope="row">Section</th>
                    <td><?php echo  $row["student_section"]; ?></td>
                  </tr>
                  <tr class="animation a10">
                    <th scope="row">Father Name</th>
                    <td><?php echo  $row["father_name"]; ?></td>
                  </tr>
                  <tr class="animation a11">
                    <th scope="row">Parent Number</th>
                    <td><?php echo  $row["parent_number"]; ?></td>
                  </tr>
                  <tr class="animation a12">
                    <th scope="row">Student Number</th>
                    <td><?php echo  $row["student_number"]; ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>

              
              

          </div>
        </div>
      </div>
    </div>
    </body>
</html>