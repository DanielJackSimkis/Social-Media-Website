<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
  <title>Clique</title>
  <link rel="stylesheet" href="css/chat-style.css">
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

    $groupTitle = DB::query('SELECT title FROM groups WHERE groupid=:groupid', array(':groupid'=> $_GET['groupid']))[0]['title'];

    if(isset($_POST['follow'])){
      $groupTitle = DB::query('SELECT title FROM groups WHERE groupid = :groupid', array(':groupid'=>$_GET['groupid']))[0]['title'];
      DB::query('INSERT INTO followedgroups VALUES(:pKey, :userid, :groupid, :title)', array(':pKey'=> NULL, ':userid'=>$userid, ':groupid'=>$_GET['groupid'], ':title'=>$groupTitle));
      header("Refresh:0");
    }

    if(isset($_POST['unfollow'])){
      DB::query('DELETE FROM followedgroups WHERE groupid = :groupid AND userid = :userid', array(':groupid' => $_GET['groupid'], ':userid' => $userid));
      header("Refresh:0");
    }
  ?>

  <script type="text/javascript">

    function scrollDown(){
      var chat = document.getElementById('chat-box');
      chat.scrollTop = chat.scrollHeight;
    }

    $(document).ready(function(){

        $("#chatText").keyup(function(e){

            if(e.keyCode == 13){
              var chatText = $("#chatText").val();
              $.ajax({
                  
                  type:'POST',
                  url: 'insertMessage.php?groupid=<?php echo $_GET['groupid'];?>',
                  data:{chatText:chatText},
                  success:function(){
                      $("#chatMessage").load("DisplayMessages.php?groupid=<?php echo $_GET['groupid'];?>");
                      setTimeout(function(){
                        var chat = document.getElementById('chat-box');
                        chat.scrollTop = chat.scrollHeight;
                      }, 100);
                      
                      $("#chatText").val("");
                       
                  }

              });
            }
        });

        setInterval(function(){
          $("#chatMessage").load("DisplayMessages.php?groupid=<?php echo $_GET['groupid'];?>");

        }, 1500);

        $("#chatMessage").load("DisplayMessages.php?groupid=<?php echo $_GET['groupid'];?>");
        var chat = document.getElementById('chat-box');


    });
  </script>

  <script type="text/javascript">
    	function logout(){
    		$('#logout').load('logout.php');
    		window.location = 'login.php';
    	}

    </script>

</head>
<body onLoad="scrollDown()">
  <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
         <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
              <li><a href="index.php">Home</a></li>
              <li class="dropdown active">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Your Groups <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <?php foreach ($followedgroups as &$value) {
                      ?><li><a href="chat-page.php?>&groupid=<?php echo $value['groupid'];?>"><?php echo $value['title'];?></a></li><?php
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

 <section id="backBanner">
      <center><img src="images/logo.png" id="bannerImg"></center> 
      <div class="container">
        <div class="chat-box" id="chat-box" name="chat">
          <h1 id="groupTitle"><?php echo $groupTitle;?></h1>
          <?php
            if(!DB::query('SELECT * FROM followedgroups WHERE groupid = :groupid AND userid = :userid', array(':groupid' => $_GET['groupid'], ':userid'=>$userid))){
          ?>
              <form method="POST">
                <button class="btn btn-success" name="follow">Follow Group</button>
              </form>
          <?php
            }else{
          ?>
              <form method="POST">
                <button class="btn btn-warning" name="unfollow">Unfollow Group</button>
              </form>
          <?php
            }
          ?>
          
          <div id="chatMessage">
          </div>
        </div> 
        <textarea id="chatText" name="chatText" placeholder="Type message here..." required></textarea>   
      </div>
  </section>
</body>