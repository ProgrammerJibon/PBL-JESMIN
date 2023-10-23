<?php
if (!isset($index) || !isset($_GET['res_id'])) {
    header("HTTP/1.0 403");
    exit();
}

$res_id = addslashes($_GET['res_id']);
$key = array();

foreach ($results_name as $value) {
    if($value['id'] == $res_id){
        $key = $value;
        break;
    }
}

if(count($key) == 0){
    header("HTTP/1.0 403");
    exit();
}


$possible_subjects = array();
if($query = mysqli_query($connect, "SELECT * FROM `subject_list` WHERE `department_id` = '$key[department_id]'")){
    foreach ($query as $value) {
        $possible_subjects[] = $value;
    }    
}
// echoArray($key);
?>
<br>
<center>
    <h2>Update result of <?php echo $key['result_name']." - ".date("M d, Y", $key['release_time']) ?></h2>
</center>

<?php
$isStudent = "";
if($user_info['type'] == "STUDENT"){
    $isStudent = "AND `id` = '$user_info[id]'";
}
if($query = mysqli_query($connect, "SELECT * FROM `users` WHERE `admission_session_id` = '$key[admission_session]' AND `current_session_id` = '$key[current_session]' AND `current_department_id` = '$key[department_id]' AND `type` = 'STUDENT' $isStudent ORDER BY `id` ASC")){
    foreach ($query as $student) {
        ?>
        <div class="student-container">
            <div class="student-information">
                <div>
                    <b><?php echo $student['student_id']; ?></b>
                </div>
                <div>
                    <span style="width: 16px;display: inline-block; text-align:center;">-</span>
                </div>
                <div>
                    <b><?php echo $student['fname']." ".$student['lname']; ?></b>
                </div>
            </div>
            <table>
                <tr>
                    <td>Subject name</td>
                    <td>Subject code</td>
                    <td>assignemnt mark</td>
                    <td>class test mark</td>
                    <td>class present mark</td>
                    <td>presentaion mark</td>
                    <td>exam paper mark</td>
                    <td>CGPA</td>
                    <td>Action</td>
                </tr>
        <?php
        foreach ($possible_subjects as $subject) {
            $sub_result = get_student_result($student['id'], $key['id'], $subject['id']);
            if (!$sub_result) {
                mysqli_query($connect, "INSERT INTO `results_student` ( `user_id`, `result_id`, `subject_id`, `time`) VALUES ('$student[id]', '$key[id]', '$subject[id]', '$time')");
            }
            $sub_result = get_student_result($student['id'], $key['id'], $subject['id']);
            if ($subject['id'] == $user_info['current_subject_id']){
                
            ?>
                <tr class="results-student-row">
                    <td><?php echo $subject['subject_name']; ?></td>
                    <td><?php echo $subject['subject_code']; ?></td>
                    <td>
                        <input name="assignemnt_mark" value="<?php echo $sub_result['assignemnt_mark'] == "0"?"":$sub_result['assignemnt_mark']; ?>" data-result-id="<?php echo $sub_result['id']?>"/>
                    </td>
                    <td>
                        <input name="class_test_mark" value="<?php echo $sub_result['class_test_mark'] == "0"?"":$sub_result['class_test_mark']; ?>" data-result-id="<?php echo $sub_result['id']?>"/>
                    </td>
                    <td>
                        <input name="class_present_mark" value="<?php echo $sub_result['class_present_mark'] == "0"?"":$sub_result['class_present_mark']; ?>" data-result-id="<?php echo $sub_result['id']?>"/>
                    </td>
                    <td>
                        <input name="presentaion_mark" value="<?php echo $sub_result['presentaion_mark'] == "0"?"":$sub_result['presentaion_mark']; ?>" data-result-id="<?php echo $sub_result['id']?>"/>
                    </td>
                    <td>
                        <input name="exam_paper_mark" value="<?php echo $sub_result['exam_paper_mark'] == "0"?"":$sub_result['exam_paper_mark']; ?>" data-result-id="<?php echo $sub_result['id']?>"/>
                    </td>
                    <td>
                        <input name="cgpa_point" value="<?php echo $sub_result['cgpa_point'] == "0"?"":$sub_result['cgpa_point']; ?>" data-result-id="<?php echo $sub_result['id']?>"/>
                    </td>
                    <td>
                        <input type="button" value="Update" data-result-id="<?php echo $sub_result['id']?>" data-subject-id="<?php echo $subject['id']?>"/>
                    </td>
                </tr>
            <?php
            }else{
            ?>
                <tr class="results-student-row">
                    <td><?php echo $subject['subject_name']; ?></td>
                    <td><?php echo $subject['subject_code']; ?></td>
                    <td><?php echo $sub_result['assignemnt_mark']; ?></td>
                    <td><?php echo $sub_result['class_test_mark']; ?></td>
                    <td><?php echo $sub_result['class_present_mark']; ?></td>
                    <td><?php echo $sub_result['presentaion_mark']; ?></td>
                    <td><?php echo $sub_result['exam_paper_mark']; ?></td>
                    <td><?php echo $sub_result['cgpa_point']; ?></td>
                    <td></td>
                </tr>
            <?php
            }
        }
        ?>     
            </table>
        </div>
        <?php
    }
}
?>
<style>
.student-information {
    display: flex;
    justify-content: center;
    flex-direction: row;
    flex-wrap: nowrap;
    align-items: center;
    padding: 16px;
    font-weight: bold;
    color: #ffffff;
}
.points-row {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    align-content: center;
    justify-content: space-between;
    align-items: center;
}
table{
    width: 100%;
    border-collapse: collapse;
}
tr:nth-child(1) td{
    background: gray;
    color: white;
    border: 1px solid white;
    border-radius: 6px;
}
tr td {
    border: 1px solid gray;
    text-align: center;
    color: gray;
    background-color: white;
    border-radius: 6px;
}
tr td:not(:has(input)){
    padding: 8px 0;

}
tr td input {
    width: 100%;
    height: 100%;
    padding: 8px 0;
    text-align: center;
    border: none;
    cursor: pointer;
}
.student-container {
    border: 2px solid gray;
    margin-bottom: 32px;
    border-bottom: 1px solid gray;
    border-radius: 6px;
    overflow: hidden;
    background: gray;
    color: white;
}
</style>
<script src="/script.js"></script>
<script>
const elements = document.querySelectorAll('input[type="button"][value="Update"]');
elements.forEach(el=>{
    el.onclick=e=>{
        el.disabled =true;
        elVal = el.value;
        el.value = "Updating";
        if((res_id = el.getAttribute("data-result-id"))){
            const assignemnt_mark = document.querySelector(`input[name="assignemnt_mark"][data-result-id="${res_id}"]`).value;
            const class_test_mark = document.querySelector(`input[name="class_test_mark"][data-result-id="${res_id}"]`).value;
            const class_present_mark = document.querySelector(`input[name="class_present_mark"][data-result-id="${res_id}"]`).value;
            const presentaion_mark = document.querySelector(`input[name="presentaion_mark"][data-result-id="${res_id}"]`).value;
            const exam_paper_mark = document.querySelector(`input[name="exam_paper_mark"][data-result-id="${res_id}"]`).value;
            const cgpa_point = document.querySelector(`input[name="cgpa_point"][data-result-id="${res_id}"]`).value;
            loadLink('/json', [['update_teacher_result',res_id], ['assignemnt_mark', assignemnt_mark?assignemnt_mark:"0"], ['class_test_mark', class_test_mark?class_test_mark:"0"], ['class_present_mark', class_present_mark?class_present_mark:"0"], ['presentaion_mark', presentaion_mark?presentaion_mark:"0"], ['exam_paper_mark', exam_paper_mark?exam_paper_mark:"0"], ['cgpa_point', cgpa_point?cgpa_point:"0"]]).then(result=>{
                setTimeout(()=>{
                    el.disabled =false;
                    el.value = elVal;
                }, 3000)
                el.value = "Failed";
                if("update_teacher_result" in result){
                    if(result.update_teacher_result){
                        el.value = "Updated";
                    }
                }
            })
        }
    }
})

</script>