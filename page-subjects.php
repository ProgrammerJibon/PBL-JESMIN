<?php
if (!isset($index)) {
    header("HTTP/1.0 403");
    exit();
}

require_once './view-header.php';
require_once './view-navbar.php';
if ($user_info['type'] == "ADMIN") {









    $errors = [];

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve and sanitize form inputs
        $fname = sanitizeInput($_POST["ame4s7-fname"]);
        $lname = sanitizeInput($_POST["ame4s7-lname"]);
        $current_department_id = intval($_POST["ame4s7-current-department-id"]);

        // Validate inputs
        if (empty($fname)) {
            $errors[] = "First name is required.";
        }

        if (empty($lname)) {
            $errors[] = "Last name is required.";
        }

        if (empty($current_department_id)) {
            $errors[] = "Current department is required.";
        }

        // If there are no errors, you can proceed with database insertion
        if (empty($errors)) {

            $sql = "INSERT INTO `subject_list` (`id`, `subject_name`, `subject_code`, `department_id`) VALUES (NULL, '$fname', '$lname', '$current_department_id')";

            if (mysqli_query($connect, $sql)) {
                $inserted_id = mysqli_insert_id($connect);
                header("Location: ?subjectAdded=$inserted_id");
                exit();
            }
        }
    }








?>
    <title>Subjects</title>
    <div class="ame4s7-form">
        <h2 onclick="document.querySelector('.modeClick').classList.toggle('modeShow');" class="modeSwitch">Add Subject</h2>
        <form method="POST" enctype="multipart/form-data" class="modeClick" onsubmit="return confirm('Are sure to add subject?\nYou\'ll be unable to modify this without phpMyAdmin.')">
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
                    <label class="ame4s7-label" for="ame4s7-fname">Subject Name:</label>
                    <input class="ame4s7-input" type="text" id="ame4s7-fname" name="ame4s7-fname" required>
                </div>
                <div class="ame4s7-row">
                    <label class="ame4s7-label" for="ame4s7-lname">Subject Code:</label>
                    <input class="ame4s7-input" type="text" id="ame4s7-lname" name="ame4s7-lname" required>
                </div>
            </div>
            <div class="ame4s7-dual-row">
                <div class="ame4s7-row">
                    <label class="ame4s7-label" for="ame4s7-current-department-id">Department:</label>
                    <select class="ame4s7-select" id="ame4s7-current-department-id" name="ame4s7-current-department-id" required>
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
                    <label class="ame4s7-label" for="ame4s7-current-department-id">`</label>
                    <button class="ame4s7-button" type="submit">Add Subject</button>
                </div>
            </div>
        </form>
    </div>




    <div class="flex-form">
        <div class="form-row">
            <select name="department">
                <?php
                foreach ($departments as $key) {
                    echo "<option value=\"$key[id]\">$key[department_name_short] - $key[department_name_full]</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-row">
            <input type="button" value="Search">
        </div>
    </div>
    <table class="student-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Code</th>
                <th>Department</th>
            </tr>
        </thead>
        <tbody class="students-put"></tbody>
    </table>
    <script>
        let studentsPut = document.querySelector(".students-put");
        let studentTable = document.querySelector(".student-table");
        let flexForm = document.querySelector(".flex-form");


        let department = flexForm.querySelector('select[name="department"]');
        let searchButton = flexForm.querySelector('input[type="button"]');
        studentTable.hidden = true;
        searchButton.onclick = e => {
            studentTable.hidden = true;
            loadLink('/json', [
                ['table', 'subjects'],
                ['department', department.value]
            ]).then(result => {
                console.log(result);
                if ("students" in result) {
                    if (result.students.length > 0) {
                        studentTable.hidden = false;
                        studentsPut.innerHTML = "";
                        result.students.forEach(student => {
                            studentsPut.innerHTML += `<tr>
                                      <td>${student.id}</td>
                                      <td>${student.subject_name}</td>
                                      <td>${student.subject_code}</td>
                                      <td>${student.department_id}</td>
                                  </tr>`;
                        });
                    }
                }
            })
        };
        searchButton.onclick();
        department.onchange = e =>{
            searchButton.onclick();
        }
    </script>
<?php
}
require_once './view-footer.php';
