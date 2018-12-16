$(document).ready(function(){
	wallpaper();
});
setInterval(wallpaper, 1200000);

function wallpaper(){
	var d = new Date();
	var n = d.getHours();
	if (n >= 6 && n <= 12){
	  document.body.className = "morning";
	}
	else if (n >= 12 && n <= 15){
	  document.body.className = "wal-alt-2";
	}
	else if (n >= 15 && n <= 18){
	  document.body.className = "afternoon";
	}
	else if (n >= 18 && n <= 20){
	  document.body.className = "evening";
	}
	else if (n >= 20 && n <= 6){
	  document.body.className = "wal-alt-1";
	}
	else{
	  document.body.className = "wal-alt-3";
	}
}