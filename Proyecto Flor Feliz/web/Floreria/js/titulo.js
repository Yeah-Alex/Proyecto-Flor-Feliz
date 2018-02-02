window.onload = redimencionarLetra;
window.onresize = redimencionarLetra;

function redimencionarLetra () {
	var ancho = window.innerWidth;
	var resultado = (192*ancho)/1600; 
	document.getElementsByTagName('h1')[0].style.fontSize = resultado+"px";

	
	if(navigator.userAgent=="Mozilla/5.0 (Windows NT 10.0; WOW64; rv:40.0) Gecko/20100101 Firefox/40.0"){
		document.getElementsByTagName('nav')[0].style.position = "absolute";}
}

