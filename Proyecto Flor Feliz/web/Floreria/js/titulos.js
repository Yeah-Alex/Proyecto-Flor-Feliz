window.onload = redimencionarTitulos;
window.onresize = redimencionarTitulos;


function redimencionarTitulos() {
	var resultado = (window.innerWidth*48)/1600;
	document.getElementsByTagName('h2')[0].style.fontSize = resultado+"px";
	 document.getElementsByTagName('h3')[0].style.fontSize = resultado+"px";
}