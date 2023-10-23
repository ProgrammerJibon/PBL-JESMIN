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

        // Validate inputs
        if (empty($fname)) {
            $errors[] = "First name is required.";
        }

        if (empty($lname)) {
            $errors[] = "Last name is required.";
        }

        // If there are no errors, you can proceed with database insertion
        if (empty($errors)) {

            $sql = "INSERT INTO `department` (`id`, `department_name_short`, `department_name_full`) VALUES (NULL, '$fname', '$lname')";

            if (mysqli_query($connect, $sql)) {
                $inserted_id = mysqli_insert_id($connect);
                header("Location: ?subjectAdded=$inserted_id");
                exit();
            }
        }
    }








?>
    <title>Departments</title>
    <div class="ame4s7-form">
        <h2 onclick="document.querySelector('.modeClick').classList.toggle('modeShow');" class="modeSwitch">Add Department</h2>
        <form method="POST" enctype="multipart/form-data" class="modeClick" onsubmit="return confirm('Are sure to add departmnet?\nYou\'ll be unable to modify this without phpMyAdmin.')">
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
                    <label class="ame4s7-label" for="ame4s7-fname">Department Short Name:</label>
                    <input class="ame4s7-input" type="text" id="ame4s7-fname" name="ame4s7-fname" required>
                </div>
                <div class="ame4s7-row">
                    <label class="ame4s7-label" for="ame4s7-lname">Department Full Name:</label>
                    <input class="ame4s7-input" type="text" id="ame4s7-lname" name="ame4s7-lname" required>
                </div>
            </div>
            <div class="ame4s7-dual-row">
                <div class="ame4s7-row">
                    <button class="ame4s7-button" type="submit">Add Department</button>
                </div>
            </div>
        </form>
    </div>



    <table class="student-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Short Name</th>
                <th>Full Name</th>
            </tr>
        </thead>
        <tbody class="students-put"></tbody>
    </table>
    <script>
        let studentsPut = document.querySelector(".students-put");
        let studentTable = document.querySelector(".student-table");
        let flexForm = document.querySelector(".flex-form");

        studentTable.hidden = true;
        var myFun = () => {
            studentTable.hidden = true;
            loadLink('/json', [
                ['table', 'departments']
            ]).then(result => {
                console.log(result);
                if ("students" in result) {
                    if (result.students.length > 0) {
                        studentTable.hidden = false;
                        studentsPut.innerHTML = "";
                        result.students.forEach(student => {
                            studentsPut.innerHTML += `<tr>
                                      <td>${student.id}</td>
                                      <td>${student.department_name_short}</td>
                                      <td>${student.department_name_full}</td>
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
