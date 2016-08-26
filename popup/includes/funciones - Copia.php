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
/////////////////////////////////////////////////
/////////////////////////////////////////////////


function fn_ObtenerSEOdeidSucursal($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT strSEO FROM tblcakestore WHERE idPasteleria = %s", $identificador);
	//echo $query_ConsultaFuncion;
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['strSEO']; 
	mysql_free_result($ConsultaFuncion);
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function fn_ObtenerIddeSEOCategoria($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT idPasteleria FROM tblcakestore WHERE strSEO = '%s'", $identificador);
	//echo $query_ConsultaFuncion;
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	//echo $row_ConsultaFuncion['idPasteleria'];
	return $row_ConsultaFuncion['idPasteleria']; 
	mysql_free_result($ConsultaFuncion);
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function comprobarexistencia($idproducto, $idusuario)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT * FROM tblcarrito WHERE idUsuario = %s AND idProducto=%s AND intTransaccionEfectuada = 0", $idusuario,$idproducto);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	if ($totalRows_ConsultaFuncion >0) 
	return $row_ConsultaFuncion['intContador'];
	else
	return 0;
	mysql_free_result($ConsultaFuncion);
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function InsertarUsuarioTemporal(){
	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	
	$insertSQL = sprintf("INSERT INTO tblusuario (strNombre, strEmail, intActivo, strPassword) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString("", "text"),
                       GetSQLValueString("", "text"),
                       GetSQLValueString(1, "int"),
                       GetSQLValueString("", "text"));
  $Result1 = mysql_query($insertSQL, $conexionproductos) or die(mysql_error());
  return mysql_insert_id();
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function ImportarCarritoTemporal($valortemporal)
{
	
	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT intContador FROM tblcarrito WHERE tblcarrito.idUsuario = %s AND tblcarrito.intTransaccionEfectuada = 0", GetSQLValueString($_SESSION['MM_Temporal'], "int"));
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	if ($totalRows_ConsultaFuncion>0){
		do{
		$updateSQL = sprintf("UPDATE tblcarrito SET idUsuario=%s WHERE intContador=%s AND intTransaccionEfectuada = 0",         $valortemporal, $row_ConsultaFuncion["intContador"]);
  mysql_select_db($database_conexionproductos, $conexionproductos);
  $Result1 = mysql_query($updateSQL, $conexionproductos) or die(mysql_error());
		
		} while ($row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion));
	}
	}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function generar_email_alta($identificador)
{
	$cadenarecuperacion = substr(md5(rand()*time()),0,30);
	$cadenarecuperacion = substr(rand()*time(),0,30);
	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$updateSQL = sprintf("UPDATE tblusuario SET strAlta=%s WHERE strEmail = %s",
                       GetSQLValueString($cadenarecuperacion, "text"),
                       GetSQLValueString($identificador, "text"));
	mysql_select_db($database_conexionproductos, $conexionproductos);
    $Result1 = mysql_query($updateSQL, $conexionproductos) or die(mysql_error());
	
	$asunto="Confirmar Alta";
	$destinatario= $identificador;
	$contenido='Has solicitado tu registro en bepickler pasteler&iacute;as en L&iacute;nea Por favor, haz click en el link siguiente para confirmar tu alta.
	 <a id="btn" href="https://www.bepickler.com/usuario-alta-confirmar.php?id='.$cadenarecuperacion.'&email='.$identificador.'">Click aqui</a>
	';
	
	$destinatario=fn_ObtenerIdentificadordeEmail($identificador);
	
	EnvioCorreoHTML($destinatario, $contenido, $asunto);
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function fn_ObtenerIdentificadordeEmail($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_DatosFuncion = sprintf("SELECT * FROM tblusuario WHERE strEmail= %s",
 	 GetSQLValueString($identificador, "text"));
	$DatosFuncion = mysql_query($query_DatosFuncion, $conexionproductos) or die(mysql_error());
	$row_DatosFuncion = mysql_fetch_assoc($DatosFuncion);
	$totalRows_DatosFuncion = mysql_num_rows($DatosFuncion);
	
	return $row_DatosFuncion["idUsuario"]; 
	mysql_free_result($DatosFuncion);
}
//***************************************************
//***************************************************

function EnvioCorreoHTML($destinatario, $contenido, $asunto)
{

	$mensaje = '<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style>
#btn:hover {
    background: #333333;
}
#btn {
    display: inline-block;
    background: #fe9c00;
    border: none;
    padding: 5px 47px;
    color: #fff;
    font-size: 16px;
    line-height: 28px;
    font-weight: 600;
    text-align: center;
    margin-top: 15px;
}
a:link {
    color: #fe9c00;
}

/* visited link */
a:visited {
    color: #fe9c00;
}

/* mouse over link */
a:hover {
    color:grey;
}

/* selected link */
a:active {
    color: #fe9c00;
}
style:{color:black;}
</style>
</head>

<body>
<table  width="100%" border="0" cellspacing="3" cellpadding="3">
  <tr bgcolor="#333333">
    <td style="text-align:center" ><img src="https://www.bepickler.com/images/logo.png" width="107" height="81" /></td>
  </tr>
  <tr>
    <td style="text-align:center" ><p>Estimado Cliente:</p>
    <p style="text-align:center" >';
	$mensaje.= $contenido;
	$mensaje.='</p>
    </td>
  </tr>
  <tr bgcolor="#333333">
    <td style="font-family:Arial, Helvetica, sans-serif; height:50px; font-size:12px;color:white;text-align:center;">Este mensaje lo has recibido porque est&aacute;s dado de alta en Bepickler. Accede a <a href="https://www.bepickler.com">https://www.bepickler.com</a> para poder responder.</td>
  </tr>
</table>
</body>
</html>
	';

	// Para enviar correo HTML, la cabecera Content-type debe definirse
	$cabeceras  = 'MIME-Version: 1.0' . "\n";
	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
	// Cabeceras adicionales
	$cabeceras .= 'From: no-responder@bepickler.com' . "\n";
	$cabeceras .= 'Bcc: webmaster@bepickler.com' . "\n";
	$destinatario=fn_MostrarEmailUsuario($destinatario);
	
	// Enviarlo
	mail($destinatario, $asunto, $mensaje, $cabeceras);
	//echo $mensaje;
	

	
}
//***************************************************
//***************************************************
function fn_MostrarEmailUsuario($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_DatosFuncion = sprintf("SELECT tblusuario.strEmail FROM tblusuario WHERE idUsuario = %s", GetSQLValueString($identificador, "int"));
	$DatosFuncion = mysql_query($query_DatosFuncion, $conexionproductos) or die(mysql_error());
	$row_DatosFuncion = mysql_fetch_assoc($DatosFuncion);
	$totalRows_DatosFuncion = mysql_num_rows($DatosFuncion);
	
	return $row_DatosFuncion["strEmail"];
	mysql_free_result($DatosFuncion);
}
//***************************************************
//***************************************************
function MostrarCarritoLateral()
{
	//ASIGNAR EL USIUARIO EXISTA O NO
if ($_SESSION['MM_Temporal']=="ELEVADO")
{
	$usuariotempoactivo=$_SESSION['MM_IdUsuario'];
	$link="carrito_lista.php";
}
	else
	{
	$usuariotempoactivo=$_SESSION['MM_Temporal'];
	$link="prealta.php";
}
  $varUsuario_DatosCarrito = $usuariotempoactivo;

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT * FROM tblcarrito WHERE tblcarrito.idUsuario = %s AND tblcarrito.intTransaccionEfectuada = 0", GetSQLValueString($varUsuario_DatosCarrito, "int"));
	//echo $query_ConsultaFuncion;
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	if ($totalRows_ConsultaFuncion>0){
	?>
	<table width="100%" border="0" cellspacing="3" cellpadding="3">
    <?php

 do { 
 if ($row_ConsultaFuncion['idProducto']!=90000){
 echo "<tr><td>".ObtenerNombreProducto($row_ConsultaFuncion['idProducto'])."</td><td>".ObtenerPrecioProducto($row_ConsultaFuncion['idProducto'])."</td></tr>"; 
 }
 } while ($row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion)); 
?>
</table>
<a href="<?php echo $link; ?>">Comprar</a>
<?php
	}
	else
	echo "Tu carrito vacio";
	
	?>
    <?php
	mysql_free_result($ConsultaFuncion);
	}


