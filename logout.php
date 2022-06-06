<?php
	include('classes/DB.php');
    include('classes/isLoggedIn.php');
	$userid = 0;

    if (LogIn::isLoggedIn()) {
      $userid = LogIn::isLoggedIn();
    } else {
        die('Not logged in');
    }

    DB::query('DELETE FROM login_tokens WHERE user_id=:userid', array(':userid'=>$userid));
    header('Location: /project-website/login.php');
?>

 