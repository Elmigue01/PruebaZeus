<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<!DOCTYPE html>
<html>
<head>
	<title>PupPp</title>
</head>
<body>
<h1>Desde la pagina</h1>
<!--<input type="button" value="Abrir ventana" onclick=" ventanaNueva()" />-->
<!--///////////////////////////////////////////////////////////////////-->
<!--///////////////////////////////////////////////////////////////////-->
<script type="text/javascript">
function cargar(dID){
	 $('#'+dID).html('<img src="images/loading.gif" alt="cargando" /> Cargando ...');
}
function ampliar(iden) {
	document.getElementById(iden).style.display = document.getElementById(iden).style.display == "block" ? "none" : "block";
}
function carregaPag(divID,ruta,parame3) {
	$('#'+divID).load(ruta, parame3);
}
function crearBoira(es) {
	ampliar('boira');
	ampliar('espaiFlotant');
}
function crearBoira2(es) {
	ampliar('boira2');
	ampliar('espaiFlotant2');
}
</script>

<header>
  <div id="stuck_container" class="stuck_container">
    <div class="container">
      <div class="brand">
        <h1 class="brand_name">
          <a href="index.php"><img class="logo" src="images/logo curvas-01.png" alt="Be Pickler" height="50%"></a>
          </br>
          <div class="pastel"><a href="index.php"></a></div>
        </h1>
    </div>
<nav class="nav" id='nav' name='nav'>
   <ul class="sf-menu" data-type="navbar">
            <!--////////////////////////////////////////////////////////////////////-->
<li>
  <a href="alta.php">Alta Pasteler&iacute;as</a>
 </li>
 <li>
  <a href="cotizadorDePedidos.php">Cotizador</a>
 </li>
 <li>
  <a href="javascript:void(0);"  onclick="crearBoira(); cargar('espaiFlotant'); carregaPag('espaiFlotant','includes/seleccion.php','selD=1');">Ciudad</a>
              <!--<a href="pastelerias-en-san-luis-potosi.php"><span>Pasteler&Iacute;as</span></a>-->
 </li>
  
  <li>
 <a href='javascript:void(0);'  onclick=\"crearBoira2(); cargar('espaiFlotant2'); carregaPag('espaiFlotant2','includes/mapaTiendasSanLuis.php','selD=1');\">Mapa</a>
</li>
  
<li>
  <a href="javascript:void(0);">
    <span>
   
    </span>
  </a>
  <!-- Miguel 16de03de01 -->
  
  <ul>
   	<li><a href="usuario-compras.php">Mis Compras</a></li>
    <li><a href="usuario-modificar.php">Informaci&oacute;n</a></li>
  </ul>
</li>
 <li>
<a href="usuario-cerrarsesion.php"><span> Cerrar Sesi&oacute;n</span></a>
</li>
<!--=======================MIGUEL MODIFICADO EL 16-DE-01-DE-04==================================-->
<!--
 <li>
<a href="carrito-lista.php"><i class="fa fa-cart-arrow-down fa-2x"></i></a>
</li>-->
<!--=======================MIGUEL MODIFICADO EL 16-DE-01-DE-04==================================-->

  
   <li>
<a href="usuario-alta.php"><span>Crear Cuenta </span></a>
</li>
 <li>
<a href="acceso.php"><span> Iniciar Sesi&oacute;n</span></a>
</li>
	
<
    <li>
      
      <!--Consultamos el numero de articulos que lleva el usuario temporal en su carrito-->
      
        <a href="carrito-lista.php"><i class="fa fa-cart-arrow-down fa-2x"></i>
        <a href="prealta.php"><i class="fa fa-cart-arrow-down fa-2x"></i>
    
      <li>
   <a href="#"><i class="fa fa-cart-arrow-down fa-2x"></i> 0</a>
</li>
      </a>
    </li>


    </ul>
          </nav>
        </div>
      </div>
    </header>
<!--///////////////////////////////////////////////////////////////////-->
<!--///////////////////////////////////////////////////////////////////-->

<script>
/*
function flotante(tipo){
	
	if (tipo==1){
	//Si hacemos clic en abrir mostramos el fondo negro y el flotante
	$('#contenedor').show();
    $('#flotante').animate({
      marginTop: "-152px"
    });
	}
	if (tipo==2){
	//Si hacemos clic en cerrar, deslizamos el flotante hacia arriba
    $('#flotante').animate({
      marginTop: "-756px"
    });
	//Una vez ocultado el flotante cerramos el fondo negro
	setTimeout(function(){
	$('#contenedor').hide();
		
	},500)
	}

}
*/
</script>
<!--
<style>
body {
	background:#CCC; font-family: 'Open Sans', sans-serif;
}
h1,h3 {
	text-align:center;
}
a {
	cursor:pointer;
}
#fondo {
	width: 100%; height: 100%; position: fixed; top: 0px; left: 0px; z-index: 990;opacity: 0.8;background:#000;
}
#flotante {
	z-index: 999; border: 8px solid #fff; margin-top: -756px; margin-left: -153px; top: 50%; left: 50%; padding: 12px; position: fixed; width: 265px; background-color: #fff; border-radius: 3px;
}
</style>

<h1>Ventana flotante animada con javascript y jquery</h1>
<h3><a onClick="flotante(1)">Abrir ventana</a></h3>

<div id="contenedor" style="display:none">

<div id="flotante"><h1>Ventana flotante</h1>
<h3><a onClick="flotante(2)">Cerrar ventana</a></h3>
</div>

<div id="fondo"></div>

</div>
-->
<!--///////////////////////////////////////////////////////////////////-->
<!--///////////////////////////////////////////////////////////////////-->
</body>
<script type="text/javascript">
/*
<!--
function ventanaNueva(){ 
	window.open('nueva.html','nuevaVentana','width=300, height=400')
}
//-->

function flotante(tipo){
	
	if (tipo==1){
	//Si hacemos clic en abrir mostramos el fondo negro y el flotante
	$('#contenedor').show();
    $('#flotante').animate({
      marginTop: "-152px"
    });
	}
	if (tipo==2){
	//Si hacemos clic en cerrar, deslizamos el flotante hacia arriba
    $('#flotante').animate({
      marginTop: "-756px"
    });
	//Una vez ocultado el flotante cerramos el fondo negro
	setTimeout(function(){
	$('#contenedor').hide();
		
	},500)
	}

}
*/
</script>
</html>