//***************************************************
//***************************************************

function ObtenerNombreProducto($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT strNombre FROM tblcakes WHERE idProducto = %s", $identificador);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['strNombre']; 
	mysql_free_result($ConsultaFuncion);
}

//***************************************************
//***************************************************
function ObtenerPrecioProducto($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT dblPrecio FROM tblcakes WHERE idProducto = %s", $identificador);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['dblPrecio']; 
	mysql_free_result($ConsultaFuncion);
}

//***************************************************
//***************************************************
function ObtenerNombreUsuario($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT tblusuario.strNombre FROM tblusuario WHERE tblusuario.idUsuario = %s", $identificador);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['strNombre']; 
	mysql_free_result($ConsultaFuncion);
}
//***************************************************
//***************************************************
function ObtenerImpuesto($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT intIVA FROM tblcakes WHERE idProducto = %s", $identificador);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['intIVA']; 
	mysql_free_result($ConsultaFuncion);
}
//***************************************************
//***************************************************
function MostrarNombreImpuesto($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT strNombre FROM tblimpuesto WHERE idImpuesto = %s", $identificador);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['strNombre']; 
	mysql_free_result($ConsultaFuncion);
}
//***************************************************
//***************************************************
function OntenerValorImpuesto($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT dblValor FROM tblimpuesto WHERE idImpuesto = %s", $identificador);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['dblValor']; 
	mysql_free_result($ConsultaFuncion);
}
//***************************************************
//***************************************************
	function TicketUtilizado()
{
	
	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT * FROM tblcarrito WHERE tblcarrito.idUsuario = %s AND tblcarrito.intTransaccionEfectuada = 0 AND idProducto=90000", $_SESSION['MM_IdUsuario']);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	if ($totalRows_ConsultaFuncion>0) return true; else return false;
}
//***************************************************
//***************************************************

