function addStopField(){
	var s = document.getElementById("addHere");
	var was = s.innerHTML;
	s.innerHTML="<input type=\"text\" class=\"inpStops\" name=\"stop[]\"><input type=\"text\" class=\"inpDurtime\" name=\"durtime[]\" >";
	s.innerHTML+=was;
}

function removeStopField(){
	var s = document.getElementById("addHere");
	s.innerHTML="<input type=\"text\" class=\"inpStops\" name=\"stop[]\"><input type=\"text\" class=\"inpDurtime\" name=\"durtime[]\" ><input type=\"text\" class=\"inpStops\" name=\"stop[]\"><button type=\"button\" class=\"inpStops\" onclick=\"addStopField()\">+</button><button type=\"button\" class=\"inpStops\" onclick=\"removeStopField()\">-</button>";
}

function hideShow(elementId){
	var d= document.getElementById(elementId).style;
	 if(d.display=="none"){
	 	d.display = 'flex';
	 }
	 else{
	 	d.display = 'none';
	 }
}

function show(elementId){
	document.getElementById(elementId).style.display="flex";
}

function hide(elementId){
	document.getElementById(elementId).style.display="none";
}

function logout(){
        location.href="logout.php";
      }