<?php
if (!isset($index)) {
    header("HTTP/1.0 403");
    exit();
}

require_once './view-header.php';
require_once './view-navbar.php';
if (true) {









    $errors = [];

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $user_info['type'] == "ADMIN") {
        // Retrieve and sanitize form inputs
        $title = sanitizeInput($_POST["ame4s7-title"]);
        $details = sanitizeInput($_POST["ame4s7-details"]);
        $fdate = removeSpaces(sanitizeInput($_POST["ame4s7-any-time"]));
        $asession = removeSpaces(sanitizeInput($_POST["ame4s7-asession"]));
        $cdepartment = sanitizeEmail($_POST["ame4s7-current-department-id"]);
        $csubject = intval($_POST["ame4s7-current-subject-id"]);

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
        if (empty($cdepartment) && $cdepartment != "0") {
            $errors[] = "Current department is required.";
        }
        if (empty($csubject) && $csubject != "0") {
            $errors[] = "Subject is required.";
        }

        // If there are no errors, you can proceed with database insertion
        if (empty($errors)) {

            $pic_uploaded = "#";
            if (isset($_FILES['ame4s7-any-image']['tmp_name'])) {
                if(!($pic_uploaded = upload($_FILES['ame4s7-any-image']['tmp_name']))){
                    $pic_uploaded = "#";
                }
            }


            $sql = "INSERT INTO `notices` (`current_department`, `admission_session`, `current_subject`, `notice_title`, `notice_desc`, `notice_image`, `added_time`, `event_time`, `by_user_id`) VALUES ('$cdepartment', '$asession', '$csubject', '$title', '$details', '$pic_uploaded', '$time', '$fdateFinal', '$user_id')";

            if ($pic_uploaded && mysqli_query($connect, $sql)) {
                $inserted_id = mysqli_insert_id($connect);
                header("Location: ?noticeAdded=$inserted_id");
                exit();
            }
        }
    }







