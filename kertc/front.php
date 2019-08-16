<?php
  session_start();
	$username = $_SESSION['username'];
  $name = $_SESSION['name'];
	if($username==NULL)
   {header("location: login.php");}

	
  $linkFirst = mysqli_connect("localhost", "root", "admin", "kertc");
  $link = mysqli_connect("localhost", "root", "admin", "kertc");
  if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
  }if($linkFirst === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
  }
    $sqlFirst =  "SELECT * FROM `buses`";
    $resultFirst = mysqli_query($linkFirst, $sqlFirst);
    $count = mysqli_num_rows($resultFirst);
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
<body>
	<div id="tableBuses">
		<table id="tab">
    <tr><th>Busno</th><th>Type</th><th>Src</th><th>Dest</th><th>last</th><th>Route</th><th>Depart</th><th>Arrival</th></tr>
    <form>
    <?php
    if($count >= 0){
		While($row = $resultFirst->fetch_assoc()){

    	echo "<tr><td>".$row[busno]."</td>";
      echo     "<td align=\"left\">".$row[type]."</td>";
      echo     "<td>".$row[src]."</td>";
      echo     "<td>".$row[dest]."</td>";
      echo     "<td>".$row[last]."</td>";
      echo     "<td>".$row[route]."</td>";
      echo     "<td>".$row[dtime]."</td>";
      echo     "<td>".$row[atime]."</td></tr>";
      }
    }
    	?>
    </form>
      </table>
  </div>
      <div id="buttonsForNav">
        <button class="navButton" onclick="hideShow('tableRoutes')">Show Routes</button>
        <button class="navButton" onclick="hideShow('editRoutes')">Edit Routes</button>
        <button class="navButton" onclick="hideShow('editBuses')">Edit Buses</button>
        <button class="navButton" onclick="hideShow('updateLastStop')">Update Last Stop</button>
      </div>

    <div id="updateLastStop" style="display: none;justify-content: center!important;">
      <?php
      if(isset($_POST['bno'])&&$_POST['bno']!=""&&isset($_POST['ltime'])&&$_POST['ltime']!="")
      {
         $bno=$_POST['bno'];
         $ltime=$_POST['ltime'];
         $sql =  "UPDATE `buses` SET last='$username' WHERE busno='$bno'";
         
         $result = mysqli_query($link, $sql);
         $result = mysqli_query($link,"UPDATE `buses` SET ltime='$ltime' WHERE busno='$bno'" );
         $_POST['bno']="";  
         
         

       }
      ?>   
      
      <form method="POST">
        <div style=" display: block;">
        <input id="bno" type="text" name="bno">
        <input id="ltime" type="text" name="ltime">
        <input id="bt" type="submit" name="update" value="Update">
        </div>
      </form>
      
    </div>
    <div id="tableRoutes" style="display: none;">
      <table>
      <?php
        $sql =  "SELECT * FROM `route`";
        $result = mysqli_query($link, $sql);
        $count = mysqli_num_rows($result);
        While($row = $result->fetch_assoc()){
          $rou=$row[routeno];
          echo "<tr id=\"rout\"><td align=\"center\" style=\"width:30px;\" > ".$rou." </td>";
          echo  "<td style=\"min-width:unset;\" > ";
          While($row[current]!="ADMIN"){
            if($row[current] == $username){
              echo "<span style=\"color: #ff4646;\">".$row[current]."</span>,";
            }
            else{
             echo  $row[current].",";
            }
            $row = $result->fetch_assoc(); 
          }
          echo  "</td></tr>";
        }
      ?>
      </table>
    </div>
    <div id="editRoutes" style="display: none;justify-content: center!important;">
      <div id="addRoute">
        <?php
          if(isset($_POST['routeno'])&&$_POST['routeno']!="")
          {
            $linkroute = mysqli_connect("localhost", "root", "admin", "kertc");
               if($linkroute === false){
               die("ERROR: Could not connect. " . mysqli_connect_error());
            }$linkstop = mysqli_connect("localhost", "root", "admin", "kertc");
               if($linkstop === false){
               die("ERROR: Could not connect. " . mysqli_connect_error());
            }
            $rno =$_POST['routeno'];
            $routeno = intval($rno);
            $name = " ";
            $durtime="0";
            $i=intval("0");
            foreach ($_POST['stop'] as $key => $value)
            {

              $stop=strtoupper($value);
              $rid=$stop.$rno;
              $resultName=mysqli_query($linkstop,"SELECT * from `users` WHERE username='$stop'");
              $rowName=$resultName->fetch_assoc();
              $name=strtolower($rowName[name]);
              $name=ucfirst($name);
              $durtime=$_POST['durtime'][$i];
              if($durtime==""){$durtime="0";}
              $i=$i+intval("1");

              $sqlRoute ="INSERT INTO `route` VALUES('$routeno','$stop','$rid','$name','$durtime')";
              $resultRoute = mysqli_query($linkroute, $sqlRoute);
            }
              $adminname="ADMIN".$routeno;
              mysqli_query($linkroute,"INSERT INTO `route` VALUES('$routeno',\"ADMIN\",'$adminname',\"ADMIN\",\"0\")");
            $_POST['routeno']="";
            
          }
           
        ?>
        <div id="routeAdd" class="form-control" >
        <form method="POST">
        <dl style="margin-top: 0px;" >
        <dt class="name">Route no</dt>
        <dt>
        <input id="routeno" class="inp" type="text" placeholder="Enter Routeno" name="routeno">
        </dt>
        </dl>
        <dl style="margin-top: 0px;" >
        <dt class="name">Enter Stops</dt>
        <dt>  
        <dl id="addHere" style="margin: 0px;display: flex;flex-wrap: wrap;">
        <input type="text" class="inpStops" name="stop[]" >
        <input type="text" class="inpDurtime" name="durtime[]" >
        <input type="text" class="inpStops" name="stop[]" >
        <button type="button" class="inpStops" onclick="addStopField()">+</button>
        <button type="button" class="inpStops" onclick="removeStopField()">-</button>
        </dl>
        </dt>
        </dl>
        <dl style="margin-top: 0px;" >
        <dt>
        <button class="but" type="submit" name="addRoute">Add Route</button>
        </dt>
        </dl>
        </form>
        </div>
      </div>
      <div id="deleteRoute">
        <?php
         if(isset($_POST['routenoD'])&&$_POST['routenoD']!="")
         {           $linkroute = mysqli_connect("localhost", "root", "admin", "kertc");
          if($linkroute === false){
          die("ERROR: Could not connect. " . mysqli_connect_error());
          }
           $routenoD = $_POST['routenoD'];
           $sqlRouteD =  "DELETE FROM `route` WHERE routeno='$routenoD'";
           $resultRouteD = mysqli_query($linkroute, $sqlRouteD);
           $_POST['routenoD']="";

         }
        ?>
        <div id="routeDelete" class="form-control" >
        <form method="POST">
        <dl style="margin-top: 0px;" >
        <dt class="name" >Route no</dt>
        <dt>
        <input id="routenoD" class="inp" type="text" placeholder="Enter Routeno To Delete" name="routenoD" >
        </dt>
        </dl>
        <dl style="margin-top: 0px;" >
        <dt>
        <button class="but" type="submit" name="deleteRoute">Delete Route</button>
        </dt>
        </dl>
        </form>
        </div>
      </div>
    </div>
    <div id="editBuses" style="display: none;justify-content: center!important;">
     <div id="deleteBus">
      <?php
        if(isset($_POST['busnoD'])&&$_POST['busnoD']!="")
        {
           $busnoD = $_POST['busnoD'];
          $sql =  "DELETE FROM `buses` WHERE busno='$busnoD'";
          $result = mysqli_query($link, $sql);
          $count = mysqli_num_rows($result);
          $_POST['busnoD']="";
  
          

        }
      ?>

      <div id="busDelete" class="form-control" >
      <form method="POST">
      <dl style="margin-top: 0px;" >
      <dt class="name" >Bus no</dt>
      <dt>
      <input id="busnoD" class="inp" type="text" placeholder="Enter busno To Delete" name="busnoD" >
      </dt>
      </dl>
      <dl style="margin-top: 0px;" >
      <dt>
      <button class="but" type="submit" name="deleteBus">Delete Bus</button>
      </dt>
      </dl>
      </form>
      </div>
     </div>
     <div id="addBus">
      <?php
        if(isset($_POST['busnoA'])&&isset($_POST['type'])&&$_POST['busnoA']!=""&& isset($_POST['dest'])&&$_POST['dest']!=""&& isset($_POST['route'])&&$_POST['route']!=""&& isset($_POST['dtime'])&&$_POST['dtime']!=""&& isset($_POST['atime'])&&$_POST['atime']!="")
        {
          $busnoA = $_POST['busnoA'];
          $src = strtoupper($username);
          $dest = strtoupper($_POST['dest']);
          $last = $src;
          $type = $_POST['type'];
          $route = $_POST['route'];
          $route = intval($route);
          $dtime = $_POST['dtime'];
          $atime = $_POST['atime'];
          $sql =  "INSERT INTO `buses` VALUES('$busnoA','$src','$dest','$last','$type','$route','$dtime','$atime','$dtime')";
          $result = mysqli_query($link, $sql);
          $count = mysqli_num_rows($result);
          $_POST['busnoA']="";
  
          


        }
      ?>
      <div id="busAdd" class="form-control" >
      <form method="POST">
  	  <dl style="margin-top: 0px;" >
  		<dt class="name" >Bus no</dt>
	    <dt>
	    <input id="busnoA" class="inp" type="text" placeholder="Enter busno" name="busnoA" >
	    </dt>
	    </dl>
      <dl style="margin-top: 0px;" >
      <dt class="name">Destination</dt>
      <dt>
      <input id="dest" class="inp" type="text" placeholder="To" name="dest">
      </dt>
      </dl>
      <dl style="margin-top: 0px;" >
      <dt class="name">Route no</dt>
      <dt>
      <input id="route" class="inp" type="text" placeholder="By Which Route" name="route" onmouseover="show('popup3')" onmouseout="hide('popup3')">
      <div id="popup3" class="popup" style="display: none;">Check Routes in Show Routes</div>
      </dt>
      </dl>
      <dl style="margin-top: 0px;" >
      <dt class="name">Time of Departure</dt>
      <dt>
      <input id="dtime" class="inp" type="text" placeholder="Departure Time" name="dtime" onmouseover="show('popup1')" onmouseout="hide('popup1')">
      <div id="popup1" class="popup" style="display: none;">Format:HHMM</div>
      </dt>
      </dl>
      <dl style="margin-top: 0px;" >
      <dt class="name">Time of Arrival</dt>
      <dt>
      <input id="atime" class="inp" type="text" placeholder="Expected Arrival Time" name="atime" onmouseover="show('popup2')" onmouseout="hide('popup2')">
      <div id="popup2" class="popup" style="display: none;">Format:HHMM</div>
      </dt>
      </dl>
      <dl style="margin-top: 0px;" >
      <dt class="name">Type</dt>
      <dt>
      <select class="inp" id="type" name="type">
        <option value="Super fast">Super Fast</option>
        <option value="Fast passenger">Fast Passenger</option>
        <option value="Ordinary">Ordinary</option>
      </select>
      </dt>
      </dl>
	    <dl style="margin-top: 0px;" >
		  <dt>
		  <button class="but" type="submit" name="addbus">Add Bus</button>
      </dt>
	    </dl>
      </form>
      </div>
     </div>
    </div>

<div id="wrap2">
    <div>
      <dl style="margin: 0px;" >
    <dt>
    <button id="butlo" class="butanl" name="logout" onclick="logout()">Logout</button>
      </dt>
  </dl>
    </div>
</div>
<script type="text/javascript" src="kertcFront.js">
    </script>
    <?php
    $link.close();
    $linkFirst.close();
    ?>
</body>
</html>
