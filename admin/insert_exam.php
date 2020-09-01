<?php
extract($_POST);
include '../config.php';
$exam = json_decode($exam_details, true);
$question_data = json_decode($questions, true);
$options_data = json_decode($options, true);
date_default_timezone_set('Asia/Kolkata');
$exam_created_on = date("Y-m-d H:i:s");
$admin_id = 1;
$status = "inactive";
$start_time = str_replace("T", " ", $exam["start_date"]);
$end_time = str_replace("T", " ", $exam["end_date"]);



$stmt = $conn->prepare("INSERT INTO `online_exam`(`admin_id`, `online_exam_title`, `online_exam_datetime`, `end_time`, `total_questions`, `marks_per_right_answer`, `passing_score`, `exam_created_on`, `online_exam_status`, `online_exam_code`)
 VALUES (?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param(
    "isssiiisss",
    $admin_id,
    $exam['exam_title'],
    $start_time,
    $end_time,
    $exam['no_of_questions'],
    $exam['marks_per_answer'],
    $exam['passing_mark'],
    $exam_created_on,
    $status,
    $exam['exam_code']

);
if ($stmt->execute()) {

    $online_exam_id =  $stmt->insert_id;
    $question_insert_query = "INSERT INTO `question`(`online_exam_id`, `answer`, `question_title`) VALUES ";
    foreach ($question_data as $question) {
        $question_insert_query .= '(' . $online_exam_id . ',"' . $question["answer"] . '","' . $question["question_title"] . '"), ';
    }

    // echo rtrim($question_insert_query, ", ");

    if ($conn->query(rtrim($question_insert_query, ", ")) === TRUE) {
        // echo "New record created successfully";

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
            echo "exam created successfully";
        } else {
            echo "unsuccessful";
        }
    } else {
        echo "Error: " . $question_insert_query . "<br>" . $conn->error;
    }
} else {
    echo $stmt->error;
}