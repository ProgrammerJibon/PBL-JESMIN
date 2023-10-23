<?php
if(!isset($index)){
    header("HTTP/1.0 403");
}
?><div class="navbar-container">
    <div class="navbar">
    <div class="logo">
        <a href="/"><img src="/<?php echo $site_info['site_logo']; ?>" alt="Logo"></a>
    </div>
    <div class="nav-menus">
        <?php require("./view-nav-menus.php"); ?>
    </div>
    <div class="user-account">
        <div class="dropdown">
        <button class="dropbtn"><?php echo $user_info?$user_info['fname']:"Login/Register"; ?></button>
        <div class="dropdown-content">
            <a href="#" onclick="showPopUpUserDetails(<?php echo $user_id; ?>)">Profile</a>
            <div class="nav-menus-mobile">
                <?php require("./view-nav-menus.php"); ?>
            </div>
            <a href="/logout">Logout</a>
        </div>
        </div>
    </div>
    </div>
</div>