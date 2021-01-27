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


    $query_get_count= "SELECT COUNT(students.student_id) as total_students,

    (CASE WHEN online_exam.online_exam_datetime > '".$curent_time."' THEN 'Pending' ELSE COUNT(attendance.attendance_id) END) as present
    
    
      
        from students INNER JOIN exam_enrollment on
         students.student_section = exam_enrollment.section AND 
         students.student_year = exam_enrollment.year inner JOIN online_exam on
          exam_enrollment.online_exam_id = online_exam.online_exam_id  
          LEFT JOIN 
          attendance on attendance.online_exam_id = exam_enrollment.online_exam_id AND
           students.student_id = attendance.student_id where exam_enrollment.online_exam_id = $online_exam_id";
$result_count = mysqli_query($conn, $query_get_count);
while($row = mysqli_fetch_assoc($result_count))
{
    $ab = "pending";

    if($row['present'] == 'Pending'){
        $ab = "pending";
        
    }
    else
    {
        $ab = $row['total_students'] - $row['present'];
    }

    $html .= "
    
    <span><b>Total Students: </b>".$row['total_students']."</span>
                                    </div>
                                    <div class='col-md'>
                                        <span><b>No of Students Present: </b>".$row['present']."</span>
                                    </div>
                                    <div class='col-md'>
                                        <span><b>No of Students Absent: </b>".$ab."</span>
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
            <th>Student year</th>
            <th>Status</th>
            <th>Entry Time</th>

        </tr>
    </thead>

    <tbody>


";


    $query_get_attendance = "SELECT students.student_id,students.student_name,students.student_section,students.student_year,online_exam.online_exam_title,online_exam.online_exam_datetime,
    DATE_FORMAT(attendance.time_stamp,'%d-%m-%Y %h:%i %p') AS entry_time ,
    (CASE 
      WHEN online_exam.online_exam_datetime > '".$curent_time."' THEN 'Pending' 
     WHEN attendance.attendance_id IS NULL AND online_exam.online_exam_datetime < '".$curent_time."'  THEN 'Absent' 
     ELSE 'Present' 
     END) as status
    from students INNER JOIN exam_enrollment on
     students.student_section = exam_enrollment.section AND 
     students.student_year = exam_enrollment.year inner JOIN online_exam on
      exam_enrollment.online_exam_id = online_exam.online_exam_id  
      LEFT JOIN 
      attendance on attendance.online_exam_id = exam_enrollment.online_exam_id AND
       students.student_id = attendance.student_id where exam_enrollment.online_exam_id = $online_exam_id";

$result_attendance = mysqli_query($conn, $query_get_attendance);
while($row = mysqli_fetch_assoc($result_attendance))
{
    $badge_class = "badge-danger";

    if($row['status'] == "Present"){
        $badge_class = "badge-success";
    }
    elseif($row['status'] == "Pending"){
        $badge_class = "badge-warning";
    }
    $html .= "
    
    <tr>
    <td>".$row['online_exam_title']."</td>
    <td>".$row['student_id']."</td>
    <td>".$row['student_name']."</td>
    <td>".$row['student_section']."</td>
    <td>".$row['student_year']."</td>
    <td><span class='badge ".$badge_class."'>".$row['status']."</span></td>
    <td>".$row['entry_time']."</td>
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