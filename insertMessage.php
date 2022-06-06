<?php
    include('classes/DB.php');
    include('classes/isLoggedIn.php');
  
    $userid = 0;
    $groupid = $_GET['groupid'];

    if (LogIn::isLoggedIn()) {
      $userid = LogIn::isLoggedIn();
    } else {
        die('Not logged in');
    }

    DB::query('INSERT INTO chat VALUES(:chatid, 
										   :chatUserid,
										   :chatGroupid, 
										   :chatText)', 
										   array(':chatid'     => NULL,
										   		 ':chatUserid' => $userid,
										   		 ':chatGroupid' => $groupid,
										   		 ':chatText'   => $_POST['chatText']
										   	));
    ?>