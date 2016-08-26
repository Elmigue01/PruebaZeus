<?php require_once('connections/conextion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }
  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php 

if ((isset($_SESSION['MM_Temporal'])) || (isset($_SESSION['MM_Username']))){  ?>
<div class="cabeceracatalogo" id="carrito">CARRITO</div>
<?php MostrarCarritoLateral();
}?> 
<?php   
if ((isset($_SESSION['MM_Username'])) && ($_SESSION['MM_Username'] != ""))
  {
	 ?>
      <?php
	 echo "nombre usuario";
	  echo ObtenerNombreUsuario($_SESSION['MM_IdUsuario']);
	  ?>
       <div class="stage" id="page1"><div class="link-7"><a class="vin" href="carrito-lista.php"><span class="thin">Carrito de la Compra</span></a></div>
	<div class="link-7"><a class="vin" href="usuario-compras.php"><span class="thin">Mis Compras</span></a></div>
      <div class="link-7"><a class="vin" href="usuario-modificar.php"><span class="thin">Modificar</span></a></div>
		<div class="link-7"><a class="vin" href="usuario-cerrarsesion.php"><span class="thin">Cerrar Sesi&oacute;n</span></a></div>
        </div>
<?php
  }
  else
  {?>
    
  	<div class="cabeceracatalogo" id="access">ACCESO USUARIOS</div>
    	<div class="stage" id="page1"><div class="link-7"><a class="vin" href="acceso.php"><span class="thin">Iniciar Sesi&oacute;n</span></a></div></div>
		<div class="stage" id="page1"><div class="link-7"><a class="vin" href="usuario-alta.php"><span class="thin">Darme de Alta</span></a></div></div>  
<?php }?>