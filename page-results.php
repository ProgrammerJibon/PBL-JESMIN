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
        $resname = sanitizeInput($_POST["ame4s7-fname"]);
        $asession = sanitizeInput($_POST["ame4s7-asession"]);
        $csession = sanitizeInput($_POST["ame4s7-csession"]);
        $dept = sanitizeInput($_POST["ame4s7-dept"]);
        $pdate = sanitizeInput($_POST["ame4s7-pdate"]);

        $pdate = explode("-", $pdate);
        $pdateFinal = "";

        if (sizeof($pdate) == 3) {
            if(!($pdateFinal = date_to_timestamp($pdate[0], $pdate[1], $pdate[2]))){
                $pdateFinal = "";
            }
        }

        // Validate inputs
        if (empty($resname)) {
            $errors[] = "result name is required.";
        }

        if (empty($asession)) {
            $errors[] = "admission session is required.";
        }

        if (empty($csession)) {
            $errors[] = "current session is required.";
        }

        if (empty($dept)) {
            $errors[] = "department is required.";
        }

        if (empty($pdateFinal)) {
            $errors[] = "Publishing date is required.";
        }

        // If there are no errors, you can proceed with database insertion
        if (empty($errors)) {

            $preID = isset($sessions[0]['id'])?$sessions[0]['id']+1:0;

            $sql = "INSERT INTO `results_name` (`result_name`, `department_id`, `admission_session`, `current_session`, `schedule_time`, `release_time`) VALUES ('$resname', '$dept', '$asession', '$csession', '$time', '$pdateFinal')";

            if (mysqli_query($connect, $sql)) {
                $inserted_id = mysqli_insert_id($connect);
                header("Location: ?resultnameadded=$inserted_id");
                exit();
            }
        }
    }








?>
    <title>Result</title>
    <?php if($user_info['type'] == "ADMIN"){ ?>
    <div class="ame4s7-form">
        <h2 onclick="document.querySelector('.modeClick').classList.toggle('modeShow');" class="modeSwitch">Add New Result</h2>
        <form method="POST" enctype="multipart/form-data" class="modeClick" onsubmit="return confirm('Are sure to Add New Session?\nYou\'ll be unable to modify this without phpMyAdmin.')">
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
                    <label class="ame4s7-label" for="ame4s7-rname">Result Name:</label>
                    <input class="ame4s7-input" type="text" id="ame4s7-fname" name="ame4s7-fname" required>
                </div>
                <div class="ame4s7-row">
                    <label class="ame4s7-label" for="ame4s7-lname">Admission session:</label>
                    <select name="ame4s7-asession">
                        <optgroup>
                            <?php
                            foreach ($sessions as $key) {
                                echo "<option selected value=\"$key[id]\">$key[name]</option>";
                            }
                            ?>
                        </optgroup>
                    </select>
                </div>
                <div class="ame4s7-row">
                    <label class="ame4s7-label" for="ame4s7-lname">Current session:</label>
                    <select name="ame4s7-csession">
                        <optgroup>
                            <?php
                            if ($key = $sessions[0]) {
                                echo "<option selected value=\"$key[id]\">$key[name]</option>";
                            }
                            ?>
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class="ame4s7-dual-row">
                <div class="ame4s7-row">
                    <label class="ame4s7-label" for="ame4s7-lname">Deparmtent:</label>
                    <select name="ame4s7-dept">
                        <optgroup>
                            <?php
                            foreach ($departments as $key) {
                                echo "<option selected value=\"$key[id]\">$key[department_name_full]</option>";
                            }
                            ?>
                        </optgroup>
                    </select>
                </div>
                <div class="ame4s7-row">
                    <label class="ame4s7-label" for="ame4s7-rname">Publishing date:</label>
                    <input class="ame4s7-input" type="date" value="<?php echo date("Y-m-d", $time+86400*7); ?>" min="<?php echo date("Y-m-d", $time+86400*1); ?>" id="ame4s7-dname" name="ame4s7-pdate" required>
                </div>
                <div class="ame4s7-row">
                    <label class="ame4s7-label" for="ame4s7-current-department-id">`</label>
                    <button class="ame4s7-button" type="submit">Add Result Date</button>
                </div>
            </div>
        </form>
    </div>
    <?php } ?>




    
    <table class="student-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Exam Name</th>
                <th>Admission Session ID</th>
                <th>Current Session ID</th>
                <th>Deparmtent ID</th>
                <th>Result Publishing Time</th>
                <th>Result Anouncment Time</th>
            </tr>
        </thead>
        <tbody class="students-put"></tbody>
    </table>
    <script>
        let studentsPut = document.querySelector(".students-put");
        let studentTable = document.querySelector(".student-table");
        let flexForm = document.querySelector(".flex-form");


        studentTable.hidden = true;
        let myFun = e => {
            studentTable.hidden = true;
            loadLink('/json', [
                ['table', 'results_name']
            ]).then(result => {
                console.log(result);
                if ("students" in result) {
                    if (result.students.length > 0) {
                        studentTable.hidden = false;
                        studentsPut.innerHTML = "";
                        result.students.forEach(student => {
                            sessions.forEach(session=>{
                                if(session.id == student.session_id){
                                    student.session_id = session.name;
                                }
                            });
                            
                            studentsPut.innerHTML += `<tr <?php echo 'onclick="tab(\'/result?res_id=${student.id}\')"'; ?>>
                                      <td>${student.id}</td>
                                      <td>${student.result_name}</td>
                                      <td>${student.admission_session}</td>
                                      <td>${student.current_session}</td>
                                      <td>${student.department_id}</td>
                                      <td>${student.release_time}</td>
                                      <td>${student.schedule_time}</td>
                                  </tr>`;
                        });
                    }
                }
            })
        };
        myFun();
    </script>
<?php
}
require_once './view-footer.php';
