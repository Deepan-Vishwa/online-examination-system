<?php

/*
Requested By Test.js
Sends Question And Options For UI Rendering
*/

extract($_POST);
session_start();
include 'config.php';

$question_query = "SELECT * FROM question WHERE online_exam_id =".$_SESSION['online_exam_id'];
$options_query = "select options.question_id,options.option_title from options inner join
 question on options.question_id = question.question_id where question.online_exam_id =". $_SESSION['online_exam_id'];
$question_query_result = mysqli_query($conn,$question_query);
$options_query_result = mysqli_query($conn,$options_query);
$questions = array();
$options = array();
$output = '';
while ($row_question = mysqli_fetch_assoc($question_query_result))
    $questions[] = $row_question;
while ($row_options = mysqli_fetch_assoc($options_query_result))
    $options[] = $row_options;
    $final = array();
    $ques = 0;
   foreach($questions as $question){
       $op = 0;
      $final[$ques]["question"] = $question["question_title"];
      $final[$ques]["question_id"] = $question["question_id"];
       foreach($options as $option){
        if($question["question_id"] == $option["question_id"]){
       
            $final[$ques]["options"][$op] = $option["option_title"];
              $op++;
            }
           }
           $ques++;
       }
   echo (json_encode($final));

   
    
?>