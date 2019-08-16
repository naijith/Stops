<?php
  session_start();
  $link = mysqli_connect("localhost", "root", "admin", "kertc");
  if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
  }
  if(isset($_POST['username'])&& isset($_POST['password']))
  {
    $username = strtoupper($_POST['username']);
    $password = $_POST['password'];
    $password = sha1($password);
    $sql =  "SELECT * FROM `users` WHERE username='$username' and password='$password'";
    $result = mysqli_query($link, $sql);
    $count = mysqli_num_rows($result);
    $row = $result->fetch_assoc();
    if($count == 1){
      $_SESSION['name'] = $row[name];
		  $_SESSION['username'] = $username;
		  $admin="ADMIN";
		  if($username==$admin)
           {header("Location: admin.php");}
       	  else
       	  	{header("Location: front.php");}
    }
    else{
      $fmsg="Invaild Username or Password";
    }
  }
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="kertc.css">
	<title></title>
  <div>
    <header>
      <img src="stops_logo1.png" id ="logo"></header>
  </div>
</head>
<body >
 <div id="wrap1"> 
	<div class="form-control" style="margin-top: 120px!important;position: absolute; top: 0px;">
    <form method="POST">
  	<dl style="margin-top: 0px;" >
  		<dt class="name" >Username</dt>
	    <dt>
	    <input class="inp" type="text" placeholder="Enter username" name="username">
	    </dt>	
	</dl>
	<dl style="margin-top: 0px;" >
	    <dt class="name" >Password</dt>
	    <dt>
	    <input class="inp" type="password" placeholder="Enter password" name="password">
	    </dt>
	</dl>
	<dl style="margin-top: 0px;" >
		<dt>
		<input id="loginButton" class="navButton" type="submit" name="login" value="Log in">
    	</dt>
	</dl>
    </form>
    </div>
 </div>
 <div id="wrap2" style="display: flex;flex-wrap: wrap;">
    <div id="fp" class="form-control">
    	<a id="link" href="">Forgot password?</a>
    </div> 
</div>
<script type="text/javascript" src="kertcFront.js"></script>
</body>
</html>