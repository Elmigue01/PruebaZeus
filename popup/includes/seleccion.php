<script type="text/javascript">
//cambia el estado segun el select
function cambiarEstado(estado){
		var selectEstados = document.getElementById("selectEstados");
		var selectedEstadoSeleccionado = selectEstados.options[selectEstados.selectedIndex].value;
		if(selectedEstadoSeleccionado=="24")
		{
			window.location="pastelerias-en-san-luis-potosi.php";
		}
		if(selectedEstadoSeleccionado=="12")
		{
			//window.location="pastelerias-en-guanajuato.php";
		}
		if(selectedEstadoSeleccionado=="22")
		{
			//window.location="pastelerias-en-queretaro.php";
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
				xmlhttp.open("GET","./consultas/buscarPastelerias.php?buscando="+letrasBuscando,true);
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
				xmlhttp.open("GET","./consultas/buscarPorSabores.php?buscando="+letrasBuscando,true);
				xmlhttp.send();
			}//FIN if(document.getElementById('buscarSabor').value==""){	
			
			
	}//FIN de la funcion

</script>
<?php
//MIGUEL CONSULTA DE ESTADOS



require_once('../connections/conextion.php'); 
mysql_select_db($database_conexionproductos, $conexionproductos);
$sql_Seleccionar_Estados = "SELECT * FROM tblestados ORDER BY tblestados.strNombre ASC";
$query_Seleccionar_Estados = mysql_query($sql_Seleccionar_Estados, $conexionproductos) or die(mysql_error()); $row_Seleccionar_Estados = mysql_fetch_assoc($query_Seleccionar_Estados); 

//FIN DE CONSULTA DE ESTADOS
?>
<?php //  echo $row_Seleccionar_Estados['strNombre']; ?></p>

<h2>Selecciona tu ciudad:</h2>
                <form  id="formacceso" class="formacceso" name="formacceso" method="POST">
              		<select id="selectEstados" onchange="cambiarEstado()">
                    <option value="---">---</option>
                      <?php do { ?>
                      	<option value="<?php  echo $row_Seleccionar_Estados['intZona'];?>">
						<?php echo  utf8_encode( $row_Seleccionar_Estados['strNombre'] );?></option>
          				<?php  } while ($row_Seleccionar_Estados = mysql_fetch_assoc($query_Seleccionar_Estados)); ?>
                    </select>
              </form>
