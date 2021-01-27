<?php 
extract($_POST);
    session_start();
    include '../config.php';
                          
date_default_timezone_set('Asia/Kolkata');
$curent_time = date("Y-m-d H:i:s");
    $html ="<div id='content_render'>
    <div class='card mt-3'>
        <h5 class='card-header'>Count</h5>

        <div class='card-body'>


            <div class='row'>
                <div class='col-md'>";


    $query_get_count= "SELECT
    COUNT(students.student_id) as total_students,
    COUNT(result.result_id) as present,
    AVG(result.marks_obtained) as average,
    
    
    COUNT(CASE WHEN  result.marks_obtained IS NULL AND '".$curent_time."' < online_exam.end_time THEN 'Pending' ELSE null end) as pending,
    
    COUNT(CASE WHEN result.marks_obtained is NOT NULL AND 
           result.marks_obtained < online_exam.passing_score THEN 'FAIL' ELSE null END) as fail,
           COUNT(CASE WHEN result.marks_obtained is NOT NULL AND result.marks_obtained >= online_exam.passing_score THEN 'PASS' ELSE null END ) as pass
           
    
    
FROM
    online_exam
INNER JOIN exam_enrollment ON online_exam.online_exam_id = exam_enrollment.online_exam_id
INNER JOIN students ON exam_enrollment.section = students.student_section AND exam_enrollment.year = students.student_year  LEFT JOIN result on online_exam.online_exam_id = result.online_exam_id
AND students.student_id = result.student_id WHERE online_exam.online_exam_id = $online_exam_id
";
$result_count = mysqli_query($conn, $query_get_count);
while($row = mysqli_fetch_assoc($result_count))
{
   
    $html .= "
    
    <span><b>Total Students: </b>".$row['total_students']."</span>
                                    </div>
                                    <div class='col-md'>
                                        <span><b>No of Students Completed: </b>".$row['present']."</span>
                                    </div>
                                    <div class='col-md'>
                                        <span><b>No of Students Result Pending: </b>".$row['pending']."</span>
                                    </div>
                                    </div>
                                    <div class='row mt-3'>
                                    <div class='col-md'>
                                        <span><b>Exam Average Marks: </b>".$row['average']."</span>
                                    </div>
                                    <div class='col-md'>
                                        <span><b>No of Students Passed: </b>".$row['pass']."</span>
                                    </div>
                                    <div class='col-md'>
                                        <span><b>No of Students Failed: </b>".$row['fail']."</span>
                                    </div>

                                </div>
                            </div>
                        </div>
    ";

}

$html .= "

<div class='table-responsive mb-4 mt-4'>
<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
    <thead>
        <tr>
            <th>Exam Name</th>
            <th>Student ID</th>
            <th>Student Name</th>
            <th>Student Section</th>
            <th>Student Year</th>
            <th>Passing score</th>
            <th>Marks</th>
            <th>Percentage</th>
            <th>Entry Time</th>
            <th>Result</th>

        </tr>
    </thead>

    <tbody>


";


    $query_get_attendance = "SELECT
    online_exam.online_exam_title,
      students.student_id,
      students.student_name,
      students.student_section,
      students.student_year,
    online_exam.passing_score,
    online_exam.marks_per_right_answer,
     DATE_FORMAT(result.time_stamp,'%d-%m-%Y %h:%i %p') AS entry_time ,
    online_exam.total_questions*online_exam.marks_per_right_answer as maximum_marks,
    
    result.marks_obtained,
    TRUNCATE
    (
        (
            result.marks_obtained /(
                online_exam.total_questions * online_exam.marks_per_right_answer
            )
        ) * 100,
        0
    ) AS percent,
    (CASE
       WHEN  result.marks_obtained IS NULL AND '".$curent_time."' < online_exam.end_time THEN 'Pending'
    WHEN result.marks_obtained >= online_exam.passing_score THEN 'PASS'
      WHEN result.marks_obtained IS NULL AND '".$curent_time."' > online_exam.end_time THEN 'ABSENT'
    WHEN result.marks_obtained is NOT NULL AND result.marks_obtained < online_exam.passing_score  THEN 'FAIL'
   
     END
    ) as result_final
    
FROM
    online_exam
INNER JOIN exam_enrollment ON online_exam.online_exam_id = exam_enrollment.online_exam_id
INNER JOIN students ON exam_enrollment.section = students.student_section AND exam_enrollment.year = students.student_year  LEFT JOIN result on online_exam.online_exam_id = result.online_exam_id
AND students.student_id = result.student_id WHERE online_exam.online_exam_id = $online_exam_id
";

$result_attendance = mysqli_query($conn, $query_get_attendance);
while($row = mysqli_fetch_assoc($result_attendance))
{
    $badge_class = "";

    if($row['result_final'] == "PASS"){
        $badge_class = "badge-success";
    }
    elseif($row['result_final'] == "ABSENT"){
        $badge_class = "badge-warning";
    }
    elseif($row['result_final'] == "Pending"){
        $badge_class = "badge-info";
    }
    else{
        $badge_class = "badge-danger";
    }
    $html .= "
    
    <tr>
    <td>".$row['online_exam_title']."</td>
    <td>".$row['student_id']."</td>
    <td>".$row['student_name']."</td>
    <td>".$row['student_section']."</td>
    <td>".$row['student_year']."</td>
    <td>".$row['passing_score']."</td>
    <td>".$row['marks_obtained']."</td>
    <td>".$row['percent']."</td>
    <td>".$row['entry_time']."</td>
    <td><span class='badge ".$badge_class."'>".$row['result_final']."</span></td>
    
    </tr>
    
    ";
}
$html .= "
</tbody>

                            </table>

                        </div>
";
echo $html;


?>