<!-- START OF SCRIPT -->
<!-- Original:  Paola Orru (sveva99@hotmail.com) -->
<!-- Web Site:  http://zenas.org/ -->

//Inizio preload della margherita con sostituzione immagine fissa
var preload = new Image();

preload.src = "marghe1.gif";

function doGIF() {
document['fissa'].src = preload.src;
}
//  End -->

 function spera()
{ //inizio 
var amato;
var tuonome;

amato = prompt("What's the name of the person you love?","");
tuonome = prompt("What's your name?","");

var responso=new Array()

responso[1]='in this period has better things to do.'
responso[2]='is thinging about it.'
responso[3]="unfortunately he doesn't love you."
responso[4]='feels only like a big friendship with you.'
responso[5]='loves you.'


var fr=Math.floor(Math.random()*responso.length)
if (fr==0)
fr=1
//verifica che siano inseriti i campi

 
if (tuonome == null || tuonome == ""|| amato == null || amato == "")
 
alert("How can I give you response if you don't insert the names?");

else
    alert("Hi "+tuonome+",  "+amato+" "+responso[fr]);
}//fine

	document.write("<a href=\"http://zenas.org\" target=\"_blank\">Power by Zenas.org</a>");
	
<!-- end-->
