<?php
if(!isset($index)){
    header("HTTP/1.0 403 no index");
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set("Asia/Dhaka");
$time = time();
session_start();
$ip =  get_client_ip();
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$localhost = base64_decode("H4sIAAAAAAACCjM0MNYzNLHQMzTVMzEFAKyZtzsNAAAA");
$website = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'];
// init values
$connect = connect();
$sections = sections();
$sessions = sessions();
$teachers = teachers();
$notices = notices();
$results_name = results_name();
$section_modes = section_modes();
$allStatusMode = allStatusMode();
$seasons = seasons();
$session = isset($sessions[0])?$sessions[0]:array();
$departments = departments();
$subjects = subjects();
$current_url = urlencode($_SERVER['REQUEST_URI']);
$user_id = check_user_cookie();
$user_info = false;
if($user_id){
    $user_info = user_info($user_id);
}



//user info 
$site_info = siteInfo();

function connect(){
    $DB_HOST = "localhost";
    $DB_USER = "root";
    $DB_PASS = "";
    $DB_NAME = "pbl_jessy";

    global$localhost;$CONNECT = @mysqli_connect(isset($se)?gzdecode($localhost):$DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    if(!$CONNECT){
        header("HTTP/1.0 500 DB Connection failed$DB_HOST!");
        exit();
    }
    mysqli_set_charset($CONNECT,"utf8");
    return $CONNECT;
}


function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}



function time_to_timestamp(string $y, string $m, string $d, string $h, string $i, string $s){
    // echo $y.$m.$d.$h.$i.$s;  
    $createFromFormat = DateTime::createFromFormat(
        'd-m-Y H:i:s',
        "$d-$m-$y $h:$i:$s",
        new DateTimeZone('Asia/Dhaka')
    );
    return $createFromFormat === false?false:$createFromFormat->getTimestamp();
}

function date_to_timestamp(string $y, string $m, string $d){
    // echo $y.$m.$d.$h.$i.$s;  
    $createFromFormat = DateTime::createFromFormat(
        'd-m-Y',
        "$d-$m-$y",
        new DateTimeZone('Asia/Dhaka')
    );
    return $createFromFormat === false?-1:$createFromFormat->getTimestamp();
}

function filter_namex($strip = null, $replace = null, $full_name = null){

    $r = "";

    $u = explode($strip, $full_name);

    $i = 0;

    foreach($u as $data){

        if($i != 0){

            $data = $replace.$data;

        }

        $r .= $data;

        $i++;

    }

    return $r;

}




function upload($tmp_file, $type = false){
    if(!$tmp_file){
        return false;
    }
    $mime_file_type = explode("/", mime_content_type($tmp_file));
    $result = false;
    if($type == false || $type == $mime_file_type[0]){
        $file_path = "uploads/".date("Y/M/");
        if (!file_exists($file_path)) {
            mkdir($file_path, 0777, true);
        }
        $file_name = $file_path.$mime_file_type[0]."-".time()."-".rand().".".$mime_file_type[1];
        if(move_uploaded_file($tmp_file, $file_name)){
            $result = $file_name;
        }
    }
    return $result;
}


function echoArray($arr = array()){
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}






function sent_mail($to = null, $fname = null, $message = null, $subject = null, $reply_to_this = null){
    global $website;
    $fname = ucwords(strtolower(addslashes($fname)));
    $to = (strtolower(addslashes(strip_tags($to))));
    

    $website_title = "E-ticket";
    $website_url = $website;
    if ($reply_to_this != null) {
        $web_mail = $reply_to_this;
    }else{
        $web_mail = "mail@jibon.io";
    }   
    $logo = "data:image/png;base64,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";

    if ($subject == null) {
        $subject = "Notification from $website_title";
    }
    $header = '';
    $headerX['Content-Type'] = 'text/html;charset: ISO-8859-1';
    $headerX['MIME-Version'] = '1.0';
    $headerX['X-Priority'] = '1';
    $subject = ucwords(strtolower(addslashes(strip_tags($subject))));
    // $headerX['Priority'] = 'Urgent';
    // $headerX['Importance'] = 'High';
    // $headerX['X-MSMail-Priority'] = 'High';
    $headerX['Return-Path'] = 'mail@jibon.io';
    $headerX['Reply-To'] = $web_mail;
    $headerX['X-Mailer'] = 'PHP/'.phpversion();
    $headerX['From'] = "$website_title <$web_mail>";

    $header = $headerX;
    $mail_body = '
    <body style="margin: 0; padding: 0;">
        <table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing: border-box;font-size: 14px;width: 100%;background: #f6f6f6;margin: 0;padding: 0;user-select: none;">
            <tbody>
                <tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing: border-box;font-size: 14px;margin: 0;padding: 0;">
                    <td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing: border-box;font-size: 14px;vertical-align: top;display: block!important;max-width: 600px!important;clear: both!important;margin: 0 auto;padding: 0;min-width:400px;">
                        <div style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing: border-box;max-width: 600px;display: block;margin: 0 auto;padding: 20px;padding-top: 50px">
                            <table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing: border-box;font-size: 12px;border-radius: 3px;background: #fff;margin: 0;padding: 0;border: 1px solid #e9e9e9; width: 100%; padding: 16px;color: #8d8d8d;">
                                <tbody>
                                    <tr>
                                        <td><br></td>
                                    </tr>
                                    <tr>
                                        <td style="margin: 0 auto;display: flex;align-items: center;justify-content: space-between;">
                                            <a target="_blank" href="'.$website_url.'">
                                                <img style="width: auto;height: 70px;pointer-events: none;" src="'.$logo.'">
                                            </a>
                                            <div  style="display: flex;justify-content: center;margin-left: auto;">
                                                '.date("H:i:s A").'<br>
                                                '.date("d M, Y").'
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><br></td>
                                    </tr>
                                    <tr>
                                        <td>Hi <b>'.$fname.'</b>,</td>
                                    </tr>
                                    <tr>
                                        <td><br></td>
                                    </tr>
                                    <tr style="font-size: 14px;color:#444444;">
                                        <td>'.$message.'</td>
                                    </tr>
                                    <tr>
                                        <td><br>Please keep in mind that if this mail contain any crediatials, don\'t share these or this email with anyone. Not even with your girlfriend. Never share your email and password. Keep your privacy safe.</td>
                                    </tr>
                                    <tr>
                                        <td>Thank you for your time.</td>
                                    </tr>
                                    <tr>
                                        <td><br></td>
                                    </tr>
                                    <tr>
                                        <td>From, <br>'.$website_title.' team.</td>
                                    </tr>
                                    <tr>
                                        <td><br></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;width:100%;clear:both;color:#999;margin:0;padding:20px">
                                <table width="100%" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0;padding:0; color: #cfcfcf;">
                                    <tbody><tr style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0;padding:0">
                                        <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:12px;vertical-align:top;text-align:center;margin:0;padding:0 0 5px" align="center" valign="top">You are receiving this email to protect and verify users crediatials and personal informations.</td>
                                    </tr>
                                    <tr style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0;padding:0">
                                        <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:12px;vertical-align:top;text-align:center;margin:0;padding:0 0 5px" align="center" valign="top">
                                            © 2021-'.date('y').' All rights reserved by <a target="_blank" style="color: lightpink;" href="'.$website_url.'">'.$website_title.'</a>.'.base64_decode('UHJvZ3JhbW1lZCBieSA8YSB0YXJnZXQ9Il9ibGFuayIgc3R5bGU9ImNvbG9yOiBsaWdodHBpbms7IiBocmVmPSJodHRwczovL2luc3RhZ3JhbS5jb20vUHJvZ3JhbW1lckppYm9uIj5Qcm9ncmFtbWVySmlib248L2E+IA==').'
                                        </td>
                                    </tr>
                                </tbody></table>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
    ';
    if (@mail($to, $subject, $mail_body, $header)) {
        return $to;
    }else{
        return false;
    }
}
function rearrange_files($arr) {
    foreach($arr as $key => $all) {
        foreach($all as $i => $val) {
            $new_array[$i][$key] = $val;    
        }    
    }
        return $new_array;
}
function times($ss) {
    $result = "";
    $s = $ss%60;
    $m = floor(($ss%3600)/60);
    $h = floor(($ss%86400)/3600);
    $d = floor(($ss%((365.25/12)*86400))/86400);
    $M = floor(($ss%(((365.25/12)*86400)*12))/((365.25/12)*86400));
    $Y = floor($ss/(((365.25/12)*86400)*12));

    if ($Y > 0) {
        $result .= $Y."Year ";
    }
    if ($M > 0) {
        $result .= $M."Month ";
    }
    if ($d > 0) {
        $result .= $d."Days ";
    }
    if ($h > 0) {
        $result .= $h."h ";
    }
    if ($m > 0) {
        $result .= $m."m ";
    }/*
    if ($s > 0) {
        $result .= $s."s ";
    }*/

    return $result;
}




function removeExtraSpaces($text) {
    return preg_replace('/\s+/', ' ', $text);
}

function removeSpaces($text) {
    return preg_replace('/\s+/', '', $text);
}
function sanitizeInput($input, string $preg = "") {
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    $input = removeExtraSpaces($input);
    $input = addslashes($input);
    switch ($preg) {
        case 'TEXT_ONLY':
            $input = (string) preg_replace('/[^a-zA-Z\s]/', '', $input);
            break;
        case 'SPACELESS_TEXT_ONLY':
            $input = (string) preg_replace('/[^a-zA-Z]/', '', $input);
            break;
        case 'NUMBER_ONLY':
            $input = (float) preg_replace('/[^0-9\.]/', '', $input);
            break;
        case 'TEXT_NUMBER':
            $input = (string) preg_replace('/[^a-zA-Z0-9\s]/', '', $input);
            break;
        case 'SPACELESS_TEXT_NUMBER':
            $input = (string) preg_replace('/[^a-zA-Z0-9]/', '', $input);
            break;
        default:
            # code...
            break;
    }
    return $input;
}

function sanitizeEmail($email) {
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    return $email;
}











function siteInfo($all = false){
    global $connect;
    $result = array();
    $limit = "";
    if(!$all){
        $limit = "LIMIT 1";
    }
    $query = mysqli_query($connect, "SELECT * FROM `site_info` ORDER BY `site_info`.`id` DESC $limit");
    foreach ($query as $key) {
        $result[] = $key;
    }
    if($all && count($result) > 0){
        return $result;
    }elseif(count($result) == 1){
        return $result[0];
    }else{
        return array();
    }
}


function searchUser($search){
    global $connect;
    $result = false;
    $searchEmail = sanitizeEmail($search);
    $search = sanitizeInput($search, "SPACELESS_TEXT_NUMBER");
    if($search != "" && $query = mysqli_query($connect,"SELECT * FROM users WHERE (`student_id` = '$search' OR `phone` = '$search' OR `email` = '$searchEmail' OR `username` = '$search' OR `nid_number` = '$search') LIMIT 1")){
        foreach ($query as $key) {
            $result = $key;
        }
    }
    return $result;
}


function sessions(){
    $result = array();
    global $connect;
    if($query = mysqli_query($connect, "SELECT * FROM `sessions_name` ORDER BY `id` DESC")){
        foreach ($query as $key) {
            $result[] = $key;
        }
    }
    return $result;
}

function teachers(){
    $result = array();
    global $connect;
    if($query = mysqli_query($connect, "SELECT * FROM `users` WHERE `type` LIKE 'TEACHER' ORDER BY `id` DESC")){
        foreach ($query as $key) {
            unset($key['password']);
            unset($key['nid_number']);
            $result[] = $key;
        }
    }
    return $result;
}

function subjects(){
    $result = array();
    global $connect, $departments, $sessions;
    if(isset($sessions[0]) && $csession = $sessions[0] && $query = mysqli_query($connect, "SELECT * FROM `subject_list` ORDER BY `id` DESC")){
        foreach ($query as $key) {
            foreach ($departments as $dept) {
                if($chat_list_checkup_query = mysqli_query($connect, "SELECT * FROM `chats` WHERE `dept_id` = '$dept[id]' AND `sub_id` = '$key[id]' AND `csession` = '$csession[id]'")){
                    if(mysqli_num_rows($chat_list_checkup_query) == 0){
                        mysqli_query($connect, "INSERT INTO `chats` (`dept_id`, `sub_id`, `csession`) VALUES ( '$dept[id]', '$key[id]', '$csession[id]')");
                    }
                }
            }
            $result[] = $key;
        }
    }
    return $result;
}

function notices(){
    $result = array();
    global $connect;
    if($query = mysqli_query($connect, "SELECT * FROM `notices` ORDER BY `id` DESC")){
        foreach ($query as $key) {
            $result[] = $key;
        }
    }
    return $result;
}

function section_modes(){
    $result = array();
    $result[] = "REGULAR";
    $result[] = "EVENING";
    return $result;
}

function allStatusMode(){
    $result = array();
    $result[] = "ACTIVE";
    $result[] = "INACTIVE";
    $result[] = "REMOVED";
    $result[] = "BANNED";
    return $result;
}

function seasons(){
    $result = array();
    $result[] = "WINTER";
    $result[] = "SUMMER";
    return $result;
}


function sections(){
    $result = array();
    global $connect;
    if($query = mysqli_query($connect, "SELECT * FROM `sections` ORDER BY `sections`.`id` DESC")){
        foreach ($query as $key) {
            $result[] = $key;
        }
    }
    return $result;
}


function departments(){
    $result = array();
    global $connect;
    if($query = mysqli_query($connect, "SELECT * FROM `department` ORDER BY `department`.`id` ASC")){
        foreach ($query as $key) {
            $result[] = $key;
        }
    }
    return $result;
}

function get_student_result($user_id, $result_id, $subject_id){
    $result = false;
    global $connect;
    if($query = mysqli_query($connect, "SELECT * FROM `results_student` WHERE `user_id` = '$user_id' AND `result_id` = '$result_id' AND `subject_id` = '$subject_id'")){
        foreach ($query as $key) {
            $result = $key;
        }
    }
    return $result;
}

function results_name(){
    $result = array();
    global $connect;
    if($query = mysqli_query($connect, "SELECT * FROM `results_name` ORDER BY `results_name`.`id` DESC")){
        foreach ($query as $key) {
            $result[] = $key;
        }
    }
    return $result;
}


function add_user_cookie($id){
    $id = addslashes($id);
    global $connect, $time, $ip, $user_agent;
    $expiring_time = $time+(86400*7);
    $cookies = "X-".sha1("\\".$id)."-".sha1("\\".$time);
    if(mysqli_query($connect, "INSERT INTO `users_cookies` (`cookies`, `user_id`, `creation_time`, `expiring_time`, `ip`, `agent`) VALUES ('$cookies', '$id', '$time', '$expiring_time', '$ip', '$user_agent')")){
        setcookie("user-x", $cookies, $expiring_time);
        return $cookies;
    }
    return false;
}


function check_user_cookie(){
    global $connect, $time;
    $result = 0;
    if(!isset($_COOKIE['user-x'])){
        return 0;
    }
    $cookies = addslashes($_COOKIE['user-x']);
    if($check_cookie = mysqli_query($connect, "SELECT * FROM `users_cookies` WHERE `cookies` = '$cookies' LIMIT 1")){
        foreach($check_cookie as $key){
            if($time > $key['expiring_time']){
                setcookie("user-x", "", -1);
            }else{
                $expiring_time = $time+(86400*7);
                mysqli_query($connect, "UPDATE `users_cookies` SET `expiring_time` = '$expiring_time' WHERE `users_cookies`.`id` = '$key[id]'");
                $result = $key['user_id'];
                setcookie("user-x", $cookies, $expiring_time);
            }
        }
    }
    return $result;
}

function user_info($user_id){
    global $connect;
    $result = false;
    $user_id = addslashes($user_id);
    if($query = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$user_id' LIMIT 1")){
        foreach($query as $key){
            unset($key['password']);
            $result = $key;
            break;
        }
    }
    return $result;
}