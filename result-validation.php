<?php
extract($_POST);
session_start();
include 'config.php';

//$student_answer="INSERT INTO student_answers (online_exam_id,question_id,student_answer) VALUES
 //('.$_SESSION['online_exam_id']','$response['question_id]','$response['answer'])";

 $question_query = "SELECT * FROM question WHERE online_exam_id =".$_SESSION['online_exam_id'];
 $question_query_result = mysqli_query($conn,$question_query);

 while ($row_question = mysqli_fetch_assoc($question_query_result))
    $db_question[] = $row_question;

 $count=count($questions)-1;
 $score=0;


 for($i=0;$i<=$count;$i++){
 
   if($response[$i]['answer'] != null){
      if($questions[$i]['options'][$response[$i]['answer']] == $db_question[$i]['answer'])
      {
         $score++;
        
      }
      

   }
   
} 
echo $score ."\n";

$score_per_ques=1;  //  fetch value from model page db
$total_mark=$score_per_ques*count($questions);
$percentage=($score/$total_mark)*100;
echo $percentage . "/100 \n";
$pass_mark=2;
if($score>=$pass_mark)    // fetch pass_mark from model page db
{
   echo "pass";
}
else
{
   echo "fail";
}


?>