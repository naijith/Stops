<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="kertc1.css">
	<title></title>
    <header>
      <img src="stops_logo1.png" id ="logo">
      </header>
</head>
<body>
	<div id="container">
	<div id="formsearch">	
	<form>
		<button id="buts">Search</button>
	</form>
	</div>
	<div id="mainTable">
    <div class="tabSDA"> <div class="tabColumn">SERVICE</div><div class="tabColumn">DEPARTURE</div><div class="tabColumn">ARRIVAL</div></div>
<?php
 $link = mysqli_connect("localhost", "root", "admin", "kertc");
  if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
  }
    $sqlb =  "SELECT * FROM `buses`";
    $resultb = mysqli_query($link, $sqlb);
    $countb = mysqli_num_rows($resultb);

    While($rowb = $resultb->fetch_assoc()){
      $lastTime = intval($rowb[ltime]);

    	$rou=intval($rowb[route]);
    	$sqlr =  "SELECT * FROM `route` WHERE routeno=$rou";
    	$resultr = mysqli_query($link, $sqlr);
        
        While($rowr = $resultr->fetch_assoc()){
        	if($rowr[current]==$rowb[src])
        		{break;}
        }

		echo "<div id=\"tab1\" class=\"tab\"><div class=\"tabColumn\">".$rowb[src]."-".$rowb[dest]."</div><div class=\"tabColumn\">$rowb[dtime]</div><div class=\"tabColumn\">$rowb[atime]</div></div>";
		echo "<div class=\"tab\"><div class=\"tabType\">".$rowb[type]."</div>";
		echo "<div class=\"tabVia\">via</div>";
       	  While($rowr[current]!=$rowb[dest]){
       	   echo "<div class=\"tabPlace\">";	
           if($rowr[current] == $rowb[last]){
              echo "<span style=\"color: #ff4646;\">".$rowr[name]."</span>,";
            }
            else{
              echo  $rowr[name].",";
            }
           $rowr = $resultr->fetch_assoc();
           echo "</div>";
          }
          echo "<div class=\"tabPlace\">";
          echo  $rowr[name];
        echo "</div>";
        $durations = $rowb[busno]."d";
        echo "<div id=\"divbutd\"><button id=\"butd\" onclick=\"Durations('$durations')\">Details</button></div>";
        $resultd = mysqli_query($link, $sqlr);
        $rowd = $resultd->fetch_assoc();
        While($rowd = $resultd->fetch_assoc()){
        	if($rowd[current]==$rowb[src])
        		{break;}
        }
        
        echo "<div id=$durations class=\"durations\" style=\"display:none;\" ><table><tr><th align=\"left\">Stop</th><th>Depart</th></tr>";
          $time=intval($rowb[dtime]);
        While($rowd[current]!=$rowb[dest]){	
             if($time>=intval("2400")){$time=intval("0000");}
          if($rowd[current] == $rowb[last]){
            if($time != $lastTime)
              {
              $time=$lastTime; 
              }
           echo  "<tr><td><span style=\"color:#ff4646;\">".$rowd[name]."</span></td><td align=\"center\">".$time."</td></tr>";
          }
          else{
            echo  "<tr><td>".$rowd[name]."</td><td align=\"center\">".$time."</td></tr>";
          }

           $time+=intval($rowd[duration]);

           $rowd = $resultd->fetch_assoc();
          }
        echo "</table>";  
        echo "</div></div>";
		
      }
 ?>
</div>
</div>
<script type="text/javascript" src="kertc.js"></script>
</body>
</html>