function CompruebaTicket($valorenviado)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = "SELECT * FROM tblticket WHERE strCodigo = '".$valorenviado."'";
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	if ($totalRows_ConsultaFuncion>0) return true; else return false;
	mysql_free_result($ConsultaFuncion);
}

//***************************************************
//***************************************************


function DescuentoTicket($valorenviado)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = "SELECT intValor FROM tblticket WHERE strCodigo = '".$valorenviado."'";
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion["intValor"];
	mysql_free_result($ConsultaFuncion);
}

//***************************************************
//***************************************************

function ConfirmacionPago($tipopago,$modalidad,$pasteleria,$fechaDeEntrega,$horarioDeEntrega,$observacionesPastel)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	
	//$insertSQL = sprintf("INSERT INTO tblcompra (idUsuario, fchCompra, intTipoPago, dblTotal, intPasteleria, intModo, dateFechaAgendado, intHoraDeEntrega, strObservaciones) VALUES (%s, NOW(), %s, %s, %s, %s, %s, %s, %s)",GetSQLValueString($_SESSION['MM_IdUsuario'], "int"),$tipopago,$_SESSION["TotalCompra"],$pasteleria,$modalidad,$fechaDeEntrega,$horarioDeEntrega,$observacionesPastel);
  $MM_IdUsuario=GetSQLValueString($_SESSION['MM_IdUsuario'], "int");
  $dblTotal=$_SESSION["TotalCompra"];
  $insertSQL="INSERT INTO tblcompra (idUsuario, fchCompra, intTipoPago, dblTotal, intPasteleria, intModo, dateFechaAgendado, intHoraDeEntrega, strObservaciones) VALUES ('$MM_IdUsuario', NOW(), '$tipopago', '$dblTotal', '$pasteleria', '$modalidad', '$fechaDeEntrega','$horarioDeEntrega', '$observacionesPastel')";
  $Result1 = mysql_query($insertSQL, $conexionproductos) or die(mysql_error());
  $ultimacompra = mysql_insert_id();
  $_SESSION["compraactivavisa"] = $ultimacompra;
  ActualizacionCarrito($ultimacompra);
  // Se movio a Carrito-completada.php--> ActualizacionStock($ultimacompra);
}

