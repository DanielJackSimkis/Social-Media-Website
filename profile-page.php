<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
    <title>Clique</title>
    <link rel="stylesheet" href="css/profileStyle.css">
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

          $uName = DB::query('SELECT uName FROM users WHERE id = :id', array(':id'=>$userid))[0]['uName'];
          $title = DB::query('SELECT title FROM users WHERE id = :id', array(':id'=>$userid))[0]['title'];
          $fName = DB::query('SELECT fName FROM users WHERE id = :id', array(':id'=>$userid))[0]['fName'];
          $lName = DB::query('SELECT sName FROM users WHERE id = :id', array(':id'=>$userid))[0]['sName'];
          $dob = DB::query('SELECT dob FROM users WHERE id = :id', array(':id'=>$userid))[0]['dob'];
          $gender = DB::query('SELECT gender FROM users WHERE id = :id', array(':id'=>$userid))[0]['gender'];
          $email = DB::query('SELECT email FROM users WHERE id = :id', array(':id'=>$userid))[0]['email'];
          $address = DB::query('SELECT address FROM users WHERE id = :id', array(':id'=>$userid))[0]['address'];
          $profileImage = DB::query('SELECT profileImage FROM users WHERE id = :id', array(':id'=>$userid))[0]['profileImage'];
          

          $followedgroups = DB::query('SELECT * FROM followedgroups WHERE userid=:userid', array(':userid'=>$userid));


        if(isset($_POST['saveUName'])){
            $newUName = $_POST['newUName'];
            if(!DB::query('SELECT uName FROM users WHERE uName=:uName', array(':uName'=>$newUName))){
              if(strlen($newUName) >= 3 && strlen($newUName) <= 50){
                if(preg_match('/[a-zA-Z0-9_]+/', $newUName)){
                    DB::query('UPDATE users SET uName = :newUName WHERE id = :id', array(':newUName'=>$newUName, ':id'=>$userid));
                    header("Refresh:0");
                }else{echo "Invalid username no special characters...";}
              }else{ echo "Invalid username must be at least 3 characters...";}
            }else{echo "Username already exists...";}
        }

        if(isset($_POST['savePWord'])){
          $newPWord = $_POST['newPWord'];
          DB::query('UPDATE users SET pWord = :newPWord WHERE id = :id', array(':newPWord'=>password_hash($newPWord,  PASSWORD_BCRYPT), ':id'=>$userid));
          header("Refresh:0");
        }

        if(isset($_POST['saveTitle'])){
          $newTitle = $_POST['newTitle'];
          DB::query('UPDATE users SET title = :newTitle WHERE id = :id', array(':newTitle'=>$newTitle, ':id'=>$userid));
          header("Refresh:0");
        }

        if(isset($_POST['saveFName'])){
          if(strlen($newFName) <= 50){
            $newFName = $_POST['newFName'];
            DB::query('UPDATE users SET fName = :newFName WHERE id = :id', array(':newFName'=>$newFName, ':id'=>$userid));
            header("Refresh:0");
          }else{echo "Name too long...";}
        }

        if(isset($_POST['saveLName'])){
          if(strlen($newLName) <= 50){
            $newLName = $_POST['newLName'];
            DB::query('UPDATE users SET sName = :newLName WHERE id = :id', array(':newLName'=>$newLName, ':id'=>$userid));
            header("Refresh:0");
          }else{echo "Name too long...";}
        }

        if(isset($_POST['saveDOB'])){
            $newDOB = $_POST['newYear'] . '/' . $_POST['newMonth'] . '/' .  $_POST['newDay'];
            DB::query('UPDATE users SET dob = :newDOB WHERE id = :id', array(':newDOB'=>$newDOB, ':id'=>$userid));
            header("Refresh:0");
        }

        if(isset($_POST['saveGender'])){
            $newGender = $_POST['newGender'];
            DB::query('UPDATE users SET gender = :newGender WHERE id = :id', array(':newGender'=>$newGender, ':id'=>$userid));
            header("Refresh:0");
        }

        if(isset($_POST['saveEmail'])){
          $newEmail = $_POST['newEmail'];
          if(filter_var($newEmail, FILTER_VALIDATE_EMAIL)){
            if(!DB::query('SELECT email FROM users WHERE email=:newEmail', array(':newEmail'=>$newEmail))){
              $newEmail = $_POST['newEmail'];
              DB::query('UPDATE users SET email = :newEmail WHERE id = :id', array(':newEmail'=>$newEmail, ':id'=>$userid));
              header("Refresh:0");
            }else{echo "Email already exists...";}
          }else{echo "Invalid email address...";}
        }

        if(isset($_POST['saveAddress'])){
          $newAddress = $_POST['address'];
          DB::query('UPDATE users SET address = :newAddress WHERE id = :id', array(':newAddress' => $newAddress, ':id' => $userid));
        }

        if(isset($_POST['addImage']) && isset($_FILES['image'])){
              $newProfileImage = addslashes($_FILES['image']['tmp_name']);
              $newProfileImage = file_get_contents($newProfileImage);
              $newProfileImage = base64_encode($newProfileImage);
              DB::query('UPDATE users SET profileImage = :newProfileImage WHERE id = :id', array(':newProfileImage'=>$newProfileImage, ':id'=>$userid));
              header("Refresh:0");
        }else{
          echo "Please select an image";
        }
	?>

