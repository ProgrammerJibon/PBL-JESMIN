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
        $zname = sanitizeInput($_POST["ame4s7-zname"]);

        // Validate inputs
        if (empty($fname)) {
            $errors[] = "Session name is required.";
        }

        if (empty($lname)) {
            $errors[] = "Year is required.";
        }

        if (empty($zname)) {
            $errors[] = "Season name is required.";
        }

        // If there are no errors, you can proceed with database insertion
        if (empty($errors)) {

            $preID = isset($sessions[0]['id'])?$sessions[0]['id']+1:0;

            $sql = "INSERT INTO `sessions_name` (`id`, `name`, `year`, `season`, `time`) VALUES ('$preID', '$fname', '$zname', '$lname', '$time')";

            if (mysqli_query($connect, $sql)) {
                $inserted_id = mysqli_insert_id($connect);
                header("Location: ?sessionAdded=$inserted_id");
                exit();
            }
        }
    }








?>
    <title>Sessions</title>
    <div class="ame4s7-form">
        <h2 onclick="document.querySelector('.modeClick').classList.toggle('modeShow');" class="modeSwitch">Add New Session</h2>
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
                    <label class="ame4s7-label" for="ame4s7-fname">Session Name:</label>
                    <input class="ame4s7-input" type="text" id="ame4s7-fname" name="ame4s7-fname" required>
                </div>
                <div class="ame4s7-row">
                    <label class="ame4s7-label" for="ame4s7-lname">Season Name:</label>
                    <select name="ame4s7-lname">
                        <optgroup>
                            <?php
                            foreach ($seasons as $key) {
                                echo "<option selected value=\"$key\">$key</option>";
                            }
                            ?>
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class="ame4s7-dual-row">
                <div class="ame4s7-row">
                    <label class="ame4s7-label" for="ame4s7-current-department-id">Year:</label>
                    <select name="ame4s7-zname">
                        <optgroup>
                            <?php
                                echo "<option selected value=\"".date("Y")."\">".date("Y")."</option>";
                                echo "<option value=\"".(date("Y")+1)."\">".(date("Y")+1)."</option>";
                            ?>
                        </optgroup>
                    </select>
                </div>
                <div class="ame4s7-row">
                    <label class="ame4s7-label" for="ame4s7-current-department-id">`</label>
                    <button class="ame4s7-button" type="submit">Add Session</button>
                </div>
            </div>
        </form>
    </div>




    
    <table class="student-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Year</th>
                <th>Season</th>
                <th>Added Time</th>
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
                ['table', 'sessions']
            ]).then(result => {
                console.log(result);
                if ("students" in result) {
                    if (result.students.length > 0) {
                        studentTable.hidden = false;
                        studentsPut.innerHTML = "";
                        result.students.forEach(student => {
                            studentsPut.innerHTML += `<tr>
                                      <td>${student.id}</td>
                                      <td>${student.name}</td>
                                      <td>${student.year}</td>
                                      <td>${student.season}</td>
                                      <td>${student.time}</td>
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
