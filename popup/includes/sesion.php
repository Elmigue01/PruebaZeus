<?php
//if($_REQUEST['nombre_archivo']){$nombre_archivo=$_REQUEST['nombre_archivo'];}else{$nombre_archivo='';}
?>
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
  <?php 
  /*
  if ($nombre_archivo == "pastelerias-en-san-luis-potosi"){echo "
  <li>
 <a href='javascript:void(0);'  onclick=\"crearBoira2(); cargar('espaiFlotant2'); carregaPag('espaiFlotant2','includes/mapaTiendasSanLuis.php','selD=1');\">Mapa</a>
</li>
  "
  ;}else{}
  */
  ?>
 
 <?php
 //modificado Miguel 16de03de01   
if ((isset($_SESSION['MM_Username'])) && ($_SESSION['MM_Username'] != ""))
  {
	 ?>
<li>
  <a href="javascript:void(0);">
    <span>
    <?php
  	  echo ObtenerNombreUsuario($_SESSION['MM_IdUsuario']);
  	?> 
    </span>
  </a>
  <!-- Miguel 16de03de01 -->
  <?php if(ObtenerNombreUsuario($_SESSION['MM_IdUsuario'])!="Invitado"){ ?>
  <ul>
   	<li><a href="usuario-compras.php">Mis Compras</a></li>
    <li><a href="usuario-modificar.php">Informaci&oacute;n</a></li>
  </ul>
  <?php } ?>
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
<?php
  }
  else
  {?>
  
   <li>
<a href="usuario-alta.php"><span>Crear Cuenta </span></a>
</li>
 <li>
<a href="acceso.php"><span> Iniciar Sesi&oacute;n</span></a>
</li>
	
<?php }?>

<!--=======================MIGUEL MODIFICADO EL 16-DE-01-DE-04==================================-->
 <?php
  if ((isset($_SESSION['MM_Temporal'])) && ($_SESSION['MM_Temporal'] != "")||(isset($_SESSION['MM_Username'])) && ($_SESSION['MM_Username'] != "")) {
    ?>
    <li>
      
      <!--Consultamos el numero de articulos que lleva el usuario temporal en su carrito-->
      <?php
      if ((isset($_SESSION['MM_Username'])) && ($_SESSION['MM_Username'] != ""))
      {
        $idUsuarioIdetificado=$_SESSION['MM_IdUsuario'];
        ?>
        <a href="carrito-lista.php"><i class="fa fa-cart-arrow-down fa-2x"></i>
        <?php
      }else{
        $idUsuarioIdetificado=$_SESSION['MM_Temporal'];
        ?><a href="prealta.php"><i class="fa fa-cart-arrow-down fa-2x"></i>
        <?php
      }
      $query_DatosCarritoMiguel = sprintf("SELECT * FROM tblcarrito WHERE tblcarrito.idUsuario = %s AND tblcarrito.intTransaccionEfectuada=%s", GetSQLValueString($idUsuarioIdetificado, "int"),GetSQLValueString(0, "int"));
      $DatosCarritoMiguel = mysql_query($query_DatosCarritoMiguel, $conexionproductos) or die(mysql_error());
      $totalRows_DatosCarritoMiguel = mysql_num_rows($DatosCarritoMiguel);
      if($totalRows_DatosCarritoMiguel)
      {
        $numeroDePasteles=0;
        while($row_DatosCarritoMiguel = mysql_fetch_assoc($DatosCarritoMiguel))
        {
          $numeroDePasteles=$numeroDePasteles+$row_DatosCarritoMiguel['intCantidad'];
        }
      echo $numeroDePasteles;
      }
      else{
        $numeroDePasteles=0;
        echo $numeroDePasteles;
        //echo " 0";
      }
    }else{
      ?>
      <li>
   <a href="#"><i class="fa fa-cart-arrow-down fa-2x"></i> 0</a>
</li>
<?php
    }
      ?>
      </a>
    </li>


    </ul>
          </nav>
        </div>
      </div>
    </header>
    <!--=======================MIGUEL MODIFICADO EL 16-DE-01-DE-04==================================-->
