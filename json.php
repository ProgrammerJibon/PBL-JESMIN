<?php

if(!isset($index)){
    header("Location: /json");
    exit();
}
$result = new ArrayObject();


if (isset($_POST['login']) && isset($_POST['user']) && isset($_POST['password'])) {
    $inputUser = addslashes((strtolower($_POST['user'])));
    $inputUser = str_replace(' ', '', $inputUser);
    $inputPassword = md5(sha1($_POST['password']));

    

    if(strlen($inputUser) < 1){
        $result['error'] = 'Invalid User ID';
    }elseif(strlen($_POST['password']) < 1){
        $result['error'] = 'Invalid User ID';
    }elseif ($user = searchUser($inputUser)) {
        if (isset($user['id'])) {
            if ($user['status'] === 'ACTIVE' && $user['password'] === $inputPassword) {
                header("Location: /json");
                add_user_cookie($user['id']);
            } else {
                $result['error'] = 'Login failed. Please check your credentials.';
            }
        } else {
            $result['error'] = 'User not found';
        }
    } else {
        $result['error'] = 'User not found';
    }
}

if(isset($user_info['type'])){
    if (isset($_POST['table']) && strtolower($_POST['table']) == "students" && ($user_info['type'] == "ADMIN" || $user_info['type'] == "TEACHER")) {
        $addSQLSearch = " WHERE `type` = 'STUDENT'";

        if(isset($_POST['admissionSession']) && $_POST['admissionSession'] != ""){
            $admissionSessionID = addslashes($_POST['admissionSession']);
            $addSQLSearch .= $addSQLSearch==""?" WHERE ":" AND ";
            $addSQLSearch .= " `admission_session_id` = '$admissionSessionID'";
        }
        
        if(isset($_POST['currentSession']) && $_POST['currentSession'] != ""){
            $currentSessionID = addslashes($_POST['currentSession']);
            $addSQLSearch .= $addSQLSearch==""?" WHERE ":" AND ";
            $addSQLSearch .= " `current_session_id` = '$currentSessionID'";
        }
        
        if(isset($_POST['status']) && $_POST['status'] != ""){
            $status = addslashes($_POST['status']);
            $addSQLSearch .= $addSQLSearch==""?" WHERE ":" AND ";
            $addSQLSearch .= " `status` = '$status'";
        }
        
        if(isset($_POST['section']) && $_POST['section'] != ""){
            $section = addslashes($_POST['section']);
            $addSQLSearch .= $addSQLSearch==""?" WHERE ":" AND ";
            $addSQLSearch .= " `current_section_id` = '$section'";
        }
        
        if(isset($_POST['department']) && $_POST['department'] != ""){
            $department = addslashes($_POST['department']);
            $addSQLSearch .= $addSQLSearch==""?" WHERE ":" AND ";
            $addSQLSearch .= " `current_department_id` = '$department'";
        }
        
        if(isset($_POST['search']) && $_POST['search'] != ""){
            $search = addslashes($_POST['search']);
            $addSQLSearch .= $addSQLSearch==""?" WHERE ":" AND ";
            $addSQLSearch .= " (`fname` LIKE '%$search%' OR  `lname` LIKE '%$search%' OR  `email` LIKE '%$search%' OR  `phone` LIKE '%$search%' OR  `student_id` LIKE '%$search%' OR  `nid_number` LIKE '%$search%' OR  `id` LIKE '%$search%') ";
        }

        if($query = mysqli_query($connect, "SELECT * FROM `users` $addSQLSearch  ORDER BY `id` DESC  LIMIT 100")){
            $queryResult = array();
            foreach ($query as $key) {
                unset($key['password']);
                foreach($sessions as $values){
                    if($key['admission_session_id'] == $values['id']){
                        $key['admission_session_id'] = $values['name'];
                    }
                    if($key['current_session_id'] == $values['id']){
                        $key['current_session_id'] = $values['name'];
                    }
                }
                foreach($sections as $values){
                    if($key['current_section_id'] == $values['id']){
                        $key['current_section_id'] = $values['section_mode'] . " - " . $values['section_code'];
                    }
                }
                foreach($departments as $values){
                    if($key['current_department_id'] == $values['id']){
                        $key['current_department_id'] = $values['department_name_short'];
                    }
                }


                $key['time'] = date("M d, Y", $key['time'])."<br>".date("h:iA", $key['time']);


                $queryResult[] = $key;
            }
            $result['students'] = $queryResult;
        }
        
    }
    
    if (isset($_POST['table']) && strtolower($_POST['table']) == "teachers" && $user_info['type'] == "ADMIN") {
        $addSQLSearch = " WHERE `type` = 'TEACHER'";

        
        if(isset($_POST['status']) && $_POST['status'] != ""){
            $status = addslashes($_POST['status']);
            $addSQLSearch .= $addSQLSearch==""?" WHERE ":" AND ";
            $addSQLSearch .= " `status` = '$status'";
        }
        
        
        if(isset($_POST['department']) && $_POST['department'] != ""){
            $department = addslashes($_POST['department']);
            $addSQLSearch .= $addSQLSearch==""?" WHERE ":" AND ";
            $addSQLSearch .= " `current_department_id` = '$department'";
        }
        
        if(isset($_POST['subjectId']) && $_POST['subjectId'] != ""){
            $department = addslashes($_POST['subjectId']);
            $addSQLSearch .= $addSQLSearch==""?" WHERE ":" AND ";
            $addSQLSearch .= " `current_subject_id` = '$department'";
        }

        
        if(isset($_POST['search']) && $_POST['search'] != ""){
            $search = addslashes($_POST['search']);
            $addSQLSearch .= $addSQLSearch==""?" WHERE ":" AND ";
            $addSQLSearch .= " (`fname` LIKE '%$search%' OR  `lname` LIKE '%$search%' OR  `email` LIKE '%$search%' OR  `phone` LIKE '%$search%' OR `username` LIKE '%$search%' OR  `nid_number` LIKE '%$search%' OR  `id` LIKE '%$search%') ";
            // exit($addSQLSearch);
        }

        if($query = mysqli_query($connect, "SELECT * FROM `users` $addSQLSearch  ORDER BY `id` DESC  LIMIT 100")){
            $queryResult = array();
            foreach ($query as $key) {
                unset($key['password']);
                
                foreach($departments as $values){
                    if($key['current_department_id'] == $values['id']){
                        $key['current_department_id'] = $values['department_name_short'];
                    }
                }  

                
                foreach($subjects as $values){
                    if($key['current_subject_id'] == $values['id']){
                        $key['current_subject_id'] = $values['subject_name'];
                    }
                }

                
                $key['time'] = date("M d, Y", $key['time'])."<br>".date("h:iA", $key['time']);
                
                $queryResult[] = $key;
            }
            $result['students'] = $queryResult;
        }
        
    }
    
    
    
    
    if (isset($_POST['table']) && strtolower($_POST['table']) == "subjects" && ($user_info['type'] == "ADMIN" || $user_info['type'] == "TEACHER")) {
        $addSQLSearch = "";

        
        
        if(isset($_POST['department']) && $_POST['department'] != ""){
            $department = addslashes($_POST['department']);
            $addSQLSearch .= $addSQLSearch==""?" WHERE ":" AND ";
            $addSQLSearch .= " `department_id` = '$department'";
        }


        if($query = mysqli_query($connect, "SELECT * FROM `subject_list` $addSQLSearch ORDER BY `subject_list`.`department_id` ASC")){
            $queryResult = array();
            foreach ($query as $key) {
                
                foreach($departments as $values){
                    if($key['department_id'] == $values['id']){
                        $key['department_id'] = $values['department_name_short'];
                    }
                } 

                
                $queryResult[] = $key;
            }
            $result['students'] = $queryResult;
        }
        
    }
    
    
    if (isset($_POST['table']) && strtolower($_POST['table']) == "departments" && ($user_info['type'] == "ADMIN" || $user_info['type'] == "TEACHER")) {
        $result['students'] = $departments;        
    }
    
    if (isset($_POST['table']) && strtolower($_POST['table']) == "notices" && isset($_POST['department']) && isset($_POST['subjectId']) && isset($_POST['asession'])) {
        $tempNotices = array();
        $times = 0;
        foreach ($notices as $key) {

            

            if($user_info['type'] == "STUDENT"){
                if ($key['current_department'] != "0" && $key['current_department'] != $user_info['current_department_id']) {
                    continue;
                }elseif($key['admission_session'] != $_POST['asession']  && $key['admission_session'] != "0"){
                    continue;
                }
            }elseif($user_info['type'] == "TEACHER"){
                if ($key['current_department'] != "0" && $key['current_subject'] != "0" && ($key['current_department'] != $user_info['current_department_id'] || $key['current_subject'] != $user_info['current_subject_id'])) {
                    continue;
                }
            }elseif($user_info['type'] == "ADMIN"){
                if($key['current_subject'] != $_POST['subjectId'] && $_POST['subjectId'] != "0"){
                    continue;
                }elseif($key['current_department'] != $_POST['department']  && $_POST['department'] != "0"){
                    continue;
                }elseif($key['admission_session'] != $_POST['asession']  && $_POST['asession'] != "0"){
                    continue;
                }
            }else{
                continue;
            }

            foreach($departments as $values){
                if($key['current_department'] == $values['id']){
                    $key['current_department'] = $values['department_name_short'];
                }
            }
            $key['current_department'] = $key['current_department']=="0"?"All":$key['current_department'];
            
            foreach($sessions as $values){
                if($key['admission_session'] == $values['id']){
                    $key['admission_session'] = $values['name'];
                }
            }
            $key['admission_session'] = $key['admission_session']=="0"?"All":$key['admission_session'];
            
            foreach($subjects as $values){
                if($key['current_subject'] == $values['id']){
                    $key['current_subject'] = $values['subject_code'];
                }
            }
            $key['current_subject'] = $key['current_subject']=="0"?"All":$key['current_subject'];

            if($user = searchUser($key['by_user_id'])){
                $key['by_user_id'] = $user['id'].": ".$user['fname']." ".$user['lname'];
            }


            $key['added_time'] = date("M d, Y", $key['added_time'])."<br>".date("h:iA", $key['added_time']);
            $key['event_time'] = $key['event_time'] == "0"?"N/A":date("M d, Y", $key['event_time']);

            $tempNotices[] = $key;
        }
        $result['notices'] = $tempNotices;
    }




    
    if (isset($_POST['table']) && strtolower($_POST['table']) == "sections" && ($user_info['type'] == "ADMIN" || $user_info['type'] == "TEACHER")) {
        $result['students'] = $sections;        
    }
    
    if (isset($_POST['table']) && strtolower($_POST['table']) == "results_name" && ($user_info['type'] == "ADMIN" || $user_info['type'] == "TEACHER" || $user_info['type'] == "STUDENT")) {
        $possible_results_name = array();
        foreach ($results_name as $key) {
            if($user_info['type'] == "TEACHER" && $user_info['current_department_id'] != $key['department_id']){
                continue;
            }
            if($user_info['type'] == "STUDENT" && $user_info['current_department_id'] != $key['department_id'] && $user_info['admission_session_id'] != $key['admission_session']){
                continue;
            }
            foreach($departments as $values){
                if($key['department_id'] == $values['id']){
                    $key['department_id'] = $values['department_name_short'];
                }
            } 
            foreach($sessions as $values){
                if($key['admission_session'] == $values['id']){
                    $key['admission_session'] = $values['name'];
                }
                if($key['current_session'] == $values['id']){
                    $key['current_session'] = $values['name'];
                }
            }
            $key['schedule_time'] = date("M d, Y", $key['schedule_time'])."<br>".date("h:iA", $key['schedule_time']);   
            $key['release_time'] = date("M d, Y", $key['release_time']);   
            $possible_results_name[] = $key;
        }
        
        $result['students'] = $possible_results_name;
    }
    
    if (isset($_POST['table']) && strtolower($_POST['table']) == "sessions" && ($user_info['type'] == "ADMIN" || $user_info['type'] == "TEACHER")) {
        if($query = mysqli_query($connect, "SELECT * FROM `sessions_name` ORDER BY `id` DESC")){
            $queryResult = array();
            foreach ($query as $key) {     
                $key['time'] = date("M d, Y", $key['time'])."<br>".date("h:iA", $key['time']);           
                $queryResult[] = $key;
            }
            $result['students'] = $queryResult;
        }     
    }


    if (isset($_POST['edit_user']) && $user_info['type'] == "ADMIN") {
        $userId = sanitizeInput($_POST['edit_user'], "NUMBER_ONLY");
        $userPrevInfo = user_info($userId);
        if (isset($userPrevInfo['id'])) {
            if($userPrevInfo['type'] == "STUDENT"){
                $firstname = sanitizeInput($_POST['firstname'], "TEXT_ONLY");
                $lastname = sanitizeInput($_POST['lastname'], "TEXT_ONLY");
                $nid = sanitizeInput($_POST['nid'], "NUMBER_ONLY");
                $phone = sanitizeInput($_POST['phone'], "NUMBER_ONLY");
                $admissionsessionid = sanitizeInput($_POST['admissionsessionid'], "NUMBER_ONLY");
                $currentsessionid = sanitizeInput($_POST['currentsessionid'], "NUMBER_ONLY");
                $accountstatus = sanitizeInput($_POST['accountstatus'], "TEXT_ONLY");
                $email = sanitizeEmail($_POST['email']);

                $sqlSets = "";
                if ($userPrevInfo['fname'] != $firstname) {
                    $sqlSets .= "`fname` = '$firstname', ";
                }
                if ($userPrevInfo['lname'] != $lastname) {
                    $sqlSets .= "`lname` = '$lastname', ";
                }
                if ($userPrevInfo['nid_number'] != $nid) {
                    $sqlSets .= "`nid_number` = '$nid', ";
                }
                if ($userPrevInfo['phone'] != $phone) {
                    $sqlSets .= "`phone` = '$phone', ";
                }
                if ($userPrevInfo['phone'] != $currentsessionid && $admissionsessionid < $currentsessionid && ($currentsessionid - $admissionsessionid) < 8) {
                    $sqlSets .= "`current_session_id` = '$currentsessionid', ";
                }
                if ($userPrevInfo['status'] != $accountstatus) {
                    $sqlSets .= "`status` = '$accountstatus', ";
                }
                if ($userPrevInfo['email'] != $email) {
                    $sqlSets .= "`email` = '$email', ";
                }

                if (isset($_POST['resetpassword']) && $_POST['resetpassword'] == "1") {
                    $sqlSets .= "`password` = 'd93a5def7511da3d0f2d171d9c344e91', ";
                }

                if(isset($_FILES['picture']['tmp_name'])){
                    if ($file_up = upload($_FILES['picture']['tmp_name'], "image")) {
                        $sqlSets .= "`pic` = '$file_up', ";
                    }
                }
                // make up sql
                $sqlSets .= "`type` = 'STUDENT'";
                if(@mysqli_query($connect, "UPDATE `users` SET $sqlSets WHERE `users`.`id` = '$userPrevInfo[id]'")){
                    header("Location: /students?edit=success");
                }
            }elseif($userPrevInfo['type'] == "TEACHER"){
                $firstname = sanitizeInput($_POST['firstname'], "TEXT_ONLY");
                $lastname = sanitizeInput($_POST['lastname'], "TEXT_ONLY");
                $username = sanitizeInput($_POST['username'], "SPACELESS_TEXT_NUMBER");
                $nid = sanitizeInput($_POST['nid'], "NUMBER_ONLY");
                $phone = sanitizeInput($_POST['phone'], "NUMBER_ONLY");
                $currentdepartmentid = sanitizeInput($_POST['currentdepartmentid'], "NUMBER_ONLY");
                $currentsubjectid = sanitizeInput($_POST['currentsubjectid'], "NUMBER_ONLY");
                $accountstatus = sanitizeInput($_POST['accountstatus'], "TEXT_ONLY");
                $email = sanitizeEmail($_POST['email']);

                $sqlSets = "";
                if ($userPrevInfo['fname'] != $firstname) {
                    $sqlSets .= "`fname` = '$firstname', ";
                }
                if ($userPrevInfo['lname'] != $lastname) {
                    $sqlSets .= "`lname` = '$lastname', ";
                }
                if ($userPrevInfo['nid_number'] != $nid) {
                    $sqlSets .= "`nid_number` = '$nid', ";
                }
                if ($userPrevInfo['phone'] != $phone) {
                    $sqlSets .= "`phone` = '$phone', ";
                }
                if ($userPrevInfo['current_subject_id'] != $currentsubjectid) {
                    $sqlSets .= "`current_subject_id` = '$currentsubjectid', ";
                }

                if ($userPrevInfo['current_department_id'] != $currentdepartmentid) {
                    $sqlSets .= "`current_department_id` = '$currentdepartmentid', ";
                }
                if ($userPrevInfo['status'] != $accountstatus) {
                    $sqlSets .= "`status` = '$accountstatus', ";
                }
                if ($userPrevInfo['email'] != $email) {
                    $sqlSets .= "`email` = '$email', ";
                }

                if (isset($_POST['resetpassword']) && $_POST['resetpassword'] == "1") {
                    $sqlSets .= "`password` = 'd93a5def7511da3d0f2d171d9c344e91', ";
                }

                if (!is_numeric($username) && !searchUser($username)) {
                    $sqlSets .= "`username` = '$username', ";
                }
                if(isset($_FILES['picture']['tmp_name'])){
                    if ($file_up = upload($_FILES['picture']['tmp_name'], "image")) {
                        $sqlSets .= "`pic` = '$file_up', ";
                    }
                }
                // make up sql
                $sqlSets .= "`type` = 'TEACHER'";
                if(@mysqli_query($connect, "UPDATE `users` SET $sqlSets WHERE `users`.`id` = '$userPrevInfo[id]'")){
                    echoArray($_POST);
                    header("Location: /teachers?edit=success");
                }
            }
            
        }
        
    }


    if(isset($_POST['edit_user']) && $user_id == $_POST['edit_user']){
        if (isset($_POST['changepassword']) && $_POST['changepassword'] != "") {
            $changepassword = md5(sha1($_POST['changepassword']));
            if(mysqli_query($connect, "UPDATE `users` SET `password` = '$changepassword' WHERE `users`.`id` = '$user_id'")){
                header("Location: /logout");
            }
        }
        header("Location: /");
    }


    if(isset($_POST['teacher_notice_add']) && $user_info['type'] == "TEACHER"){
        $title = sanitizeInput($_POST["title"]);
        $details = sanitizeInput($_POST["details"]);
        $fdate = removeSpaces(sanitizeInput($_POST["date"]));
        $asession = removeSpaces(sanitizeInput($_POST["asession_id"]));
        $cdepartment = $user_info['current_department_id'];
        $csubject = $user_info['current_subject_id'];
        $result['teacher_notice_add'] = array();
    
        $fdateFinal = "0";
        if($fdate != ""){
            $fdate = explode("-", $fdate);
            if (sizeof($fdate) == 3) {
                if(!($fdateFinal = date_to_timestamp($fdate[0], $fdate[1], $fdate[2]))){
                    $fdateFinal = "0";
                }
            }
        }
        
    
    
        // Validate inputs
        if (empty($title)) {
            $errors[] = "title is required.";
        }
    
        if (empty($details)) {
            $errors[] = "details is required.";
        }

        if (empty($asession) && $asession != "0") {
            $errors[] = "Admission session is required.";
        }
    
        if (empty($errors)) {
    
            $pic_uploaded = "#";
            if (isset($_FILES['one_image']['tmp_name'])) {
                if(!($pic_uploaded = upload($_FILES['one_image']['tmp_name']))){
                    $pic_uploaded = "#";
                }
            }
    
    
            $sql = "INSERT INTO `notices` (`current_department`, `admission_session`, `current_subject`, `notice_title`, `notice_desc`, `notice_image`, `added_time`, `event_time`, `by_user_id`) VALUES ('$cdepartment', '$asession', '$csubject', '$title', '$details', '$pic_uploaded', '$time', '$fdateFinal', '$user_id')";
    
            if ($pic_uploaded && mysqli_query($connect, $sql)) {
                $inserted_id = mysqli_insert_id($connect);
                $result['teacher_notice_add']['status'] = true;
            }else{
                $result['teacher_notice_add']['status'] = false;
                $result['teacher_notice_add']['errors'] = $errors;
            }
        }
    }


    if(isset($_POST['add_teacher_result']) && $user_info['type'] == "TEACHER"){
        $user_id = sanitizeInput($_POST['user_id']);
        $result_id = sanitizeInput($_POST['result_id']);
        $assignemnt_mark = sanitizeInput($_POST['assignemnt_mark']);
        $class_test_mark = sanitizeInput($_POST['class_test_mark']);
        $class_present_mark = sanitizeInput($_POST['class_present_mark']);
        $presentaion_mark = sanitizeInput($_POST['presentaion_mark']);
        $exam_paper_mark = sanitizeInput($_POST['exam_paper_mark']);
        $cgpa_point = sanitizeInput($_POST['cgpa_point']);
        $subject_id = $user_info['current_subject_id'];

        if(mysqli_query($connect, "INSERT INTO `results_student` (`user_id`, `result_id`, `assignemnt_mark`, `class_test_mark`, `class_present_mark`, `presentaion_mark`, `exam_paper_mark`, `cgpa_point`, `subject_id`, `time`) VALUES ('$user_id', '$result_id', '$assignemnt_mark', '$class_test_mark', '$class_present_mark', '$presentaion_mark', '$exam_paper_mark', '$cgpa_point', '$subject_id', '$time')")){
            $result['add_teacher_result'] = true;
        }else{
            $result['add_teacher_result'] = false;
        }
    }


    if(isset($_POST['update_teacher_result']) && $user_info['type'] == "TEACHER"){
        $result_st_id = sanitizeInput($_POST['update_teacher_result']);
        $assignemnt_mark = sanitizeInput($_POST['assignemnt_mark'], "NUMBER_ONLY");
        $class_test_mark = sanitizeInput($_POST['class_test_mark'], "NUMBER_ONLY");
        $class_present_mark = sanitizeInput($_POST['class_present_mark'], "NUMBER_ONLY");
        $presentaion_mark = sanitizeInput($_POST['presentaion_mark'], "NUMBER_ONLY");
        $exam_paper_mark = sanitizeInput($_POST['exam_paper_mark'], "NUMBER_ONLY");
        $cgpa_point = sanitizeInput($_POST['cgpa_point'], "NUMBER_ONLY");

        if(mysqli_query($connect, "UPDATE `results_student` SET `assignemnt_mark` = '$assignemnt_mark', `class_test_mark` = '$class_test_mark', `class_present_mark` = '$class_present_mark', `presentaion_mark` = '$presentaion_mark', `exam_paper_mark` = '$exam_paper_mark', `cgpa_point` = '$cgpa_point' WHERE `results_student`.`id` = '$result_st_id'")){
            $result['update_teacher_result'] = true;
        }else{
            $result['update_teacher_result'] = false;
        }
    }



    if (isset($_POST['table']) && ($_POST['table']) == "teachersWithSubject" && $user_info['type'] == "STUDENT") {
        $result['teachersWithSubject'] = array();
        foreach ($teachers as $key) {
            if($key['current_department_id'] != $user_info['current_department_id']){
                continue;
            }
            $result['teachersWithSubjects'][] = $key;
        }
    }


    if (isset($_POST['table']) && ($_POST['table']) == "results" && $user_info['type'] == "STUDENT") {
        $result['results'] = array();
        if($query = mysqli_query($connect, "SELECT * FROM `results_name` WHERE `department_id` = '$user_info[current_department_id]' AND `admission_session` = '$user_info[admission_session_id]'")){
            foreach ($query as $key) {
                if($key["release_time"] < $time &&$resultsPerSub = mysqli_query($connect, "SELECT * FROM `results_student` WHERE `user_id` = '$user_info[id]' AND `result_id` = '$key[id]'")){
                    if(mysqli_num_rows($resultsPerSub) > 0){
                        foreach ($resultsPerSub as $key2) {
                            $key2['time'] = date("M d, Y", $key2['time'])." - ".date("h:iA", $key2['time']);
                            $key['subjects'][] = $key2;
                        }
                    }
                }
                $key['schedule_time'] = date("M d, Y", $key['schedule_time'])." - ".date("h:iA", $key['schedule_time']);
                $key['release_time'] = date("M d, Y", $key['release_time'])." - ".date("h:iA", $key['release_time']);
                $result['results'][] = $key;
            }
        }
    }

    if (isset($_POST['table']) && ($_POST['table']) == "results" && $user_info['type'] == "TEACHER") {

        $result['results'] = array();
        $student_id = $_POST['student_id'];

        if($query = mysqli_query($connect, "SELECT * FROM `results_name`")){
            foreach ($query as $key) {
                if($resultsPerSub = mysqli_query($connect, "SELECT * FROM `results_student` WHERE `user_id` = '$student_id' AND `result_id` = '$key[id]'")){
                    if(mysqli_num_rows($resultsPerSub) > 0){
                        foreach ($resultsPerSub as $key2) {
                            $key2['time'] = date("M d, Y", $key2['time'])." - ".date("h:iA", $key2['time']);
                            $key['subjects'][] = $key2;
                        }
                    }
                }
                $key['schedule_time'] = date("M d, Y", $key['schedule_time'])." - ".date("h:iA", $key['schedule_time']);
                $key['release_time'] = date("M d, Y", $key['release_time'])." - ".date("h:iA", $key['release_time']);
                $result['results'][] = $key;
            }
        }
    }

    if(isset($_POST['chat_list'])){
        $sub_id = $user_info['current_subject_id'];
        $dept_id = $user_info['current_department_id'];
        $csession = $user_info['current_session_id'];
        $result['chats'] = array();
        if($query = mysqli_query($connect, "SELECT * FROM `chats` WHERE (`dept_id`='$dept_id' AND `csession` = '$csession') OR `sub_id`='$sub_id' ORDER BY `chats`.`id` DESC")){
            foreach ($query as $key) {
                foreach($sessions as $values){
                    if($key['csession'] == $values['id']){
                        $key['csession_name'] = $values['name'];
                    }
                }
                foreach($subjects as $values){
                    if($key['sub_id'] == $values['id']){
                        $key['sub_name'] = $values['subject_name'];
                    }
                }
                foreach($departments as $values){
                    if($key['dept_id'] == $values['id']){
                        $key['dept_name'] = $values['department_name_short'];
                    }
                }
                $result['chats'][] = $key;
            }
        }
    }


    if(isset($_POST['message_list'])){
        $chat_id = $_POST['message_list'];
        $min_id = $_POST['min_id']+1;
        $result['message_list'] = array();
        $max_id = 0;
        if($check_max_id_query = mysqli_query($connect, "SELECT * FROM `chats_messages` ORDER BY `chats_messages`.`id` DESC LIMIT 1")){
            foreach ($check_max_id_query as $key) {
                $max_id = $key['id'];
            }
        }
        if($query = mysqli_query($connect, "SELECT * FROM `chats_messages` WHERE `chat_id` = '$chat_id' AND (`id` BETWEEN $min_id AND $max_id) ORDER BY `chats_messages`.`id` DESC")){
            foreach ($query as $key) {
                $key['user_id'] = user_info($key['user_id']);
                $result['message_list'][] = $key;
            }
        }
    }


    if(isset($_POST['add_message'])){
        $chat_id = sanitizeInput($_POST['add_message']);
        $message = sanitizeInput($_POST['message']);
        $result['add_message'] = false;

        $pic_uploaded = "#";
        if (isset($_FILES['image']['tmp_name'])) {
            if(!($pic_uploaded = upload($_FILES['one_image']['tmp_name']))){
                $pic_uploaded = "#";
            }
        }


        if($query = mysqli_query($connect, "INSERT INTO `chats_messages` (`chat_id`, `user_id`, `message`, `img_url`, `time`) VALUES ('$chat_id', '$user_info[id]', '$message', '$pic_uploaded', '$time');")){
            $result['add_message'] = true;
        }
    }
}





if (isset($user_info['type']) && isset($_POST['user_info']) && ($user_info['type'] == "ADMIN" || $user_info['type'] == "TEACHER" || $_POST['user_info'] == $user_id)) {
    $preID = sanitizeInput($_POST['user_info']);
    $result['user_info'] = user_info($preID);
    // $result['my_info'] = $user_info;
    if($preID == $user_id){
        $result['edit_pass'] = true;
    }else{
        $result['edit_pass'] = false;
    }
}

$result['login'] = isset($user_info['id']);
$result['type'] = $user_id?$user_info['type']:false;


echo json_encode($result);