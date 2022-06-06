<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
    <title>Clique</title>
    <link rel="stylesheet" href="css/accountStyle.css">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Pacifico">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/component.css">
    <link rel="stylesheet" href="css/font-awesome-ie7.css">

    <script>  
       $(document).ready(function(){  
            $('#insert').click(function(){  
                 var image_name = $('#image').val();  
                 if(image_name == '')  
                 {  
                      alert("Please Select Image");  
                      return false;  
                 }  
                 else  
                 {  
                      var extension = $('#image').val().split('.').pop().toLowerCase();  
                      if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)  
                      {  
                           alert('Invalid Image File');  
                           $('#image').val('');  
                           return false;  
                      }  
                 }  
            });  
       });  
    </script>

    <?php 
  		    include('classes/DB.php');
          if(isset($_GET['usersId'])){
            $id = $_GET['id'];
            $usersId = $_GET['usersId'];
            $uName = DB::query('SELECT uName FROM users WHERE id = :id', array(':id'=>$usersId))[0]['uName'];
            $title = DB::query('SELECT title FROM users WHERE id = :id', array(':id'=>$usersId))[0]['title'];
            $fName = DB::query('SELECT fName FROM users WHERE id = :id', array(':id'=>$usersId))[0]['fName'];
            $lName = DB::query('SELECT sName FROM users WHERE id = :id', array(':id'=>$usersId))[0]['sName'];
            $dob = DB::query('SELECT dob FROM users WHERE id = :id', array(':id'=>$usersId))[0]['dob'];
            $gender = DB::query('SELECT gender FROM users WHERE id = :id', array(':id'=>$usersId))[0]['gender'];
            $email = DB::query('SELECT email FROM users WHERE id = :id', array(':id'=>$usersId))[0]['email'];
            $postCode = DB::query('SELECT postCode FROM users WHERE id = :id', array(':id'=>$usersId))[0]['postCode'];
            $profileImage = DB::query('SELECT profileImage FROM users WHERE id = :id', array(':id'=>$usersId))[0]['profileImage'];
          }
          

          //TODO add a followed groups variable and change allGroups variable in the link for the chat in the NAV menu

          $allGroups = DB::query('SELECT * FROM groups');
	?>

</head>
<body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>

  <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
         <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
              <li><a href="index.php?id=<?php echo $id;?>">Home</a></li>
                <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Your Groups <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <?php foreach ($allGroups as &$value) {
                      ?><li><a href="chat-page.php?id=<?php echo $id;?>&groupid=<?php echo $value['groupid'];?>"><?php echo $value['title'];?></a></li><?php
                    }?>
                </ul>
              </li>
              <li class="dropdown megamenu">
                 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Group Categpries <span class="caret"></span></a>
                  <div class="dropdown-menu">
                    <ul class="list-unstyled col-lg-3 col-sm-6" role="menu">
                      <li><h3>Start</h3></li> 
                      <li><a href="#">Action</a></li>
                      <li><a href="#">Another action</a></li>
                      <li><a href="#">Something else here</a></li>
                      <li class="divider"></li>
                      <li><a href="#">Separated link</a></li>
                      <li class="divider"></li>
                      <li><a href="#">One more link</a></li>
                    </ul>
                    <ul class="nav col-lg-3 col-sm-6" role="menu">
                      <li>
                          <div class="col-md-12">
                            <h3>Login</h3>
                            <form action="index.php" method="post" role="form" class="form-horizontal">
                                <input class="form-control" id="inputEmail1" placeholder="Email" type="email" style="margin-bottom:.5em">
                                <input class="form-control" id="inputPassword1" placeholder="Password" type="password" style="margin-bottom:.5em">
                                <div class="checkbox">
                                  <label class="small"><input type="checkbox"> remember me</label>
                                </div>
                                <hr>
                                <input class="btn btn-primary btn-block" type="submit" name="commit" value="Sign In">
                            </form>
                        </div>
                      </li>
                    </ul>
                    <ul class="col-lg-3 col-sm-6 list-unstyled" role="menu">
                      <li><h3>Options</h3></li>
                      <li><a href="#">Action</a></li>
                      <li><a href="#">Another action</a></li>
                      <li><a href="#">Something else here</a></li>
                      <li class="divider"></li>
                      <li><a href="#">Link</a></li>
                      <li><a href="#">Link</a></li>
                      <li class="divider"></li>
                      <li><a href="#" class="btn btn-primary pull-right">OK</a></li>
                      <li><p class="small text-muted">small text here</p></li>
                    </ul>
                    <ul class="list-unstyled col-lg-3 col-sm-6" role="menu">
                      <li><h3>More</h3></li> 
                      <li><a href="#">Action</a></li>
                      <li><a href="#">Another action</a></li>
                      <li><a href="#">Something else here</a></li>
                      <li class="divider"></li>
                      <li><a href="#">Separated link</a></li>
                      <li class="divider"></li>
                      <li><a href="#">One more link</a></li>
                    </ul>
                  </div>
              </li>
              <li><a href="#">Create Group</a></li>
              <li><a href="#">Contact Us</a></li>
              <li><a href="#" id="aboutID">About</a></li>
            </ul>
            <form class="navbar-form navbar-left search-box-size">
              <div class="input-group search-box-size">
                <input type="text" class="form-control search-box-size" placeholder="Search">
                <div class="input-group-btn">
                  <button class="btn btn-default search-btn-size" type="submit">
                    <i class="glyphicon glyphicon-search"></i>
                  </button>
                </div>
              </div>
            </form>
            <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-envelope"></span> Messages</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-info-sign"></span> Notifications</a></li>
              <li class="active"><a href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $uName;?></a></li>
              <li><a href="login.php"><span class="glyphicon glyphicon-log-in" method="post"></span> Logout</a></li>
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

  <br/>

  <div class="container">

    <center><div id="profileTitle"><h1>Profile Page</h1></div></center>

    <?php
      if($profileImage != NULL){
        echo '<img class="profileImage" src="data:image;base64,'.$profileImage.'">';
      }else{
        ?><img  class="profileImage" src="images/account/defaultProfile.png"><?php
      }
    ?>

    <div class="uHeading"><h1>Username: </h1></div>

    <div class="uDetails"><h1><?php echo $uName; ?></h1></div>

    <div class="uHeading"><h1>Title: </h1></div>

    <div class="uDetails"><h1><?php  echo $title; ?></h1></div>

    <div class="uHeading"><h1>First Name: </h1></div>
    
    <div class="uDetails"><h1><?php  echo $fName; ?></h1></div>

    <div class="uHeading"><h1>Surname: </h1></div>

    <div class="uDetails"><h1><?php  echo $lName; ?></h1></div>

    <div class="uHeading"><h1>Date of Birth: </h1></div>

    <div class="uDetails"><h1><?php echo $dob; ?></h1></div>

    <div class="uHeading"><h1>Gender: </h1></div>

    <div class="uDetails"><h1><?php echo $gender; ?></h1></div>

    <div class="uHeading"><h1>Email: </h1></div>

    <div class="uDetails"><h1><?php echo $email; ?></h1></div>


    <div class="uHeading"><h1>Postcode: </h1></div>

    <div class="uDetails"><h1><?php echo $postCode; ?></h1></div>

  </div>
</body>