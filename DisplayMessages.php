
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

	$message = DB::query('SELECT chat.chatText, users.uName, users.profileImage FROM users INNER JOIN chat ON users.id = chat.chatUserid WHERE chat.chatGroupid = :groupid ORDER BY chatid ASC', array(':groupid' => $groupid));
	foreach ($message as &$value) {
		?>
		
		<form method="POST">
			<?php if($value['profileImage'] != NULL){
			echo '<img class="profileImage" src="data:image;base64,'.$value['profileImage'].'">';
			}else{
			echo '<img class="profileImage" src="images/account/defaultProfile.png">';
			}?>
			
			<input type="submit" class="userNameS" name="uName" value="<?php echo $value['uName'];?>">
		 	<span class="ChatMessageS"> <?php echo $value['chatText']; ?></span><br/>
		</form>
   		 
   		 <?php
	}
?>
	
	
	