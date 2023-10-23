<?php
if(!isset($index)){
    header("HTTP/1.0 403");
    exit();
}

require_once './view-header.php';
require_once './view-navbar.php';
if(true){







$errors = [];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && $user_info['type'] == "ADMIN") {
    // Retrieve and sanitize form inputs
    $fname = sanitizeInput($_POST["ame4s7-fname"]);
    $lname = sanitizeInput($_POST["ame4s7-lname"]);
    $nid = removeSpaces(sanitizeInput($_POST["ame4s7-nid"]));
    $phone = removeSpaces(sanitizeInput($_POST["ame4s7-phone"]));
    $email = sanitizeEmail($_POST["ame4s7-email"]);
    $current_section_id = intval($_POST["ame4s7-current-section-id"]);
    $current_department_id = intval($_POST["ame4s7-current-department-id"]);

    // Validate inputs
    if (empty($fname)) {
        $errors[] = "First name is required.";
    }

    if (empty($lname)) {
        $errors[] = "Last name is required.";
    }

    if (empty($nid)) {
        $errors[] = "NID number is required.";
    }

    if (empty($phone)) {
        $errors[] = "Phone number is required.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }


    if (empty($current_section_id)) {
        $errors[] = "Current section is required.";
    }

    if (empty($current_department_id)) {
        $errors[] = "Current department is required.";
    }

    // If there are no errors, you can proceed with database insertion
    if (empty($errors)) {

      $student_id = false;
      $pic_uploaded = false;
      if (isset($_FILES['ame4s7-pic']['tmp_name'])) {
        $pic_uploaded = upload($_FILES['ame4s7-pic']['tmp_name']);
      }

      if($queryForRoll = mysqli_query($connect, "SELECT * FROM `users` WHERE `admission_session_id` LIKE '$session[id]' AND `current_department_id` LIKE '$current_department_id' ORDER BY `users`.`id` DESC LIMIT 1")){
        $student_id = $session["id"].substr($session['year'], -2).$current_department_id."001";
        foreach($queryForRoll as $key){
          $student_id = (int)$key["student_id"] + 1;
        }
      }

        $sql = "INSERT INTO users (`type`, fname, lname, nid_number, phone, email, admission_session_id, current_session_id, current_section_id, current_department_id, student_id, pic, `time`) VALUES ('STUDENT','$fname', '$lname', '$nid', '$phone', '$email', '$session[id]', '$session[id]', '$current_section_id', '$current_department_id', '$student_id', '$pic_uploaded', $time)";

        if ($student_id && $pic_uploaded && mysqli_query($connect, $sql)) {
            $inserted_id = mysqli_insert_id($connect);
            header("Location: ?studentAdded=$inserted_id&studentId=$student_id");
            exit();
        }
    }
}








?>
<title>Student Information</title>
<?php if($user_info['type'] == "ADMIN"){ ?>
<div class="ame4s7-form">
    <h2 onclick="document.querySelector('.modeClick').classList.toggle('modeShow');" class="modeSwitch">Add New Student</h2>
    <form method="POST" enctype="multipart/form-data" class="modeClick">
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
              <label class="ame4s7-label" for="ame4s7-fname">First Name:</label>
              <input class="ame4s7-input" type="text" id="ame4s7-fname" name="ame4s7-fname" required>
          </div>
          <div class="ame4s7-row">
              <label class="ame4s7-label" for="ame4s7-lname">Last Name:</label>
              <input class="ame4s7-input" type="text" id="ame4s7-lname" name="ame4s7-lname" required>
          </div>
        
          <div class="ame4s7-row">
              <label class="ame4s7-label" for="ame4s7-nid">NID Number:</label>
              <input class="ame4s7-input" type="number" id="ame4s7-nid" name="ame4s7-nid" required>
          </div>
        </div>
        
        <div class="ame4s7-dual-row">
          <div class="ame4s7-row">
              <label class="ame4s7-label" for="ame4s7-phone">Phone Number:</label>
              <input class="ame4s7-input" type="number" id="ame4s7-phone" name="ame4s7-phone" required>
          </div>
          <div class="ame4s7-row">
              <label class="ame4s7-label" for="ame4s7-email">Email:</label>
              <input class="ame4s7-input" type="email" id="ame4s7-email" name="ame4s7-email" required>
          </div>
          <div class="ame4s7-row">
              <label class="ame4s7-label" for="ame4s7-pic">Picture:</label>
              <input class="ame4s7-input" type="file" id="ame4s7-pic" name="ame4s7-pic" accept="image/*" required>
          </div>
        </div>
        <div class="ame4s7-dual-row">
          <div class="ame4s7-row">
              <label class="ame4s7-label" for="ame4s7-admission-session">Admission Session:</label>
              <select class="ame4s7-select" id="ame4s7-admission-session" name="ame4s7-admission-session-id" required>
              <optgroup>
                <?php
                  echo "<option value=\"$session[id]\" selected>$session[name]</option>";
                ?>
              </optgroup>
              </select>
          </div>
          <div class="ame4s7-row">
              <label class="ame4s7-label" for="ame4s7-current-session">Current Session:</label>
              <select class="ame4s7-select" id="ame4s7-current-session" name="ame4s7-current-session-id" required>
              <optgroup>
                <?php
                  echo "<option value=\"$session[id]\" selected>$session[name]</option>";
                ?>
              </optgroup>
              </select>
          </div>
          <div class="ame4s7-row">
              <label class="ame4s7-label" for="ame4s7-section">Section:</label>
              <select class="ame4s7-select" id="ame4s7-section" name="ame4s7-current-section-id" required>
              <optgroup>
                <?php
                  foreach ($sections as $key) {
                    echo "<option value=\"$key[id]\">$key[section_mode] - $key[section_code]</option>";
                  }
                ?>
              </optgroup>
              </select>
          </div>
          <div class="ame4s7-row">
              <label class="ame4s7-label" for="ame4s7-department">Department:</label>
              <select class="ame4s7-select" id="ame4s7-department" name="ame4s7-current-department-id" required>
              <optgroup>
                <?php
                  foreach ($departments as $key) {
                    echo "<option value=\"$key[id]\">$key[department_name_short] - $key[department_name_full]</option>";
                  }
                ?>
              </optgroup>
              </select>
          </div>
        </div>
        <button class="ame4s7-button" type="submit">Add Student</button>
    </form>
</div>
<?php } ?>
<div class="flex-form">
  <div class="form-row">
    <select name="admission-session">
      <option value="" selected>Admission Session</option>
      <optgroup>
        <?php
          foreach ($sessions as $key) {
            echo "<option value=\"$key[id]\">$key[name]</option>";
          }
        ?>
      </optgroup>
    </select>
  </div>
  <div class="form-row">
    <select name="current-session">
      <option value="" selected>Current Session</option>
      <optgroup>
        <?php
          foreach ($sessions as $key) {
            echo "<option value=\"$key[id]\">$key[name]</option>";
          }
        ?>
      </optgroup>
    </select>
  </div>
  <div class="form-row">
    <select name="section">
      <option value="" selected>Section</option>
      <optgroup>
        <?php
          foreach ($sections as $key) {
            echo "<option value=\"$key[id]\">$key[section_mode] - $key[section_code]</option>";
          }
        ?>
      </optgroup>
    </select>
  </div>
  <div class="form-row">
    <select name="department">
      <option value="" selected>Department</option>
      <optgroup>
        <?php
          foreach ($departments as $key) {
            echo "<option value=\"$key[id]\">$key[department_name_short] - $key[department_name_full]</option>";
          }
        ?>
      </optgroup>
    </select>
  </div>
  <div class="form-row">
    <select name="status">
      <option value="">Status</option>
      <optgroup>
        <?php
        foreach ($allStatusMode as $key) {
          if($key == "ACTIVE"){
            echo "<option selected value=\"$key\">$key</option>";
          }else{
            echo "<option value=\"$key\">$key</option>";
          }          
        }
        ?>
      </optgroup>
    </select>
  </div>
  <div class="form-row">
    <input type="text" placeholder="Name/ID/Phone/Email">
  </div>
  <div class="form-row">
    <input type="button" value="Search">
  </div>
</div>
<table class="student-table">
    <thead>
        <tr>
            <th>User ID</th>
            <th>Student ID</th>
            <th>PIC</th>
            <th>Full Name</th>
            <th>Phone Number</th>
            <th>Email Address</th>
            <th>NID number</th>
            <th>Admission</th>
            <th>Current</th>
            <th>Section</th>
            <th>Department</th>
            <th>Time</th>
        </tr>
    </thead>
    <tbody class="students-put"></tbody>
</table>
<script>
let studentsPut = document.querySelector(".students-put");
let studentTable = document.querySelector(".student-table");
let flexForm = document.querySelector(".flex-form");

let admissionSessionInput = flexForm.querySelector('select[name="admission-session"]');
let currentSessionInput = flexForm.querySelector('select[name="current-session"]');
let statusInput = flexForm.querySelector('select[name="status"]');
let searchInput = flexForm.querySelector('input[type="text"]');
let section = flexForm.querySelector('select[name="section"]');
let department = flexForm.querySelector('select[name="department"]');
let searchButton = flexForm.querySelector('input[type="button"]');
studentTable.hidden = true;
searchButton.onclick=e=>{
  studentTable.hidden = true;
  loadLink('/json', [['table','students'],['admissionSession', admissionSessionInput.value],['currentSession', currentSessionInput.value],['status', statusInput.value],['search', searchInput.value],['section', section.value],['department', department.value]]).then(result=>{
    console.log(result);
    if("students" in result){
      if(result.students.length > 0){
        studentTable.hidden = false;
        studentsPut.innerHTML = "";
        result.students.forEach(student => {
          tr = create("tr");
          tr.innerHTML += `<td>${student.id}</td>
                          <td>${student.student_id}</td>
                          <td><img src="/${student.pic}"/></td>
                          <td>${student.fname} ${student.lname}</td>
                          <td>${student.phone}</td>
                          <td>${student.email}</td>
                          <td>${student.nid_number}</td>
                          <td>${student.admission_session_id}</td>
                          <td>${student.current_session_id}</td>
                          <td>${student.current_section_id}</td>
                          <td>${student.current_department_id}</td>
                          <td>${student.time}</td>`;
          studentsPut.appendChild(tr);
          tr.onclick=e=>{
            showPopUpUserDetails(student.id);
          }
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