<?php
if(!isset($index)){
    header("HTTP/1.0 403");
    exit();
}
if($user_info['type'] == "ADMIN" || $user_info['type'] == "TEACHER"){
    header("Location: /students");
}else{
    header("Location: /notices");
}
echoArray($user_info);