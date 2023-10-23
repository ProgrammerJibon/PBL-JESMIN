<?php 
if(!isset($index)){
    header("HTTP/1.0 403");
}?>

    <ul>
<?php if($user_info){ ?>
    <?php if($user_info['type'] == "ADMIN"){ ?>
    <li><a href="/students">Students</a></li>
    <li><a href="/teachers">Teachers</a></li>
    <li><a href="/results">Results</a></li>
    <li><a href="/subjects">Subjects</a></li>
    <li><a href="/sessions">Sessions</a></li>
    <li><a href="/sections">Sections</a></li>
    <li><a href="/departments">Departments</a></li>
    <li><a href="/notices">Notices</a></li>
    <?php } ?>

    <?php if($user_info['type'] == "TEACHER"){ ?>
    <li><a href="/students">Students</a></li>
    <li><a href="/results">Results</a></li>
    <li><a href="/notices">Notices</a></li>
    <?php } ?>

    <?php if($user_info['type'] == "STUDENT"){ ?>
    <li><a href="/results">Results</a></li>
    <li><a href="/notices">Notices</a></li>
    <?php } ?>
<?php } ?>