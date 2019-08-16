function Durations(dur){
	var d= document.getElementById(dur).style;
	 if(d.display=="none"){
	 	d.display = 'block';
	 }
	 else{
	 	d.display = 'none';
	 }
}
function au(){
	var d = document.getElementById("du");
	d.innerHTML="<button style=\"margin-left:50px;margin-right:50px;\" id=\"butdu\" class=\"butanl\" name=\"du\" onclick=\"du()\">Delete User</button>";
	var a = document.getElementById("au");
	a.innerHTML="<div class=\"form-control\" style=\"max-height: 300px;\"><form method=\"POST\"><dl style=\"margin-top: 0px;\" ><dt class=\"name\" >Username</dt><dt><input class=\"inp\" type=\"text\" placeholder=\"Enter username\" name=\"username\"></dt> </dl><dl style=\"margin-top: 0px;\" ><dt class=\"name\" >Password</dt><dt><input class=\"inp\" type=\"password\" placeholder=\"Enter password\" name=\"password\"></dt></dl><dl style=\"margin-top: 0px;\" ><dt class=\"name\" >Name</dt><dt><input class=\"inp\" type=\"text\" placeholder=\"Enter Name\" name=\"name\"></dt></dl><dl style=\"margin-top: 0px;\" ><dt><button id=\"but\" name=\"adduser\">Add User</button></dt></dl></form></div>";
	document.getElementById("body").style.display ="flex";

}
function du(){

	var a = document.getElementById("au");
	a.innerHTML="<button style=\"margin-left:50px;margin-right:50px;\" id=\"butau\" class=\"butanl\" name=\"au\" onclick=\"au()\">Add User</button>";
	var d = document.getElementById("du");
	d.innerHTML="<div class=\"form-control\" style=\"max-height: 300px;\"><form method=\"POST\"><dl style=\"margin-top: 0px;\" ><dt class=\"name\" >Username</dt><dt><input class=\"inp\" type=\"text\" placeholder=\"Enter username\" name=\"dusername\"></dt> </dl><dl style=\"margin-top: 0px;\" ><dt class=\"name\" >Password</dt><dt><input class=\"inp\" type=\"password\" placeholder=\"Enter password\" name=\"dpassword\"></dt></dl><dl style=\"margin-top: 0px;\" ><dt><button id=\"but\" name=\"adduser\">Delete User</button></dt></dl></form></div>";
	document.getElementById("body").style.display ="flex";
}
function logout(){
        location.href="logout.php";
      }