<?php
extract($_POST);
include '../config.php';

$question_data = json_decode($questions, true);
$options_data = json_decode($options, true);



$delete_questions_query = "DELETE FROM question where online_exam_id = $online_exam_id";

if($conn ->query($delete_questions_query)){


    $question_insert_query = "INSERT INTO `question`(`online_exam_id`, `answer`, `question_title`) VALUES ";
    foreach ($question_data as $question) {
        $question_insert_query .= '(' . $online_exam_id . ',"' . $question["answer"] . '","' . $question["question_title"] . '"), ';
    }

    if ($conn->query(rtrim($question_insert_query, ", ")) === TRUE) {
        $question_id = $conn->insert_id;
        $options_insert_query = "INSERT INTO `options`(`question_id`, `option_title`) VALUES ";
        foreach ($options_data as $options_per_question) {

            foreach ($options_per_question as $option) {

                foreach ($option as $op) {
                    $options_insert_query .= "($question_id , '$op'),";
                }
            }
            $question_id++;
        }
        if ($conn->query(rtrim($options_insert_query, ", ")) === TRUE) {
            echo 1;
        }
        else{
            echo $conn->error;
        } 
    }

}

?>