</head>
<body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>

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
              <li class="active"><a href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $uName;?></a></li>
              <li><a onclick="logout();" href="#" id="logout"><span class="glyphicon glyphicon-log-in" method="post"></span> Logout</a></li>
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

    <form method="POST" enctype="multipart/form-data">
      <input id="imageURL" type="file" name="image" value="upload">
      <button id="addImage" type="submit" name="addImage" class="btn btn-success">Add Image</button>
    </form>

    <div class="uHeading"><h1>Username: </h1></div>

    <div class="uDetails"><h1><?php echo $uName; ?></h1></div>

    <button data-target="#editUNameDetailsMenu" data-toggle="collapse" class="changeDetails"><h1>Edit</h1></button>

    <div id="editUNameDetailsMenu" class="collapse"><form method="POST"><center><label>New Username: </label>
                                                       <input class="input" type="text" name="newUName" placeholder="Enter new username..." required></center>
                                                       <center><button type="submit" class="btn btn-success" name="saveUName">Save</button>
                                                       <button data-target="#editUNameDetailsMenu" data-toggle="collapse" type="button" class="btn btn-danger">Cancel</button></center>
                                                     </form>
    </div>

    <div class="uHeading"><h1>Password: </h1></div>

    <div class="uDetails"><h1>************</h1></div>

    <button data-target="#editPWordDetailsMenu" data-toggle="collapse" class="changeDetails"><h1>Edit</h1></button>

    <div id="editPWordDetailsMenu" class="collapse"><form method="POST"><center><label>New Password: </label>
                                                       <input class="input" type="password" name="newPWord" placeholder="Enter new Password..." required></center>
                                                       <center><button type="submit" class="btn btn-success" name="savePWord">Save</button>
                                                       <button data-target="#editPWordDetailsMenu" data-toggle="collapse" type="button" class="btn btn-danger">Cancel</button></center>
                                                     </form>
    </div>

    <div class="uHeading"><h1>Title: </h1></div>

    <div class="uDetails"><h1><?php  echo $title; ?></h1></div>

    <button data-target="#editTitleDetailsMenu" data-toggle="collapse" class="changeDetails"><h1>Edit</h1></button>

    <div id="editTitleDetailsMenu" class="collapse"><form method="POST"><center><label>New Title: </label>
                                                      <select class="input" name="newTitle" required>
                                                       <option value="Mr">Mr</option>
                                                       <option value="Miss">Miss</option>
                                                       <option value="Mrs">Mrs</option>
                                                       <option value="Master">Master</option>
                                                      </select></center>
                                                      <center><button type="submit" name="saveTitle" class="btn btn-success">Save</button>
                                                      <button data-target="#editTitleDetailsMenu" data-toggle="collapse" type="button" class="btn btn-danger">Cancel</button></center>
                                                    </form>
    </div>

    <div class="uHeading"><h1>First Name: </h1></div>
    
    <div class="uDetails"><h1><?php  echo $fName; ?></h1></div>

    <button data-target="#editFNameDetailsMenu" data-toggle="collapse" class="changeDetails"><h1>Edit</h1></button>

    <div id="editFNameDetailsMenu" class="collapse"><form method="POST"><center><label>New First name: </label>
                                                       <input class="input" type="text" name="newFName" placeholder="Enter new first name..." required></center> 
                                                       <center><button type="submit" name="saveFName" class="btn btn-success">Save</button>
                                                       <button data-target="#editFNameDetailsMenu" data-toggle="collapse" type="button" class="btn btn-danger">Cancel</button></center>
                                                    </form>
    </div>

    <div class="uHeading"><h1>Surname: </h1></div>

    <div class="uDetails"><h1><?php  echo $lName; ?></h1></div>

    <button data-target="#editLNameDetailsMenu" data-toggle="collapse" class="changeDetails"><h1>Edit</h1></button>

    <div id="editLNameDetailsMenu" class="collapse"><form method="POST"><center><label>New Surname: </label>
                                                       <input class="input" type="text" name="newLName" placeholder="Enter new surname..." required></center>
                                                       <center><button type="submit" name="saveLName" class="btn btn-success">Save</button>
                                                       <button data-target="#editLNameDetailsMenu" data-toggle="collapse" type="button" class="btn btn-danger">Cancel</button></center>
                                                    </form>
    </div>

    <div class="uHeading"><h1>Date of Birth: </h1></div>

    <div class="uDetails"><h1><?php echo $dob; ?></h1></div>

    <button data-target="#editDOBDetailsMenu" data-toggle="collapse" class="changeDetails"><h1>Edit</h1></button>

    <div id="editDOBDetailsMenu" class="collapse"><form method="POST"><center><label>New Date of birth: </label>
                                                  <select name="newDay" required>
                                                      <option value="" disabled selected>Day</option>
                                                      <?php for($i = 1; $i < 32; $i++){
                                                          echo "<option value=".$i.">".$i."</option>";
                                                        }?>
  
                                                    </select>
                                                    
                                                    <select name="newMonth" required>
                                                      <option disabled selected>Month</option>
                                                      <option value="01">January</option>
                                                      <option value="02">Febuary</option>
                                                      <option value="03">March</option>
                                                      <option value="04">April</option>
                                                      <option value="05">May</option>
                                                      <option value="06">June</option>
                                                      <option value="07">July</option>
                                                      <option value="08">August</option>
                                                      <option value="09">September</option>
                                                      <option value="10">October</option>
                                                      <option value="11">November</option>
                                                      <option value="12">December</option>
                                                    </select>
                                                    
                                                    <select name="newYear" required>
                                                      <option value="" disabled selected>Year</option>
                                                      <option value="2017">2017</option>
                                                      <option value="2016">2016</option>
                                                      <option value="2015">2015</option>
                                                      <option value="2014">2014</option>
                                                      <option value="2013">2013</option>
                                                      <option value="2012">2012</option>
                                                      <option value="2011">2011</option>
                                                      <option value="2010">2010</option>
                                                      <option value="2009">2009</option>
                                                      <option value="2008">2008</option>
                                                      <option value="2007">2007</option>
                                                      <option value="2006">2006</option>
                                                      <option value="2005">2005</option>
                                                      <option value="2004">2004</option>
                                                      <option value="2003">2003</option>
                                                      <option value="2002">2002</option>
                                                      <option value="2001">2001</option>
                                                      <option value="2000">2000</option>
                                                      <option value="1999">1999</option>
                                                      <option value="1998">1998</option>
                                                      <option value="1997">1997</option>
                                                      <option value="1996">1996</option>
                                                      <option value="1995">1995</option>
                                                      <option value="1994">1994</option>
                                                      <option value="1993">1993</option>
                                                      <option value="1992">1992</option>
                                                      <option value="1991">1991</option>
                                                      <option value="1990">1990</option>
                                                      <option value="1989">1989</option>
                                                      <option value="1988">1988</option>
                                                      <option value="1987">1987</option>
                                                      <option value="1986">1986</option>
                                                      <option value="1985">1985</option>
                                                      <option value="1984">1984</option>
                                                      <option value="1983">1983</option>
                                                      <option value="1982">1982</option>
                                                      <option value="1981">1981</option>
                                                      <option value="1981">1980</option>
                                                      <option value="1979">1979</option>
                                                      <option value="1978">1978</option>
                                                      <option value="1977">1977</option>
                                                      <option value="1976">1976</option>
                                                      <option value="1975">1975</option>
                                                      <option value="1974">1974</option>
                                                      <option value="1973">1973</option>
                                                      <option value="1972">1972</option>
                                                      <option value="1971">1971</option>
                                                      <option value="1981">1970</option>
                                                      <option value="1969">1969</option>
                                                      <option value="1968">1968</option>
                                                      <option value="1967">1967</option>
                                                      <option value="1966">1966</option>
                                                      <option value="1965">1965</option>
                                                      <option value="1964">1964</option>
                                                      <option value="1963">1963</option>
                                                      <option value="1962">1962</option>
                                                      <option value="1961">1961</option>
                                                      <option value="1981">1960</option>
                                                      <option value="1959">1959</option>
                                                      <option value="1958">1958</option>
                                                      <option value="1957">1957</option>
                                                      <option value="1956">1956</option>
                                                      <option value="1955">1955</option>
                                                      <option value="1954">1954</option>
                                                      <option value="1953">1953</option>
                                                      <option value="1952">1952</option>
                                                      <option value="1951">1951</option>
                                                      <option value="1981">1950</option>
                                                      <option value="1949">1949</option>
                                                      <option value="1948">1948</option>
                                                      <option value="1947">1947</option>
                                                      <option value="1946">1946</option>
                                                      <option value="1945">1945</option>
                                                      <option value="1944">1944</option>
                                                      <option value="1943">1943</option>
                                                      <option value="1942">1942</option>
                                                      <option value="1941">1941</option>
                                                      <option value="1981">1940</option>
                                                      <option value="1939">1939</option>
                                                      <option value="1938">1938</option>
                                                      <option value="1937">1937</option>
                                                      <option value="1936">1936</option>
                                                      <option value="1935">1935</option>
                                                      <option value="1934">1934</option>
                                                      <option value="1933">1933</option>
                                                      <option value="1932">1932</option>
                                                      <option value="1931">1931</option>
                                                      <option value="1981">1930</option>
                                                      <option value="1929">1929</option>
                                                      <option value="1928">1928</option>
                                                      <option value="1927">1927</option>
                                                      <option value="1926">1926</option>
                                                      <option value="1925">1925</option>
                                                      <option value="1924">1924</option>
                                                      <option value="1923">1923</option>
                                                      <option value="1922">1922</option>
                                                      <option value="1921">1921</option>
                                                      <option value="1981">1920</option>
                                                      <option value="1989">1919</option>
                                                      <option value="1988">1918</option>
                                                      <option value="1987">1917</option>
                                                      <option value="1986">1916</option>
                                                      <option value="1985">1915</option>
                                                      <option value="1984">1914</option>
                                                      <option value="1983">1913</option>
                                                      <option value="1982">1912</option>
                                                      <option value="1981">1911</option>
                                                      <option value="1981">1910</option>
                                                      <option value="1989">1909</option>
                                                      <option value="1988">1908</option>
                                                      <option value="1987">1907</option>
                                                      <option value="1986">1906</option>
                                                      <option value="1985">1905</option>
                                                      <option value="1984">1904</option>
                                                      <option value="1983">1903</option>
                                                      <option value="1982">1902</option>
                                                      <option value="1981">1901</option>
                                                      <option value="1981">1900</option>
                                                    </select></center>
                                                    <center><button type="submit" name="saveDOB" class="btn btn-success">Save</button>
                                                    <button data-target="#editDOBDetailsMenu" data-toggle="collapse" type="button" class="btn btn-danger">Cancel</button></center>
                                                  </form>
    </div>

    <div class="uHeading"><h1>Gender: </h1></div>

    <div class="uDetails"><h1><?php echo $gender; ?></h1></div>

    <button data-target="#editGenderDetailsMenu" data-toggle="collapse" class="changeDetails"><h1>Edit</h1></button>

    <div id="editGenderDetailsMenu" class="collapse"><form method="POST"><center><label>New Title: </label>
                                                      <label for="gender"><b>Male</b></label><input type="radio" name="newGender" value="Male" required></input>
                                                      <label for="gender"><b>Female</b></label><input type="radio" name="newGender" value="Female" required></input></center>
                                                      <center><button type="submit" name="saveGender" class="btn btn-success">Save</button>
                                                      <button data-target="#editGenderDetailsMenu" data-toggle="collapse" type="button" class="btn btn-danger">Cancel</button></center>
                                                     </form>
    </div>

    <div class="uHeading"><h1>Email: </h1></div>

    <div class="uDetails"><h1><?php echo $email; ?></h1></div>

    <button data-target="#editEmailDetailsMenu" data-toggle="collapse" class="changeDetails"><h1>Edit</h1></button>

    <div id="editEmailDetailsMenu" class="collapse"><form method="POST"><center><label>New Email: </label>
                                                       <input class="input" type="Email" name="newEmail" placeholder="Enter new email..." required></center>
                                                       <center><button type="submit" name="saveEmail" class="btn btn-success">Save</button>
                                                       <button data-target="#editEmailDetailsMenu" data-toggle="collapse" type="button" class="btn btn-danger">Cancel</button></center>
                                                     </form>
    </div>

    <div class="uHeading"><h1>Address: </h1></div>

    <button data-target="#editAddressDetailsMenu" data-toggle="collapse" class="changeDetails"><h1>Edit</h1></button>

    <div id="editAddressDetailsMenu" class="collapse"><form method="POST"><center><label>New Address: </label>
                                                         <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjgkWK52X13mXTR8wA7knRikBIUB1pi4g&libraries=places"></script>

                                                          <script type="text/javascript"> 
                                                            google.maps.event.addDomListener(window, 'load', initalize);
                                                            function initalize(){
                                                              var autocomplete = new google.maps.places.Autocomplete(document.getElementById('txtautocomplete'));
                                                              var location;
                                                              google.maps.event.addListener(autocomplete, 'place_changed', function(){
                                                                var place = autocomplete.getPlace();
                                                                location = place.formatted_address;
                                                                document.getElementById('lblresult').innerHTML = location;
                                                                document.getElementById('address').setAttribute('value', location)
                                                              });                                                              
                                                            };
                                                          </script>
                                                          <div class="input-group input-input-lg">
                                                            <label>Location:</label><input type="text" id="txtautocomplete" placeholder="Enter the address..."/><br/>
                                                            <label>Address: </label>
                                                            <label id="lblresult"></label>
                                                            <input type="hidden" id="address" name="address">
                                                          </div>

                                                          <center><button type="submit" name="saveAddress" class="btn btn-success">Save</button>
                                                          <button data-target="#editAddressDetailsMenu" data-toggle="collapse" type="button" class="btn btn-danger">Cancel</button></center>
                                                       </form>
    </div>

    <div class="uDetails"><h1><?php echo $address; ?></h1></div>

  </div>
</body>