?>
    <title>All Notices</title>
    <?php if($user_info['type'] == "ADMIN"){ ?>
    <div class="ame4s7-form">
        <h2 onclick="document.querySelector('.modeClick').classList.toggle('modeShow');" class="modeSwitch">Add new notice</h2>
        <form method="POST" enctype="multipart/form-data" class="-modeClick">
            <div class="ame4s7-row">
                <font>
                    <?php
                    if (!empty($errors)) {
                        foreach ($errors as $key) {
                            echo $key;
                        }
                    }
                    ?>
                </font>
            </div>
            <div class="ame4s7-dual-row">
                <div class="ame4s7-row">
                    <label class="ame4s7-label" for="ame4s7-fname">Notice Title*</label>
                    <input class="ame4s7-input" type="text" name="ame4s7-title" required>
                </div>
            </div>
            <div class="ame4s7-dual-row">
                <div class="ame4s7-row">
                    <label class="ame4s7-label" for="ame4s7-lname">Notice Details*</label>
                    <textarea class="ame4s7-input" type="text" name="ame4s7-details" required></textarea>
                </div>
            </div>
            <div class="ame4s7-dual-row">
                <div class="ame4s7-row">
                    <label class="ame4s7-label" for="ame4s7-nid">Any Image</label>
                    <input class="ame4s7-input" type="file" accept="image/*" name="ame4s7-any-image">
                </div>
                <div class="ame4s7-row">
                    <label class="ame4s7-label" for="ame4s7-phone">Any time:</label>
                    <input class="ame4s7-input" type="date" min="<?php echo date("Y-m-d", $time) ?>"  name="ame4s7-any-time">
                </div>
            </div>
            <div class="ame4s7-dual-row">
                <div class="ame4s7-row">
                    <label class="ame4s7-label" for="ame4s7-phone">Admission Session:</label>
                    <select class="ame4s7-select" name="ame4s7-asession" required>
                        <option value="0">All Session</option>
                        <optgroup>
                            <?php
                            foreach ($sessions as $key) {
                                echo "<option value=\"$key[id]\">$key[name]</option>";
                            }
                            ?>
                        </optgroup>
                    </select>
                </div>
                <div class="ame4s7-row">
                    <label class="ame4s7-label" for="ame4s7-phone">Department:</label>
                    <select class="ame4s7-select" name="ame4s7-current-department-id" required>
                        <option value="0">All department</option>
                        <optgroup>
                            <?php
                            foreach ($departments as $key) {
                                echo "<option value=\"$key[id]\">$key[department_name_short] - $key[department_name_full]</option>";
                            }
                            ?>
                        </optgroup>
                    </select>
                </div>
                <div class="ame4s7-row">
                    <label class="ame4s7-label" for="ame4s7-phone">Subject:</label>
                    <select class="ame4s7-select" name="ame4s7-current-subject-id" required>
                        <option value="0">All Subject</option>
                        <optgroup>
                            <?php
                            foreach ($subjects as $key) {
                                echo "<option value=\"$key[id]\">$key[subject_name] - $key[subject_code]</option>";
                            }
                            ?>
                        </optgroup>
                    </select>
                </div>
            </div>
            
            <button class="ame4s7-button" type="submit">Add Notice</button>
        </form>
    </div>
    <?php } ?>



    <div class="flex-form">
        <div class="form-row">
            <select class="ame4s7-select" id="ame4s7-subject-id" name="subjectId" required>
                <option value="0" selected>Subject</option>
                <optgroup><?php
                    if($user_info["type"] != "STUDENT"){
                        foreach ($subjects as $key) {
                            echo "<option value=\"$key[id]\">$key[subject_code] - $key[subject_name]</option>";
                        }
                    }
                    ?>
                </optgroup>
            </select>
        </div>
        <div class="form-row">
            <select name="department">
                <?php
                if($user_info["type"] != "STUDENT"){
                    echo '<option value="0">Department</option>';
                }    
                ?>
                <optgroup>
                    <?php
                    foreach ($departments as $key) {
                        if($user_info["type"] == "STUDENT"){
                            if($key["id"] == $user_info["current_department_id"]){
                                echo "<option selected value=\"$key[id]\">$key[department_name_short] - $key[department_name_full]</option>";
                            }
                        }else{
                            echo "<option value=\"$key[id]\">$key[department_name_short] - $key[department_name_full]</option>";
                        }                        
                    }
                    ?>
                </optgroup>
            </select>
        </div>
        <div class="form-row">
            <select name="asession">
                <?php
                if($user_info["type"] != "STUDENT"){
                    echo '<option value="0">Admission Session</option>';
                }    
                ?>
                <optgroup>
                    <?php
                    foreach ($sessions as $key) {
                        if($user_info["type"] == "STUDENT"){
                            if($key["id"] == $user_info["admission_session_id"]){
                                echo "<option value=\"$key[id]\">$key[name]</option>";
                            }
                        }else{
                            echo "<option value=\"$key[id]\">$key[name]</option>";
                        }                        
                    }
                    ?>
                </optgroup>
            </select>
        </div>
        <div class="form-row">
            <input type="text" placeholder="search anything...">
        </div>
        <div class="form-row">
            <input type="button" value="Search">
        </div>
    </div>
    <table class="student-table">
        <thead>
            <tr>
                <th>User ID</th>
                <th>PIC</th>
                <th>Title</th>
                <th>Details</th>
                <th>Event Date</th>
                <th>For Admission Session</th>
                <th>For Department</th>
                <th>For Subject</th>
                <th>By User</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody class="students-put"></tbody>
    </table>
    <script>
        let studentsPut = document.querySelector(".students-put");
        let studentTable = document.querySelector(".student-table");
        let flexForm = document.querySelector(".flex-form");


        let asession = flexForm.querySelector('select[name="asession"]');
        let subjectId = flexForm.querySelector('select[name="subjectId"]');
        let searchInput = flexForm.querySelector('input[type="text"]');
        let department = flexForm.querySelector('select[name="department"]');
        let searchButton = flexForm.querySelector('input[type="button"]');
        studentTable.hidden = true;
        searchButton.onclick = e => {
            studentTable.hidden = true;
            loadLink('/json', [
                ['table', 'notices'],
                ['department', department.value],
                ['asession', asession.value],
                ['subjectId', subjectId.value]
            ]).then(result => {
                console.log(result);
                if ("notices" in result) {
                    if (result.notices.length > 0) {
                        studentTable.hidden = false;
                        studentsPut.innerHTML = "";
                        result.notices.forEach(student => {
                            tr = create("tr");
                            tr.innerHTML += `<td>${student.id}</td>
                                      <td><img src="/${student.notice_image}"/></td>
                                      <td>${student.notice_title}</td>
                                      <td>${student.notice_desc}</td>
                                      <td>${student.event_time}</td>
                                      <td>${student.admission_session}</td>
                                      <td>${student.current_department}</td>
                                      <td>${student.current_subject}</td>
                                      <td>${student.by_user_id}</td>
                                      <td>${student.added_time}</td>`;
                            studentsPut.appendChild(tr);
                        });
                    }
                }
            })
        };
        searchButton.onclick();
    </script>
<?php
}
require_once './view-footer.php';