//***************************************************
//***************************************************
function ActualizacionCarrito($varcompra)
{
	
	global $database_conexionproductos, $conexionproductos;
	$updateSQL = sprintf("UPDATE tblcarrito SET intTransaccionEfectuada=%s WHERE idUsuario=%s AND intTransaccionEfectuada = 0",
                       $varcompra,$_SESSION['MM_IdUsuario']);
  mysql_select_db($database_conexionproductos, $conexionproductos);
  $Result1 = mysql_query($updateSQL, $conexionproductos) or die(mysql_error());
}

//***************************************************
//***************************************************
function ActualizacionStock($varcompra)
{
	
	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT * FROM tblcarrito WHERE intTransaccionEfectuada = %s", $varcompra);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	?>
    <?php
	do { 
	
	$updateSQL = sprintf("UPDATE tblcakes SET intStock=intStock-%s WHERE idProducto=%s", $row_ConsultaFuncion["intCantidad"],$row_ConsultaFuncion["idProducto"]);
  $Result1 = mysql_query($updateSQL, $conexionproductos) or die(mysql_error());

	} while ($row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion));
}

//***************************************************
//***************************************************
function ObtenerMailUsuario($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT tblusuario.strEmail FROM tblusuario WHERE tblusuario.idUsuario = %s", $identificador);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['strEmail']; 
	mysql_free_result($ConsultaFuncion);
}

