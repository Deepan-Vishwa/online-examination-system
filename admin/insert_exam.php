<?php
extract($_POST);
include '../config.php';
$exam = json_decode($exam_details, true);
$question_data = json_decode($questions, true);
$options_data = json_decode($options, true);
$enroll_data = json_decode($enroll, true);
date_default_timezone_set('Asia/Kolkata');
$exam_created_on = date("Y-m-d H:i:s");
$admin_id = 1;
$start_time = str_replace("T", " ", $exam["start_date"]);
$end_time = str_replace("T", " ", $exam["end_date"]);


//condition for time
$time_conflict_query = "

SELECT test.online_exam_title,DATE_FORMAT(`online_exam_datetime`, '%d-%m-%Y') as date,
DATE_FORMAT(`online_exam_datetime`,'%h:%i %p') as starting_time,
DATE_FORMAT(`end_time`,'%h:%i %p') as ending_time,exam_enrollment.* from ( 

    SELECT * from online_exam WHERE 
      `online_exam_datetime` <= '".$end_time."' AND `end_time` >= '".$end_time."'
      OR
      `end_time` >= '".$start_time."' AND `online_exam_datetime` <= '".$start_time."'
      OR 
      
      `online_exam_datetime` <= '".$end_time."' AND `end_time` >= '".$end_time."'
      AND
      `end_time` >= '".$start_time."' AND `online_exam_datetime` <= '".$start_time."'
  
      )AS test INNER JOIN exam_enrollment on test.online_exam_id = exam_enrollment.online_exam_id WHERE (exam_enrollment.section,exam_enrollment.year) IN (";


      //contiune by tomorow
        $comma = false;
      foreach($enroll_data as $en){
          if($comma){
            $time_conflict_query .= ",('".$en['name']."',".$en['pid'].")";
          }
          else{
            $time_conflict_query .= "('".$en['name']."',".$en['pid'].")";
            $comma = true;
          }
      }
      $time_conflict_query .= ") AND test.`online_exam_datetime` LIKE '".substr($start_time,0,10)."%'";

     
      $time_conflict_result = mysqli_query($conn,$time_conflict_query);
      if (mysqli_num_rows($time_conflict_result ) > 0) {
            $conflict_error = '
            <h4 style="color: #df0808;padding-bottom: 10px; " ><i class="fas fa-exclamation-circle"></i>Exam Time Scheduling Conflict.</h4>
            <table class="table table-sm table-light">
              <thead>
                <tr>
                  <th scope="col">Subject</th>
                  <th scope="col">Date</th>
                  <th scope="col">Time</th>
                </tr>
              </thead>
              <tbody>';
      while($row = mysqli_fetch_assoc($time_conflict_result)){
            $conflict_error .= ' 
            <tr>
            <td>'.$row['online_exam_title'].'</td>
            <td>'.$row['date'].'</td>
            <td>'.$row['starting_time'].' to '.$row['ending_time'].'</td>
          </tr>';

      }
      $conflict_error .= '
      </tbody>
      </table>
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      ';
      echo $conflict_error;
    }
else{
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

            $enroll_insert = "INSERT INTO `exam_enrollment`(`online_exam_id`, `section`, `year`) VALUES ";

            foreach($enroll_data as $enr){
                $enroll_insert .= "(".$online_exam_id.",'".$enr['name']."',".$enr['pid']."), ";
            }

            if($conn->query(rtrim($enroll_insert, ", ")) === TRUE){
                echo '<h4 style="color: green;padding-bottom: 10px; " ><i style="color: green" class="fas fa-check"></i>  Exam Created Successfully!!</h4>
                <a href="main.php" id="dashboard_button" class="btn btn-primary">Go to DashBoard</a>';
            }
            else {
                echo ' <h4 style="color: #df0808;padding-bottom: 10px; " ><i class="fas fa-exclamation-circle"></i>  Error occured while Creating Exam.</h4> <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
            }
           
        } 
    } else {
        echo ' <h4 style="color: #df0808;padding-bottom: 10px; " ><i class="fas fa-exclamation-circle"></i>  Error occured while Creating Exam.</h4> <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
    }
} else {
    echo ' <h4 style="color: #df0808;padding-bottom: 10px; " ><i class="fas fa-exclamation-circle"></i>  Error occured while Creating Exam.</h4> <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
}
}

?>