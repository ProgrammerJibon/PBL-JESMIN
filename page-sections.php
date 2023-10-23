<?php
if (!isset($index)) {
    header("HTTP/1.0 403");
    exit();
}

require_once './view-header.php';
require_once './view-navbar.php';
if ($user_info['type'] == "ADMIN") {









    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fname = sanitizeInput($_POST["ame4s7-fname"], "SPACELESS_TEXT_ONLY");
        $lname = sanitizeInput($_POST["ame4s7-lname"], "SPACELESS_TEXT_ONLY");

        if (empty($fname)) {
            $errors[] = "First name is required.";
        }

        if (empty($lname)) {
            $errors[] = "Last name is required.";
        }

        if (empty($errors)) {

            $sql = "INSERT INTO `sections` (`id`, `section_code`, `section_mode`) VALUES (NULL, '$fname', '$lname')";

            if (mysqli_query($connect, $sql)) {
                $inserted_id = mysqli_insert_id($connect);
                header("Location: ?subjectAdded=$inserted_id");
                exit();
            }
        }
    }








?>
    <title>Sections</title>
    <div class="ame4s7-form">
        <h2 onclick="document.querySelector('.modeClick').classList.toggle('modeShow');" class="modeSwitch">Add Sections</h2>
        <form method="POST" class="modeClick" onsubmit="return confirm('Are sure to add departmnet?\nYou\'ll be unable to modify this without phpMyAdmin.')">
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
                    <label class="ame4s7-label" for="ame4s7-fname">Section Code:</label>
                    <input class="ame4s7-input" type="text" id="ame4s7-fname" name="ame4s7-fname" required>
                </div>
                <div class="ame4s7-row">
                    <label class="ame4s7-label" for="ame4s7-lname">Section Mode:</label>
                    <select name="ame4s7-lname">
                        <optgroup>
                            <?php
                            foreach ($section_modes as $key) {
                                echo "<option value=\"$key\">$key</option>";
                            }
                            ?>
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class="ame4s7-dual-row">
                <div class="ame4s7-row">
                    <button class="ame4s7-button" type="submit">Add Section</button>
                </div>
            </div>
        </form>
    </div>



    <table class="student-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Mode</th>
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
                ['table', 'sections']
            ]).then(result => {
                console.log(result);
                if ("students" in result) {
                    if (result.students.length > 0) {
                        studentTable.hidden = false;
                        studentsPut.innerHTML = "";
                        result.students.forEach(student => {
                            studentsPut.innerHTML += `<tr>
                                      <td>${student.id}</td>
                                      <td>${student.section_code}</td>
                                      <td>${student.section_mode}</td>
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
