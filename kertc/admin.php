<?php  
  session_start();
	$username = $_SESSION['username'];
  $name = $_SESSION['name'];
	$admin="ADMIN";
	if($username!=$admin || $username==NULL)
   {header("location: login.php");}

	$link = mysqli_connect("localhost", "root", "admin", "kertc");
  if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
  }
    $sql =  "SELECT * FROM `users`";
    $result = mysqli_query($link, $sql);
    $count = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="kertc.css">
	<title>
	</title>
   <div>
    <header>
      <img src="stops_logo1.png" id ="logo">
      <div id="username"><span style="color:grey;">Logged into,</span><?php echo $name ?></div></header>
  </div> 
</head>
<body id="body">
 <div id="wrap1">
	<div id="table" >
    <table id="tab">
      <tr> <th>Username</th><th>Name</th> </tr>
		<?php
		While($row = $result->fetch_assoc()){
    	
    	echo "<tr><td>".$row[username]."</td><td align=\"left\" >".$row[name]."</td></tr>";
    	}
    	?>
      </table>
    	<?php 
      if(isset($_POST['name'])&&$_POST['name']!="" &&isset($_POST['username'])&&$_POST['username']!="" && isset($_POST['password'])&&$_POST['password']!="")
      {
        $username = strtoupper($_POST['username']);
        $password = $_POST['password'];
        $password = sha1($password);
        $name=strtoupper($_POST['name']);
        $sql =  "INSERT INTO `users` VALUES('$username','$password','$name')";
        $result = mysqli_query($link, $sql);
        $count = mysqli_num_rows($result);
        unset($_POST['username']);
        header("location: admin.php");
      }
      else if(isset($_POST['dusername'])&& isset($_POST['dpassword']))
      {
        $username = strtoupper($_POST['dusername']);
        if($username!="ADMIN"){
          $sql =  "DELETE FROM `users` WHERE username='$username'";
          $result = mysqli_query($link, $sql);
          $count = mysqli_num_rows($result);
          unset($_POST['dusername']);
          header("location: admin.php");
        }
      }
    	?>
  </div>
  </div>
  <div id="wrap2">
  <div id="au" style="margin:10px;">
    <button style="margin-left:50px;margin-right:50px;" id="butau" class="butanl" name="au" onclick="au()">Add User</button>
  </div>
  <div id="du" style="margin:10px;"> 
   <button style="margin-left:50px;margin-right:50px;" id="butdu" class="butanl" name="du" onclick="du()">Delete User</button>
  </div> 	
    <div style="margin:10px;">
      <dl style="margin: 0px;" >
    <dt>
    <button  style="margin-left:50px;margin-right:50px;" id="butlo" class="butanl" name="logout" onclick="logout()">Logout</button>
      </dt>
  </dl>
    </div>
 </div>   
 <script type="text/javascript" src="kertc.js"></script>
</body>
</html>