//***************************************************
//***************************************************
function fn_ObtenerNombredeidSucursal($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT strNombre FROM tblcakestore WHERE idPasteleria = %s", $identificador);
	//echo $query_ConsultaFuncion;
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['strNombre']; 
	mysql_free_result($ConsultaFuncion);
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function fn_ObtenerDirecciondeidSucursal($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT strDireccion FROM tblcakestore WHERE idPasteleria = %s", $identificador);
	//echo $query_ConsultaFuncion;
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['strDireccion']; 
	mysql_free_result($ConsultaFuncion);
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function Mostrar_Carrito_Usuario($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT * FROM tblcarrito WHERE intTransaccionEfectuada = %s", $identificador);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	?>
    <div class="subproductos">
    <?php

	do { 
	echo ObtenerNombreProducto($row_ConsultaFuncion['idProducto']); 
	echo "<br>";
    
	} while ($row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion));
	?>
    </div>
    <?php


	mysql_free_result($ConsultaFuncion);
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
//***************************************************
//***************************************************

function TextoEstadoCompra($varestado)
{
	if ($varestado == 0) return "Pendiente";
	if ($varestado == 1) return "Pagado";
	if ($varestado == 2) return "Compra cancelada";
	
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
	function confirmar_alta_final($identificador, $control)
{
	
	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$updateSQL = sprintf("UPDATE tblusuario SET strAlta='', intActivo=1 WHERE strEmail = %s",
                       GetSQLValueString($identificador, "text"));
	mysql_select_db($database_conexionproductos, $conexionproductos);
    $Result1 = mysql_query($updateSQL, $conexionproductos) or die(mysql_error());
	
}


function encriptar($id)
{
	$id=$id*321;
	$id=$id+1845;
	$id=$id*4;
	$id=$id-55;
	return $id;
}

function desencriptar($id)
{
	$id=$id+55;
	$id=$id/4;
	$id=$id-1845;	
	$id=$id/321;
	return $id;
}


function DateToQuotedMySQLDate($Fecha) 
{ 
$Parte1 = substr($Fecha, 0, 10);
$Parte2 = substr($Fecha, 10, 18);

if ($Parte1<>""){ 
   $trozos=explode("/",$Parte1,3); 
   return $trozos[2]."-".$trozos[1]."-".$trozos[0].$Parte2; } 
else 
   {return "NULL";} 
} 

function MySQLDateToDateHORA($MySQLFecha) 
{ 
if (($MySQLFecha == "") or ($MySQLFecha == "0000-00-00") ) 
    {return "";} 
else 
    {return date("H:i",strtotime($MySQLFecha));} 
} 

function MySQLDateToDateDIA($MySQLFecha) 
{ 
if (($MySQLFecha == "") or ($MySQLFecha == "0000-00-00 00:00:00") ) 
    {return "";} 
else 
    {return date("d/m/Y",strtotime($MySQLFecha));} 
}

//***************************************************
//***************************************************
function generar_email_recuperacion($identificador)
{
	$cadenarecuperacion = substr(md5(rand()*time()),0,30);
	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$updateSQL = sprintf("UPDATE tblusuario SET strRecuperar=%s WHERE strEmail = %s",
                       GetSQLValueString($cadenarecuperacion, "text"),
                       GetSQLValueString($identificador, "text"));
	mysql_select_db($database_conexionproductos, $conexionproductos);
    $Result1 = mysql_query($updateSQL, $conexionproductos) or die(mysql_error());
	
	$asunto="Recuperacion Password";
	$destinatario= $identificador;
	$contenido='Has solicitado la recuperacion de tu password en bepickler.com Por favor, haz click en el link siguiente para regenerar tu password.
	<a id="btn" href="https://www.bepickler.com/usuario-recuperar-contrasena-paso-2.php?id='.$cadenarecuperacion.'&email='.$identificador.'">Click aqui</a>
	';
	
	$destinatario=fn_ObtenerIdentificadordeEmail($identificador);
	
	EnvioCorreoHTML($destinatario, $contenido, $asunto);
}
//***************************************************
//***************************************************
function generar_email_recuperacion_final($identificador, $control)
{
	$cadenalimpia = substr((rand()*time()),0,5);
	$nuevopassword = md5($cadenalimpia);
	
	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$updateSQL = sprintf("UPDATE tblusuario SET strRecuperar='', strPassword=%s WHERE strEmail = %s",
                       GetSQLValueString($nuevopassword, "text"),
                       GetSQLValueString($identificador, "text"));
	mysql_select_db($database_conexionproductos, $conexionproductos);
    $Result1 = mysql_query($updateSQL, $conexionproductos) or die(mysql_error());
	
	$asunto="Regeneracion Password";
	$destinatario= $identificador;
	$contenido='Has solicitado la recuperacion de tu password en nuestro sitio web de bepickler.com Tu nueva password es: '.$cadenalimpia.'<br>';
	
	$destinatario=fn_ObtenerIdentificadordeEmail($identificador);
	
	EnvioCorreoHTML($destinatario, $contenido, $asunto);
}

//***************************************************
//***************************************************

function ObtenerProductoRelacionado($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT intProductoRelacionado1 FROM tblcakes WHERE idProducto = %s", $identificador);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return  ObtenerNombreProducto($row_ConsultaFuncion['intProductoRelacionado1']); 
	mysql_free_result($ConsultaFuncion);
}

//***************************************************
//***************************************************
function ActualizacionEstadoCarrito($varcompra, $varestado)
{
	
	global $database_conexionproductos, $conexionproductos;
	$updateSQL = sprintf("UPDATE tblcompra SET intEstado=%s WHERE idCompra = %s",
                       $varestado,$varcompra);
  mysql_select_db($database_conexionproductos, $conexionproductos);
  $Result1 = mysql_query($updateSQL, $conexionproductos) or die(mysql_error());
}


//***************************************************
//***************************************************
//***************************************************
//***************************************************

function EnvioCorreoHTML3($destinatario, $contenido, $asunto)
{

	$mensaje = '
	<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style>
#btn:hover {
    background: #333333;
}
#btn {
    display: inline-block;
    background: #fe9c00;
    border: none;
    padding: 5px 47px;
    color: #fff;
    font-size: 16px;
    line-height: 28px;
    font-weight: 600;
    text-align: center;
    margin-top: 15px;
}
a:link {
    color: #fe9c00;
}

/* visited link */
a:visited {
    color: #fe9c00;
}

/* mouse over link */
a:hover {
    color:grey;
}

/* selected link */
a:active {
    color: #fe9c00;
}
style:{color:black;}
</style>
</head>

<body>
<table  width="100%" border="0" cellspacing="3" cellpadding="3">
  <tr bgcolor="#333333">
    <th colspan="4" style="text-align:center" ><img src="https://www.bepickler.com/images/logo.png" width="107" height="81" /></th>
  </tr>
  <tr>
    <td colspan="4" style="text-align:center" ><p>Estimado Cliente:</p>
    <p style="text-align:center" >';
	$mensaje.= $contenido;
	$mensaje.='</p>
    </td>
  </tr>
  
  <tr bgcolor="#333333">
    <td colspan="4" style="font-family:Arial, Helvetica, sans-serif; height:50px; font-size:12px;color:white;text-align:center;">Este mensaje lo has recibido porque est&aacute;s dado de alta en Bepickler. Accede a <a href="https://www.bepickler.com">https://www.bepickler.com</a> para poder responder.</td>
  </tr>
  <tr >
  <td colspan="4" style="font-family:Arial, Helvetica, sans-serif; height:50px; font-size:12px;color:red;text-align:center;"><h3>Verifica que tu producto se encuentre en perfectas condiciones al momento de recibirlo. No aplicará la política de garantía una vez entregado y aceptado. </h3>
</td>
  </tr>
</table>
</body>
</html>
	';

	// Para enviar correo HTML, la cabecera Content-type debe definirse
	$cabeceras  = 'MIME-Version: 1.0' . "\n";
	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
	// Cabeceras adicionales
	$cabeceras .= 'From: no-responder@bepickler.com' . "\n";
	$cabeceras .= 'Bcc: ventas@bepickler.com' . "\n";
	//$destinatario=fn_MostrarEmailUsuario($destinatario);
	
	// Enviarlo
	mail($destinatario, $asunto, $mensaje, $cabeceras);
	
}

//***************************************************
//***************************************************
//***************************************************
//***************************************************
function ProductoTicket($varcompra)
{
	
	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT * FROM tblcesta WHERE intTransaccionEfectuada = %s", $varcompra);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	//echo $totalRows_ConsultaFuncion;
	$contenidoproductos="";

   if ($totalRows_ConsultaFuncion > 0) { // Show if recordset not empty 
    do {
	$contenidoproductos.='<tr>
	 <td style="border-bottom: 1px solid #ddd;">'.$row_ConsultaFuncion['intCantidad'].'</td>
	 <td style="border-bottom: 1px solid #ddd;">'.ObtenerNombreProducto($row_ConsultaFuncion['idProducto']).'</td>
	 <td style="border-bottom: 1px solid #ddd;">'.PrecioProducto($row_ConsultaFuncion['idProducto']).'</td>
     <td style="border-bottom: 1px solid #ddd;"><'.$row_ConsultaFuncion['intCantidad'] * PrecioProducto($row_ConsultaFuncion['idProducto']).'</td>
	</tr>'; 
    }
	while ($row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion));}
	
	mysql_free_result($ConsultaFuncion);	
}
//***************************************************
//***************************************************
function PrecioProducto($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT dblPrecio FROM tblcakes WHERE idProducto = %s", $identificador);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['dblPrecio']; 
	mysql_free_result($ConsultaFuncion);
}


