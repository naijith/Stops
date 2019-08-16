<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
$link = mysqli_connect("localhost", "root", "admin", "kertc");
  if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
  }
    $sql =  "SELECT * FROM `route`";
    $result = mysqli_query($link, $sql);
    $count = mysqli_num_rows($result);
    While($row = $result->fetch_assoc()){
    $name=$row[name];
    $cname=strtolower($name);
    $cname=ucfirst($cname);
		$sql1="UPDATE `route` set name = '$cname' where name='$name'";
		$result1 = mysqli_query($link, $sql1);
    	$count1 = mysqli_num_rows($result);
    	if($result1){
    		echo "ya";
    	}
      }
      echo"done";
?>
</body>
</html>