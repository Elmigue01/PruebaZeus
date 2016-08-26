<?php require_once('../connections/conextion.php'); ?>
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

if ($_POST["formid"]==1)
	{
  $insertSQL = sprintf("INSERT INTO tblfrecuentes (strTexto, fchFecha) VALUES (%s, NOW())",
                       GetSQLValueString(utf8_decode($_POST['strTexto']), "text"));

  mysql_select_db($database_conexionproductos, $conexionproductos);
  $Result1 = mysql_query($insertSQL, $conexionproductos) or die(mysql_error());
  echo "1";
}
  
  
if ($_POST["formid"]==2)
	{
	  $insertSQL = sprintf("INSERT INTO tblcontacto (strNombre, strEmail, strConsulta, fchFecha) VALUES (%s,%s,%s, NOW())",
						   GetSQLValueString(utf8_decode($_POST['strNombre']), "text"),
						   GetSQLValueString(utf8_decode($_POST['strEmail']), "text"),
						   GetSQLValueString(utf8_decode($_POST['strConsulta']), "text"));
	
	  mysql_select_db($database_conexionproductos, $conexionproductos);
	  $Result1 = mysql_query($insertSQL, $conexionproductos) or die(mysql_error());
	  
	  $contenido='Nombre: '.utf8_decode($_POST['strNombre']).'<br>
	  Email: '.utf8_decode($_POST['strEmail']).'<br>
	  Consulta: '.utf8_decode($_POST['strConsulta']).'<br>';
	  $asunto='Consulta Tienda Solutronika';
	  
	  EnvioCorreoHTML(utf8_decode($_POST['strEmail']), maildestinatarioconsultas, $contenido, $asunto);
	  
	  echo "1";
	}
if ($_POST["formid"]==3)
	{
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_DatosFrecuentes = "SELECT idUsuario FROM tblusuario WHERE strEmail = '".utf8_decode($_POST['strEmail'])."'";
	$DatosFrecuentes = mysql_query($query_DatosFrecuentes, $conexionproductos) or die(mysql_error());
	$row_DatosFrecuentes = mysql_fetch_assoc($DatosFrecuentes);
	$totalRows_DatosFrecuentes = mysql_num_rows($DatosFrecuentes);
	
	if ($totalRows_DatosFrecuentes>0) echo "0";
	else echo "1";
	}
	
if ($_POST["formid"]==4)
	{
  
	  $contenido='Nombre: '.utf8_decode($_POST['strNombre']).'<br>
	  Email: '.utf8_decode($_POST['strEmail']).'<br>
	  Consulta: '.utf8_decode($_POST['strConsulta']).'<br>
	  Producto:'.utf8_decode($_POST['producto']);
	  
	  $emaildestinatario=ObtenerEmailUsuario($_POST['usuario']);
	  
	  $asunto='Consulta de intercambio';
	  
	  EnvioCorreoHTML(utf8_decode($_POST['strEmail']), $emaildestinatario, $contenido, $asunto);
	  
	  echo "1";
	}
?>