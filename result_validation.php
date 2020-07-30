<?php
session_start();
extract($_POST);
include 'config.php';
date_default_timezone_set('Asia/Kolkata');
$current = strtotime(date("Y-m-d H:i:s"));
$current_time_stamp = date("Y-m-d H:i:s");
// $end = strtotime($_SESSION["end_time"]);
$end = strtotime('2020-07-31 02:00:00');

if($current >= $end){
    echo "Time out - This may caused because you taken more time then alloted time if this is our mistake contact admin";
    exit();
}

$question_query = "SELECT * FROM question WHERE online_exam_id =".$_SESSION['online_exam_id'];
 $question_query_result = mysqli_query($conn,$question_query);

 while ($row_question = mysqli_fetch_assoc($question_query_result))
    $db_question[] = $row_question;


$marks_per_ques_query = "SELECT marks_per_right_answer FROM online_exam WHERE online_exam_id =".$_SESSION['online_exam_id'];
$marks_per_ques_query_result =  mysqli_query($conn,$marks_per_ques_query);

while ($row_mark = mysqli_fetch_assoc($marks_per_ques_query_result))
    $marks_per_right_answer = $row_mark['marks_per_right_answer'];

$score = 0;
$count = count($questions);

for($i = 0; $i< $count; $i++){
    if($response[$i]['answer'] != null){
        if($questions[$i]['options'][$response[$i]['answer']] == $db_question[$i]['answer'])
        {
           $score++;
          
        }
    }

}
$final_marks =  $score * $marks_per_right_answer;

$insert_result = "INSERT INTO `result`(`online_exam_id`, `student_id`, `marks_obtained`, `time_stamp`) 
VALUES (".$_SESSION['online_exam_id'].",".$_SESSION['userid'] .",".$final_marks.",'".$current_time_stamp."')";

if ($conn->query($insert_result) === TRUE) {
    echo "Respond Recorded Successfully";
  } else {
    echo "Error Occured Please Contact Admin";
  }

?>