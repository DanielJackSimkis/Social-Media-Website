<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
    <title>Clique</title>
    <link rel="stylesheet" href="css/indexStyle.css">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Pacifico">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/component.css">
    <link rel="stylesheet" href="css/font-awesome-ie7.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
   
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
        $allGroups = DB::query('SELECT * FROM groups');
    ?>

    <script type="text/javascript">
    	function logout(){
    		$('#logout').load('logout.php');
    		window.location = 'login.php';
    	}

    </script>

</head>

<body>
  <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
         <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Home</a></li>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Your Groups <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <?php foreach ($followedgroups as &$value) {
                      ?><li><a href="chat-page.php?groupid=<?php echo $value['groupid'];?>"><?php echo $value['title'];?></a></li><?php
                    }?>
                </ul>
              </li>
              <li><a href="create-group.php">Create Group</a></li>
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
      <div class="wrapper"></div>
    </div>
  </section>

  <div class="FeaturedTitle">
    <center><img src="images/pageDivider.png" id="pageDivider"></center>
  </div>
  <div class="container">
      <div class="groupContainer">
          <?php 
            for ($i = 0; $i < 6; $i++) {
            ?> <a href="chat-page.php?groupid=<?php echo $allGroups[$i]['groupid'];?>">
                <div class="groupTitle" >
                  <h1><?php echo $allGroups[$i]['title']; ?></h1>
                  <div class="groupDescription"><p><?php echo $allGroups[$i]['description']; ?></p></div>
                </div></a>

                <?php
          }
        ?>
    </div>
  </div>     
</body>