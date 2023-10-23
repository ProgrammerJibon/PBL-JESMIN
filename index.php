<?php
$index = true;
require_once('./functions.php');
if(isset($_GET['page'])){
    $uri = explode("/",($_GET['page']));
    $page = strtolower($uri[0]);
    isset($uri[1]) ? $path = $uri[1] : $path = NULL;
    if($page == 'json'){
        require_once"./json.php";
    }elseif($page == 'logout'){
        setcookie("user-x", "", 0);
        header("Location: /");
    }elseif($page == 'students'){
        require_once"./page-students.php";
    }elseif($page == 'teachers'){
        require_once"./page-teachers.php";
    }elseif($page == 'subjects'){
        require_once"./page-subjects.php";
    }elseif($page == 'departments'){
        require_once"./page-departments.php";
    }elseif($page == 'sections'){
        require_once"./page-sections.php";
    }elseif($page == 'notices'){
        require_once"./page-notices.php";
    }elseif($page == 'results'){
        require_once"./page-results.php";
    }elseif($page == 'sessions'){
        require_once"./page-sessions.php";
    }elseif($page == 'result'){
        require_once"./page-result-name.php";
    }else{
        echo $page;
    }
}else{
    require_once ($user_info?"./page-home.php":"./page-login.php");
}