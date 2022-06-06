<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
    <title>Clique</title>
    <link rel="stylesheet" href="css/searchedGroupsStyle.css">
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
    include('classes/isLoggedin.php');
    $userid = 0;
    $uName = "";

    if (LogIn::isLoggedIn()) {
      $userid = LogIn::isLoggedIn();
      $uName = DB::query('SELECT uName FROM users WHERE id = :userid', array(':userid'=>$userid))[0]['uName'];
    } else {
        die('Not logged in');
    }
  
    $followedgroups = DB::query('SELECT * FROM followedgroups WHERE userid=:userid', array(':userid'=>$userid));

    $search = DB::query('SELECT * FROM groups WHERE title LIKE "%":search"%"', array(':search' => $_POST['search']));

    if(isset($_POST['uName'])){
        $usersUName = $_POST['uName'];
        if($usersUName != $uName){
          $usersId = DB::query('SELECT id FROM users WHERE uName=:uName', array(':uName'=> $usersUName))[0]['id'];
          header('Location: /project-website/account-page.php?id='.$userid.'&usersId=' . $usersId);
      }else{
        header('Location: /project-website/profile-page.php?id='.$userid);
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
      <div class="wrapper">
        
      </div>
    </div>
  </section>

  <center><h1><?php echo $_POST['search']; ?></h1></center>

  <div class="groupContainer">
    <?php 
      foreach ($search as &$value) {
      ?> <a href="chat-page.php?groupid=<?php echo $value['groupid'];?>">
          <div class="groupTitle" >
            <h1><?php echo $value['title']; ?></h1>
            <div class="groupDescription"><p><?php echo $value['description']; ?></p></div>
          </div></a>

          <?php
      }
    ?>
  </div>
    
</body> 