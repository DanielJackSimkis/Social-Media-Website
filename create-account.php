<!DOCTYPE html>
<html>
<head>
	<title>Clique</title>
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Pacifico">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/component.css">
    <link rel="stylesheet" href="css/font-awesome-ie7.css">
	<link rel="stylesheet" href="css/custom-create-account.css">
	<script href="js/bootstrap.min.js"></script>
	<script type="text/javascript" href="js/jquery.js"></script>

	<?php
		include('classes/DB.php');

		if(isset($_POST["createbtn"])){
			$title    =  $_POST['title'];
			$fName    =  $_POST['fName'];
			$lName    =  $_POST['lName'];
			$dob      =  $_POST['year'] . '/' . $_POST['month'] . '/' .  $_POST['day'];
			$gender   =  $_POST['gender'];
			$uName    =  $_POST['uName'];
			$pWord    =  $_POST['pWord'];
			$email    =  $_POST['email'];
			$address  =  $_POST['address'];

			if(!DB::query('SELECT uName FROM users WHERE uName=:uName', array(':uName'=>$uName))){
				if(strlen($uName) >= 3 && strlen($uName) <= 50){
					if(preg_match('/[a-zA-Z0-9_]+/', $uName)){
						if(strlen($pWord) >= 6  && strlen($pWord) <= 60){
							if(filter_var($email, FILTER_VALIDATE_EMAIL)){
								if(!DB::query('SELECT email FROM users WHERE email=:email', array(':email'=>$email))){
									DB::query('INSERT INTO users VALUES(:pKey, 
																		:title,
																		:fName, 
																		:sName, 
																		:dob, 
																		:gender, 
																		:uName, 
																		:pWord, 
																		:email,
																		:address,
																		:profileImage)', 
																		array(':pKey'  => NULL,
																			':title'   => $title, 
																			':fName'   => $fName, 
																			':sName'   => $lName, 
																			':dob'     => $dob, 
																			':gender'  => $gender, 
																			':uName'   => $uName, 
																			':pWord'   => password_hash($pWord,  PASSWORD_BCRYPT), 
																			':email'   => $email,
																			':address'=> $address,
																			':profileImage' => NULL));
								}else{
									echo "Email already in use";
								}									
							}else{
								echo "Invalid email address";
							}	
						}else{
							echo "Invalid password";
						}
						
					}else{
						echo "Invalid username";
					}
				}else{
					echo "Invlaid username";
				}
			}else{
				echo 'User already exists';
			}
		}
	?>

</head>

<body>	
	<section id="backBanner" class="backbanner">
    	<div class="inner">
      		<center><img src="images/logo.png" id="bannerImg"></center>
      		<div class="wrapper"></div>
    	</div>
		<div class="create-account-box">

			<form method='POST'>		

		 		<div class="input-group input-input-lg">

		 			<center><h1 id="loginTitle">Create Account</h1></center>

					<br/>

		    		<input type="text" class="form-control" placeholder="Enter username..." name="uName" required>
		 		</div>

		 		<br/>

		 		<div class="input-group input-input-lg">
		 			<input type="password" class="form-control" placeholder="Enter password..." name="pWord" required>
		 		</div>

		 		<br/>

		 		<div class="input-group input-input-lg">
		 			<input type="Email" class="form-control" placeholder="Enter email address..." name="email" required>
		 		</div>

		 		<br/>

		 		<div class="input-group input-input-lg">
					<label><b>Enter your title: </b></label> 
					<select name="title" required>
					  <option value="" disabled selected>Title</option>
					  <option value="Mr">Mr</option>
					  <option value="Miss">Miss</option>
					  <option value="Mrs">Mrs</option>
					  <option value="Master">Master</option>
					</select>
				</div>

				<br/>

				<div class="input-group input-input-lg">
					<input type="text" class="form-control" placeholder="Enter first name..." name="fName" required>
				</div>

				<br/>

				<div class="input-group input-input-lg">
					<input type="text" class="form-control" placeholder="Enter last name..." name="lName" required>
				</div>

				<br/>

				<div class="input-group input-input-lg">
					<label><b>Enter date of birth: </b></label> 
			 		<select name="day" required>
			 				  <option value="" disabled selected>Day</option>
							  <option value="1">1</option>
							  <option value="2">2</option>
							  <option value="3">3</option>
							  <option value="4">4</option>
							  <option value="5">5</option>
							  <option value="6">6</option>
							  <option value="7">7</option>
							  <option value="8">8</option>
							  <option value="9">9</option>
							  <option value="10">10</option>
							  <option value="11">11</option>
							  <option value="12">12</option>
							  <option value="13">13</option>
							  <option value="14">14</option>
							  <option value="15">15</option>
							  <option value="16">16</option>
							  <option value="17">17</option>
							  <option value="18">18</option>
							  <option value="19">19</option>
							  <option value="20">20</option>
							  <option value="21">21</option>
							  <option value="22">22</option>
							  <option value="23">23</option>
							  <option value="24">24</option>
							  <option value="25">25</option>
							  <option value="26">26</option>
							  <option value="27">27</option>
							  <option value="28">28</option>
							  <option value="29">29</option>
							  <option value="30">30</option>
							  <option value="31">31</option>
							</select>
							
							<select name="month" required>
							  <option value="" disabled selected>Month</option>
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
							
							<select name="year" required>
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
							</select>
						</div>

						<br/>

						<div class="input-group input-input-lg">
							<div id="genderDiv">
								<label for="gender"><b>Male</b></label><input type="radio" name="gender" value="Male" required></input>
								<label for="gender"><b>Female</b></label><input type="radio" name="gender" value="Female" required></input>
							</div>
						</div>

						<br/>

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
						
						<br/>

				 		<div class="input-group input-input-lg">
				 			<center><button type="submit" name="createbtn" class="btn btn-warning">Create Account</button>
			        		<button type="button" class="btn btn-default" onclick="location.href='login.php'">Login</button></center>
				 		</div>
		            </div>
		        </div>
	    	</form>
	    	</div>
   </section>
</body>	
</html>
	 		