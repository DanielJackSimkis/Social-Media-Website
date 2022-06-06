<head>
	  <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
    <title>Clique</title>
    <link rel="stylesheet" href="css/createGroupStyle.css">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Pacifico">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/component.css">
    <link rel="stylesheet" href="css/font-awesome-ie7.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script type="text/javascript">
    	function logout(){
    		$('#logout').load('logout.php');
    		window.location = 'login.php';
    	}

    </script>

	<?php
		include('classes/DB.php');
		include('classes/isLoggedIn.php');

		$userid = 0;
        $uName = "";

        if (LogIn::isLoggedIn()) {
          $userid = LogIn::isLoggedIn();
          $uName = DB::query('SELECT uName FROM users WHERE id = :userid', array(':userid'=>$userid))[0]['uName'];
        } else {
            die('Not logged in');
        }

	    $followedgroups = DB::query('SELECT * FROM followedgroups WHERE userid=:userid', array(':userid'=>$userid));

		if(isset($_POST["createGroup"])){
			$gTitle    	  =  $_POST['gTitle'];
			$gDescription =  $_POST['gDescription'];
			
			if(!DB::query('SELECT title FROM groups WHERE title=:gtitle', array(':gtitle'=>$gTitle))){
				if(strlen($gTitle) >= 3 && strlen($gTitle) <= 50){
					if(preg_match('/[a-zA-Z0-9_]+/', $gTitle)){
						DB::query('INSERT INTO groups VALUES(:pKey, 
															:gtitle,
															:gdescription)', 
															array(':pKey'         => NULL,
																':gtitle'   	  => $gTitle, 
																':gdescription'   => $gDescription));		
					}else{
						echo "Invalid Group title";
					}
				}else{
					echo "Group title either too long or too short";
				}
			}else{
				echo 'Group title already exists';
			}
		}
	?>

</head>
<body>

	<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
         <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
              <li><a href="index.php">Home</a></li>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Your Groups <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <?php foreach ($followedgroups as &$value) {
                      ?><li><a href="chat-page.php?groupid=<?php echo $value['groupid'];?>"><?php echo $value['title'];?></a></li><?php
                    }?>
                </ul>
              </li>
              <li class="active"><a href="create-group.php">Create Group</a></li>
            </ul>
            <form class="navbar-form navbar-left search-box-size" action="searchGroups.php" method="POST">
              <div class="input-group search-box-size">
                <input type="text" class="form-control search-box-size" placeholder="Search" name="search">
                <div class="input-group-btn">
                  <button class="btn btn-default search-btn-size" type="submit">
                    <i class="glyphicon glyphicon-search"></i>
                  </button>
                </div>
              </div>
            </form>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="profile-page.php"><span class="glyphicon glyphicon-user"></span> <?php echo $uName; ?></a></li>
              <li><a onclick="logout();" href="#" id="logout"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
            </ul>
        </div>
      </div>
  </nav>

  <section id="backBanner" class="backbanner">
    <div class="inner">
      <center><img src="images/logo.png" id="bannerImg"></center>
      <div class="wrapper">
        
      </div>
    </div>
  </section>

  <div class="container">

  	  <center><div id="groupHeading"><h1>Create a Group</h1></div></center>

	  <form method="POST">
		  <div class="input-group input-input-lg">
		  	<label>Title of Group</label>
			<input type="text" class="form-control" placeholder="Enter group title" name="gTitle" required>
		  </div>

		  <textarea id="groupDescription" type="textarea" placeholder="Enter description of group" name="gDescription" required></textarea>	

		  <center><button type="submit" name="createGroup" class="btn btn-success">Create Group</button></center>
	  </form>

   </div>
</body>	
	 		