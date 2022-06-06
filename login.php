<body>
	<head>
		<title>Clique</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<link rel="stylesheet" type="text/css" href="css/custom.css">
    

		<?php
			include('classes/DB.php');
			include('classes/isLoggedIn.php');
			$errorMessage = "";

			if(isset($_POST['login'])){
				$uName = $_POST['uName'];
				$pWord = $_POST['pWord'];
				
				if(DB::query('SELECT uName FROM users WHERE uName=:uName', array(':uName'=>$uName))){
					if(password_verify($pWord, DB::query('SELECT pWord FROM users WHERE uName=:uName', array(':uName'=>$uName))[0]['pWord'])){
						
						$cstrong = true;
						$token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
						
						$user_id = DB::query('SELECT id FROM users WHERE uName=:uName', array(':uName' => $uName))[0]['id'];

						DB::query('INSERT INTO login_tokens VALUES(NULL, :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));

						setcookie("CQID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, true);
						setcookie("CQID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, true);

						LogIn::isLoggedIn();

				        header('Location: /project-website/index.php');

					}else{
						$errorMessage = "Incorrect password!";
					}
				}else{
					$errorMessage = "User not registered";
				}
			}

		?>

	</head>

	
 <section id="backBanner" class="backbanner">
    <div class="inner">
      <center><img src="images/logo.png" id="bannerImg"></center>
      <div class="wrapper">	 
		 	<div class="loginBox">
		 		<h1 id="loginTitle">Login</h1>

		 		<br/>

		 		<form action="login.php" method="post">
		 			<div class="input-group input-input-lg">
		    		<input type="text" class="form-control" placeholder="Enter username..." name="uName" required>
			 		</div>

			 		<br/>

			 		<div class="input-group input-input-lg">
			 			<input type="password" class="form-control" placeholder="Enter password..." name="pWord" required>
			 		</div>

			 		<br/>

			 		<?php echo '<p id="error">' . $errorMessage . '</p>'?>

			 		<br/>

			 		<div class="input-group input-input-lg">
		        		<button type="submit" class="btn btn-default" name="login">Login</button>
			 		</div>

			 		<br/>

			 		<div class="input-group input-input-lg">
			 			<button type="button" class="btn btn-warning" onClick="location.href='create-account.php'">Create Account</button>
			 		</div>		
		 		</form>	
		 	</div>
   		</div>
      </div>
    </div>
  </section>

</body>