//***************************************************
//***************************************************
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function RevisarStock($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT * FROM tblcakes WHERE idProducto = %s", $identificador);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['intStock'];
	mysql_free_result($ConsultaFuncion);
	
}
/////////////////////////////////////////////////
/////////////////////////////////////////////////
//***************************************************
//***************************************************
//***************************************************

function ObtenerNombreCategoria($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT strNombre FROM tblcakestore WHERE idPasteleria = %s", $identificador);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['strNombre']; 
	mysql_free_result($ConsultaFuncion);
}

//***************************************************
//***************************************************
//***************************************************


function ObtenerDireccionPasteleria($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT strDireccion FROM tblcakestore WHERE idPasteleria = %s", $identificador);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['strDireccion']; 
	mysql_free_result($ConsultaFuncion);
}

//***************************************************
//***************************************************
//***************************************************

function ObtenerIntPasoPasteleria($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT intPaso FROM tblcakestore WHERE idPasteleria = %s", $identificador);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['intPaso']; 
	mysql_free_result($ConsultaFuncion);
}

//***************************************************
//***************************************************
//***************************************************
function ObtenerIntRelacionado1($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT intRelacionado1 FROM tblcakestore WHERE idPasteleria = %s", $identificador);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['intRelacionado1']; 
	mysql_free_result($ConsultaFuncion);
}

