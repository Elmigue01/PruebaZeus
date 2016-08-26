<script type="text/javascript">
//cambia el estado segun el select
function cambiarEstado(estado){
		var selectEstados = document.getElementById("selectEstados");
		var selectedEstadoSeleccionado = selectEstados.options[selectEstados.selectedIndex].value;
		if(selectedEstadoSeleccionado=="24")
		{
			window.location="pastelerias-en-san-luis-potosi.php";
		}
	}
function buscarPasteleriaBD(){
		var letrasBuscando=document.getElementById('buscarPorPasteleriaInput').value;
		if(document.getElementById('buscarPorPasteleriaInput').value==""){
			//muestra todas las pastelerias y oculta el div busqueda
			document.getElementById('pasteleriasMuestrasTodasDiv').style.display='block';	
			document.getElementById('pastelesBusquedaDiv').style.display='none';	
			document.getElementById('buscarPorSaborInput').readOnly=false;
		}else{
			//Muestra el div de busqueda y oculta el div que muestra todas las pastelerias
			document.getElementById('pasteleriasBusquedaDIv').style.display='block';
			document.getElementById('pasteleriasMuestrasTodasDiv').style.display='none';
			document.getElementById('pastelesBusquedaDiv').style.display='none';
			document.getElementById('buscarPorSaborInput').readOnly=true;
			
			var xmlhttp;
				if (window.XMLHttpRequest)
				  {// para IE7+, Firefox, Chrome, Opera, Safari
				  	xmlhttp=new XMLHttpRequest();
				  }
				else
				  {// para IE6, IE5
				  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				  }
				xmlhttp.onreadystatechange=function()
				  {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
							 document.getElementById("pasteleriasBusquedaDIv").innerHTML =xmlhttp.responseText;

				    	}
				}
				xmlhttp.open("GET","consultas/buscarPastelerias.php?buscando="+letrasBuscando,true);
				xmlhttp.send();
		}
		
	}
function buscarSaboresBD(){
			var letrasBuscando=document.getElementById('buscarPorSaborInput').value;
			if(document.getElementById('buscarPorSaborInput').value==""){	
				//Muestra el div que tiene pastelerias
				document.getElementById('pastelerias').style.display='block';
				//document.getElementById('pasteles').style.display='none';
				document.getElementById('pastelesBusquedaDiv').style.display='none';
				document.getElementById('buscarPorPasteleriaInput').readOnly=false;
			}else{
				//Muestra el div de busquedas
				document.getElementById('pastelesBusquedaDiv').style.display='block';
				document.getElementById('pastelerias').style.display='none';
				document.getElementById('buscarPorPasteleriaInput').readOnly=true;
				var xmlhttp;
				if (window.XMLHttpRequest)
				  {// para IE7+, Firefox, Chrome, Opera, Safari
				  	xmlhttp=new XMLHttpRequest();
				  }
				else
				  {// para IE6, IE5
				  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				  }
				xmlhttp.onreadystatechange=function()
				  {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
							 document.getElementById("pastelesBusquedaDiv").innerHTML =xmlhttp.responseText;
				    	}
				}
				xmlhttp.open("GET","consultas/buscarPorSabores.php?buscando="+letrasBuscando,true);
				xmlhttp.send();
			}//FIN if(document.getElementById('buscarSabor').value==""){	
			
			
	}//FIN de la funcion

</script>

<?php
//MIGUEL CONSULTA DE ESTADOS

require_once('connections/conextion.php');
$sql_Seleccionar_Estados = "SELECT * FROM tblestados ORDER BY tblestados.strNombre ASC";
$query_Seleccionar_Estados = mysql_query($sql_Seleccionar_Estados, $conexionproductos) or die(mysql_error());
$row_Seleccionar_Estados = mysql_fetch_assoc($query_Seleccionar_Estados); 

//FIN DE CONSULTA DE ESTADOS
?>
 <li>

            <!--  <a href="pastelerias-en-san-luis-potosi.php"><span>Buscar</span></a> <p><?php //  echo $row_Seleccionar_Estados['strNombre']; ?></p> -->
                <form  id="formacceso" class="formacceso" name="formacceso" method="POST">
              		<select id="selectEstados" onchange="cambiarEstado()">
                    <option value="---">---</option>
                      <?php do { ?>
                      	<option value="<?php  echo $row_Seleccionar_Estados['intZona'];?>"><?php echo $row_Seleccionar_Estados['strNombre'];?></option>
          				<?php  } while ($row_Seleccionar_Estados = mysql_fetch_assoc($query_Seleccionar_Estados)); ?>
                    </select>
              </form>
              
 </li>
 <li>
 	<form  id="formacceso" class="formacceso" name="formacceso" method="POST">
    <input type="text" id="buscarPorSaborInput" name="buscarPorSaborInput" placeholder="Buscar Por Sabor" onkeyup="buscarSaboresBD()" />
    <br />
    <br />
    <input type="text" id="buscarPorPasteleriaInput" name="buscarPorPasteleriaInput" placeholder="Buscar Por Pasteleria" onkeyup="buscarPasteleriaBD()" />
    </form>
 </li>
 <li>
              <a href="pastelerias-en-san-luis-potosi.php"><span>Pastelerias</span></a>
 </li>
 <?php   
if ((isset($_SESSION['MM_Username'])) && ($_SESSION['MM_Username'] != ""))
  {
	 ?>
          <li>
<a href="usuario-compras.php"><span> <?php
	  echo ObtenerNombreUsuario($_SESSION['MM_IdUsuario']);
	  ?> </span></a>
</li>
 <li>
<a href="usuario-cerrarsesion.php"><span> Cerrar Sesi&oacute;n</span></a>
</li>
				   
<?php
  }
  else
  {?>
  
   <li>
<a href="usuario-alta.php"><span>Registrate </span></a>
</li>
 <li>
<a href="acceso.php"><span> Iniciar Sesi&oacute;n</span></a>
</li>
	
<?php }?>