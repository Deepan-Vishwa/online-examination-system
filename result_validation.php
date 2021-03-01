<?php
session_start();
extract($_POST);
include 'config.php';
date_default_timezone_set('Asia/Kolkata');
$current = strtotime(date("Y-m-d H:i:s")); // get current time when invoked
$current_time_stamp = date("Y-m-d H:i:s");
 $end = strtotime($_SESSION["end_time"]);
 $end_condition = strtotime('+1  minutes',strtotime($_SESSION["end_time"]));
//$end = strtotime('2020-07-31 20:00:00');

if($current > $end_condition){ // if more time taken even after auto submit ( validation for security reasons)
    echo "Time out - This may caused because you taken more time then alloted time if this is our mistake contact admin";
    exit();
}

 // Get question and answers from database to compare the user answers 
$question_query = "SELECT * FROM question WHERE online_exam_id =".$_SESSION['online_exam_id'];
 $question_query_result = mysqli_query($conn,$question_query);

 while ($row_question = mysqli_fetch_assoc($question_query_result))
    $db_question[] = $row_question; // question and answer from databse 

// Get marks per right answer
$marks_per_ques_query = "SELECT marks_per_right_answer FROM online_exam WHERE online_exam_id =".$_SESSION['online_exam_id'];
$marks_per_ques_query_result =  mysqli_query($conn,$marks_per_ques_query);

while ($row_mark = mysqli_fetch_assoc($marks_per_ques_query_result))
    $marks_per_right_answer = $row_mark['marks_per_right_answer'];

$score = 0; // number of Correct answers
$count = count($questions); // Number Of Questions


// Validates answer by comparing user answer with original answer
for($i = 0; $i< $count; $i++){
    if($response[$i]['answer'] != null){
        if($questions[$i]['options'][$response[$i]['answer']] == $db_question[$i]['answer'])
        {
           $score++; // increment number of Correct answers 
          
        }
    }

}
$final_marks =  $score * $marks_per_right_answer; // Final Score For the Examination


// Insert Data in data base
$insert_result = "INSERT INTO `result`(`online_exam_id`, `student_id`, `marks_obtained`, `time_stamp`) 
VALUES (".$_SESSION['online_exam_id'].",".$_SESSION['userid'] .",".$final_marks.",'".$current_time_stamp."')";


// UI Response
if ($conn->query($insert_result) === TRUE) {
    echo "Respond Recorded Successfully";
  } else {
    echo "Error Occured Please Contact Admin";
  }

?>