//***************************************************
//***************************************************
//***************************************************
function ObtenerIntRelacionado2($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT intRelacionado2 FROM tblcakestore WHERE idPasteleria = %s", $identificador);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['intRelacionado2']; 
	mysql_free_result($ConsultaFuncion);
}

//***************************************************
//***************************************************
//***************************************************
function ObtenerSEOIdPasteleria($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT strSEO FROM tblcakestore WHERE idPasteleria = %s", $identificador);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['strSEO']; 
	mysql_free_result($ConsultaFuncion);
}

//***************************************************
//***************************************************
//***************************************************

function ObtenerIntPasoCarrito($identificador)
{

	global $database_conexionproductos, $conexionproductos;
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_ConsultaFuncion = sprintf("SELECT intPaso FROM tblcakestore WHERE idPasteleria = %s", $identificador);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexionproductos) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['intPaso']; 
	mysql_free_result($ConsultaFuncion);
}
//***************************************************
//***************************************************
//***************************************************
function EliminarCompra($varcompra)
{
	

	global $database_conexionproductos, $conexionproductos;
	$updateSQL = sprintf("DELETE FROM tblcompra WHERE idCompra=%s",
                         GetSQLValueString($_GET["control"], "int"));
  mysql_select_db($database_conexionproductos, $conexionproductos);
  $Result1 = mysql_query($updateSQL, $conexionproductos) or die(mysql_error());
}

//***************************************************
//***************************************************
//***************************************************
function EliminarCarrito($varcompra)
{
	

	global $database_conexionproductos, $conexionproductos;
	$updateSQL = sprintf("DELETE FROM tblcarrito WHERE intTransaccionEfectuada=%s",
                         GetSQLValueString($_GET["control"], "int"));
  mysql_select_db($database_conexionproductos, $conexionproductos);
  $Result1 = mysql_query($updateSQL, $conexionproductos) or die(mysql_error());
}
//***************************************************
//***************************************************
function ActualizacionDatosComprador($varte, $varusuario)
{
	
	global $database_conexionproductos, $conexionproductos;
	$updateSQL = sprintf("UPDATE tbldatoscomprador SET intTransaccionEfectuada=%s WHERE intTransaccionEfectuada = 0 and relUsuario =%s ",
                       $varte,$varusuario);
  mysql_select_db($database_conexionproductos, $conexionproductos);
  $Result1 = mysql_query($updateSQL, $conexionproductos) or die(mysql_error());
}


//***************************************************
//***************************************************
?>
