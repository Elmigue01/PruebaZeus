 <!--<link href="css/bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">-->
<script src="js/jquery.js"></script>
	<div class="row">
		<div class="grid_12 wow fadeInLeft">
	    	<!--<h3>Personalizada tu pedido</h3>-->
	    </div>
	</div>
	</br>

	    <!--<div class="grid_12 wow fadeInLeft">-->
	    <form  id="formacceso" class="formacceso" name="formacceso" method="POST">
	    	<!--<fieldset>-->
	    		<!--<legend>-->
	    	<div class="row">
	    		<div class="grid_12">
	    		<h4>Ingresa fecha de evento</h4>
	    		</div>
	    	</div>
	    	</br>
	    	<div class="row">
	    		<div class="grid_12"  id="cargandoFiltrosDiv" name="cargandoFiltrosDiv" style="display: block">
	    		<p align='center'><img src='documentos/busqueda/ajax-loader.gif'/></p>
	    		</div>
			</div>

	    	<div class="row">	
	    		<div class="grid_12" id="fieldsetTipoDePedido" name="fieldsetTipoDePedido"  style="text-align:center;display: none">
	    		<!--<label class="name" style="text-align:center;">-->
		    		<input type="date"  name="selectPedidos" id="selectPedidos" onchange="mostrarPorTipoDePedido();" />
		    	<!--</label>-->
		    	</div>
		    </div>
		    </br>
			    <div class="grid_4 wow fadeInLeft" id="fieldsetTipoEntrega" name="fieldsetTipoEntrega" style="text-align:center;display:none;height: 25px">
					<select class="form-control" id="selectEntregas" name="selectEntregas" onchange="mostrarPorTipoDeEntrega();">
					    <optgroup>
					    	<option value="---">Elige la Entrega de tu preferencia</option>
						    <option value="entregaTienda">Entrega en tienda</option>
						    <option value="entregaDomicilio">Entrega a domicilio</option>
					   	</optgroup>
					</select>
				<!--</label>-->
				</div>
		    	 <div class="grid_4 wow fadeInLeft" id="fieldsetColoniaEntrega" name="fieldsetColoniaEntrega"  style="text-align:center;display: none;height: 25px">
			    <select class="form-control" id="selectColonias" name="selectColonias" onchange="mostrarPorColonia();"><!-- onchange="filtrarBusquedaPastel();"-->
			    	<optgroup>
			    		<option value="---"></option>
			    	</optgroup>
			    </select>
			    </div>
			   	<div class="grid_4 wow fadeInLeft" id="fieldsetHoraEntrega" name="fieldsetHoraEntrega"  style="text-align:center;display: none;height: 25px;">
			    	<select class="form-control" id="selectHora" name="selectHora" style=""><!-- onchange="filtrarBusquedaPastel();"-->
			    		<optgroup>
			    			<?php 
			    				//include("consultas/consultarHorasRegistradasFiltro.php");
			    			?>
			    		</optgroup>
			    	</select>
			    </div>
			<!--</div>-->
		    	<!--</label>-->
		    <!--</fieldset>-->
	    <!--</div>-->
		</form>
	<!--</div>-->
<!--</div>-->
<script type="text/javascript">
//alert('hola');

	var rutaCarpetas
	window.onload = function () {
		//alert('entro al onload');
		if(document.getElementById("cargandoFiltrosDiv")){
			document.getElementById("cargandoFiltrosDiv").style.display="none";
		}
		if(document.getElementById("fieldsetTipoDePedido")){
			document.getElementById("fieldsetTipoDePedido").style.display="block";
		}
		FechaActual=obtenerFechaActual();

		var fechaPedido='';
		fechaPedido="<?php  if(isset($_SESSION['MM_FechaPedido'])){echo $_SESSION['MM_FechaPedido'];} ?>";
		if(fechaPedido!=''){
			document.getElementById('selectPedidos').value=fechaPedido;
		}else{
			//alert('No esta definido la fecha');
		}
		mostrarPorTipoDePedido();
	}
	
	function mostrarPorTipoDePedido(){
		//alert('entro a la funcion mostrarPorTipoDePedido');
		var selectPedidos=0;
		selectPedidos=obtenerTipoDePedido();
		<?php $phpvar    = date('H'); ?>
		horaActual  = '<?php echo $phpvar; ?>';

		//alert('hroa actual'+horaActual);
		
		if(selectPedidos=='hoy'&&horaActual>17){
			document.getElementById('fieldsetTipoEntrega').style.display='none';
				document.getElementById('fieldsetColoniaEntrega').style.display='none';
				document.getElementById('pasteleriasFiltroDIv').style.display='none';
				alert('Lo sentimos no es posible entregar tu pedido el dia de hoy, nuestro horario de servicio es de 8:00 a 17:00. Te invitamos a seleccionar otro dia para agendar');
		}else{
			//alert('antes de llamar a la funcion'+pedido);
			var selectEntregas=0;
			var valorEntregaSeleccionado=0;
			var diaDeEntregaValido='';
			if(!selectPedidos){return;}
			//alert('selectPedidos::'+selectPedidos);
			//1A vs 2E
			diaDeEntregaValido=validarDiaDeEntrega();
			//alert('diaDeEntregaValido::'+diaDeEntrega);
			if(diaDeEntregaValido=='si'){
				//alert('diaDeEntregaValido::'+diaDeEntregaValido);
				if(document.getElementById("selectEntregas")){
					//alert('entro pedidos get entregas');
					selectEntregas =document.getElementById("selectEntregas");
					//selectEntregas.style.display='block';
					document.getElementById('fieldsetTipoEntrega').style.display='block';
					document.getElementById('fieldsetColoniaEntrega').style.display='block';
					valorEntregaSeleccionado = selectEntregas.value;
				}
				//alert("valor de entrega:"+valorEntregaSeleccionado);
				//document.getElementById('fieldsetTipoDePedido').style.display='none';
				if(valorEntregaSeleccionado!="---"&& (valorEntregaSeleccionado=="entregaTienda"||valorEntregaSeleccionado=="entregaDomicilio")){
					mostrarPorTipoDeEntrega();
				}else{
					//alert("entro a filtrosPedidosActivado");
					filtrarBusquedaPastel();
				}
			}else{
				
				document.getElementById('fieldsetTipoEntrega').style.display='none';
				document.getElementById('fieldsetColoniaEntrega').style.display='none';
				document.getElementById('pasteleriasFiltroDIv').style.display='none';
				alert('Lo lamentamos este día no se entregan pedidos puedes elegir un día de Lunes a Viernes');
				return;
			}
		}
	
	}
	
	function obtenerTipoDePedido(){
		//alert('entro a la funcion obtenerTipoDePedido');
		var fechaActualFormat=0;
		var tipoDePedido='';
		var fechaElegida=document.getElementById("selectPedidos").value;

		fechaActualFormat=obtenerFechaActual();
		//alert('obtenerTipoDePedido fechaActualFormat::'+fechaActualFormat);
		//alert('entro al tipo de pedido'+document.getElementById("selectPedidos").value+' fechaActual::'+dd+'/'+mm+'/'+yyyy+'/');
		if(fechaElegida<fechaActualFormat){
			//alert('la fecha debe de ser igual o mayor a la actual: '+fechaActualFormat);
			tipoDePedido='ErrorEnFecha';
			//borramos la fecha que eliguo por no ser valida
			document.getElementById("selectPedidos").value='';
			return false;
		}
		if (fechaElegida==fechaActualFormat) {
			//alert('hoy');
			tipoDePedido='hoy';
		}
		if (fechaElegida>fechaActualFormat) {
			tipoDePedido='sobrePedido';
			//alert(' sobrePedido');
		}
		return tipoDePedido;
	}
	
	function obtenerFechaActual(){
		//alert('entro a la funcion obtenerFechaActual');
		var fechaActualFormat='';
			<?php $phpvar    = date('Y-m-d'); ?>
			 fechaActualFormat  = '<?php echo $phpvar; ?>';
			//alert('obtenerFechaActual fechaActualFormat::'+fechaActualFormat);
			$('#selectPedidos').attr('min', fechaActualFormat);
		return fechaActualFormat;
	}
	
	function mostrarPorTipoDeEntrega(){
		//alert('entro a la funcion mostrarPorTipoDeEntrega');
		var selectPedidos=0;
		var selectEntregas=0;
		var selectColonias=0;

		var valorPedidoSeleccionado=0;
		var valorEntregaSeleccionado=0;
		var valorColoniaSeleccionado=0;

		var divHora=0;
		if(document.getElementById("selectPedidos")){
			selectPedidos=obtenerTipoDePedido();
			if(!selectPedidos){return;}
			valorPedidoSeleccionado=selectPedidos;
			diasElaboracion=obtenerDiasDeDiferecia();
		}
		if(document.getElementById("selectEntregas")){
			selectEntregas = document.getElementById("selectEntregas");
			valorEntregaSeleccionado = selectEntregas.value;
		}
		if(document.getElementById("selectColonias")){
			selectColonias = document.getElementById("selectColonias");
			valorColoniaSeleccionado = selectColonias.value;
		}
		if (document.getElementById('fieldsetColoniaEntrega')) {
			fieldsetColoniaEntrega=document.getElementById('fieldsetColoniaEntrega');
		}
		if (document.getElementById('fieldsetHoraEntrega')) {
			fieldsetHoraEntrega=document.getElementById('fieldsetHoraEntrega');
		}
		selectHora.innerHTML="<option value='---'>Elige la hora de tu preferencia</option>";
		fieldsetHoraEntrega.style.display='none';
		//alert('valorEntregaSeleccionado::'+valorEntregaSeleccionado);
		if(valorEntregaSeleccionado!="---"&& (valorEntregaSeleccionado=="entregaTienda"||valorEntregaSeleccionado=="entregaDomicilio")){
			//alert('entro al if ');
			document.getElementById('fieldsetColoniaEntrega').style.display='block';
			//aqui va el ajax que consulta las colonias que se usaran ya sea que dan servicio o las de direccion de las pastelerias
			//if(valorColoniaSeleccionado!="---"){
			//alert('En mostrarPorTipoDeEntrega valorEntregaSeleccionado::'+valorEntregaSeleccionado+' valorPedidoSeleccionado::'+valorPedidoSeleccionado+' diasElaboracion::'+diasElaboracion);
			$.ajax({
			    type: 'POST',
			    url: 'consultas/consultaColoniasPasteleriasFiltro.php',
			    data: {valorEntregaSeleccionado:valorEntregaSeleccionado,valorPedidoSeleccionado:valorPedidoSeleccionado,diasElaboracion:diasElaboracion}
			})
			.done(function(msg){
				//alert('cargando filtro de colonias'+msg);
			    selectColonias.innerHTML =msg;
			    filtrarBusquedaPastel();
			})
			.fail(function(xhr, textStatus, error) {
			alert( "error al consultar filtro de colonias xhr::"+xhr.responseText+' textStatus::'+xhr.textStatus+' error:'+error );
			});
			//}
		}else{
			//alert('el tipo de entrega esta vacio');
			selectColonias.innerHTML="<option value='---'>Elige la colonia de tu preferencia</option>";
			fieldsetColoniaEntrega.style.display='none';
			filtrarBusquedaPastel();
		}
		filtrarBusquedaPastel();
	}

	
	function obtenerDiasDeDiferecia(){
		//alert('entro a la funcion obtenerDiasDeDiferecia');
		var f1=obtenerFechaActual();
		//alert('obtenerDiasDeDiferecia f1::'+f1);
		var f2="2016-01-01";
		if(document.getElementById("selectPedidos")){f2=document.getElementById("selectPedidos").value;}
		//alert('fechas:'+f1+' '+f2);
		var aFecha1 = f1.split('-'); 
        var aFecha2 = f2.split('-'); 
        var fFecha1 = Date.UTC(aFecha1[0],aFecha1[1]-1,aFecha1[2]); 
        var fFecha2 = Date.UTC(aFecha2[0],aFecha2[1]-1,aFecha2[2]); 
        var dif = fFecha2 - fFecha1;
        var dias = Math.floor(dif / (1000 * 60 * 60 * 24)); 
        //alert('dias de obtenerDiasDeDiferecia::'+dias);
        return dias;
	}
	
	//1A vs 2E
	function validarDiaDeEntrega(){
		//alert('entro a la funcion validarDiaDeEntrega');
		diaDeEntrega  = obtenerDiaDeEntrega();
		//alert('diaDeEntrega::'+diaDeEntrega);
		if(diaDeEntrega=='Monday'||diaDeEntrega=='Tuesday'||diaDeEntrega=='Wednesday'||diaDeEntrega=='Thursday'||diaDeEntrega=='Friday'||diaDeEntrega=='Saturday'||diaDeEntrega=='Sunday')
		{
			diaDeEntregaValido='si';
		}else{
			diaDeEntregaValido='no';
		}
		return diaDeEntregaValido;
	}
	
	function obtenerDiaDeEntrega(){
		//alert('entro a la funcion obtenerDiaDeEntrega');
		var fechaElegida=document.getElementById("selectPedidos").value;
		arregloFecha=fechaElegida.split('-'); 
		fechaElegidaFormato=arregloFecha[0]+","+arregloFecha[1]+","+arregloFecha[2];
		var fechaActual = new Date(fechaElegidaFormato);
		//alert('fecha seleccionada:::'+day+' '+dd+' fechaElegida::'+fechaElegidaFormato);
		var weekday = new Array(7);
		    weekday[0] = "Sunday";
		    weekday[1] = "Monday";
		    weekday[2] = "Tuesday";
		    weekday[3] = "Wednesday";
		    weekday[4] = "Thursday";
		    weekday[5] = "Friday";
		    weekday[6] = "Saturday";
		var dayName = weekday[fechaActual.getDay()];
		return dayName;
	}
	
	function mostrarPorColonia(){
		//alert('entro a la funcion obtenerDiaDeEntrega');
		
		var filtrosPedidosActivado=0;
		var filtrosEntregasActivado=0;
		var filtrosColoniasActivado=0;
		var filtroHoraActivado=0;

		var selectPedidos=0;
		var selectEntregas=0;
		var selectColonias=0;
		var selectHora=0;

		var valorPedidoSeleccionado=0;
		var valorEntregaSeleccionado=0;
		var valorColoniaSeleccionado=0;
		var valorHoraSeleccionado=0;

		var error=0;

		if(document.getElementById("selectPedidos")){
			selectPedidos=obtenerTipoDePedido();
			if(!selectPedidos){return;}
			valorPedidoSeleccionado=selectPedidos;
			diasElaboracion=obtenerDiasDeDiferecia();
		}
		if(document.getElementById("selectEntregas")){
			selectEntregas = document.getElementById("selectEntregas");
			valorEntregaSeleccionado = selectEntregas.value;
		}
		if(document.getElementById("selectColonias")){
			selectColonias = document.getElementById("selectColonias");
			valorColoniaSeleccionado = selectColonias.value;
		}
		if(document.getElementById("selectHora")){
			selectHora = document.getElementById("selectHora");
			valorHoraSeleccionado = selectHora.value;
		}
		if (document.getElementById('fieldsetHoraEntrega')) {
			fieldsetHoraEntrega=document.getElementById('fieldsetHoraEntrega');
		}

		//alert('entro a mostrarPorColonia');
		//alert("valor:"+valorHoraSeleccionado);
			//alert('mostrarPorColonia valorPedidoSeleccionado::'+valorPedidoSeleccionado+' valorEntregaSeleccionado::'+valorEntregaSeleccionado+' valorColoniaSeleccionado::'+valorColoniaSeleccionado);
		
		if(valorColoniaSeleccionado!="---"){

			fieldsetHoraEntrega.style.display='block';
			//if(valorEntregaSeleccionado=="entregaDomicilio"){
				
				$.ajax({
					type: 'POST',
					url: './consultas/consultarHorasRegistradasFiltro.php',
					data: {valorEntregaSeleccionado:valorEntregaSeleccionado,valorPedidoSeleccionado:valorPedidoSeleccionado,valorColoniaSeleccionado:valorColoniaSeleccionado},
				})
				.done(function(msg){
					alert(msg);
					//alert("valor colonia:"+valorColoniaSeleccionado);
					if(msg=="<option value=''>Para hoy entrega en tienda en esta colonia no tenemos servicio</option>"){
						alert('error');
						error=1;
						document.getElementById('pasteleriasFiltroDIv').style.display='none';
					}
					else{
						alert('No error');
						filtrarBusquedaPastel();
					}
					selectHora.innerHTML =msg;
					//filtrarBusquedaPastel();
				})
				.fail(function() {
					//alert( "error al consultar filtro" );
				});
			
		}else{
			//alert('tipo de colonia esta vacio');
			selectHora.innerHTML="<option value='---'>Elige la hora de tu preferencia</option>";
			fieldsetHoraEntrega.style.display='none';
			
		}
		//filtrarBusquedaPastel();
	
	}

	
	function filtrarBusquedaPastel(){
		//alert('entro a la funcion filtrarBusquedaPastel');
		var filtrosPedidosActivado=0;
		var filtrosEntregasActivado=0;
		var filtrosColoniasActivado=0;
		var filtroHoraActivado=0;

		var selectPedidos=0;
		var selectEntregas=0;
		var selectColonias=0;
		var selectHora=0;

		var valorPedidoSeleccionado=0;
		var valorEntregaSeleccionado=0;
		var valorColoniaSeleccionado=0;
		var valorHoraSeleccionado=0;

		var diasElaboracion	=0;
		//alert('entro a la funcion filtrarBusquedaPastel');
		//comprobamos que exiten los elementos para no generar error
		if(document.getElementById("selectPedidos")){
			selectPedidos = document.getElementById("selectPedidos");
			//selectedPedidoSeleccionado = selectPedidos.options[selectPedidos.selectedIndex].value;
			selectPedidos=obtenerTipoDePedido();
			//alert('antes de llamar a la funcion::'+selectPedidos);
			if(!selectPedidos){return;}
			valorPedidoSeleccionado = selectPedidos;
			diasElaboracion=obtenerDiasDeDiferecia();
			//alert('dias de eleboracion::'+diasElaboracion);
		}
		if(document.getElementById("selectEntregas")){
			selectEntregas = document.getElementById("selectEntregas");
			//selectedEntregaSeleccionado = selectEntregas.options[selectEntregas.selectedIndex].value;
			valorEntregaSeleccionado = selectEntregas.value;
		}
		if(document.getElementById("selectColonias")){
			selectColonias = document.getElementById("selectColonias");
			valorColoniaSeleccionado = selectColonias.value;
		}
		if(document.getElementById("selectHora")){
			selectHora = document.getElementById("selectHora");
			valorHoraSeleccionado = selectHora.value;
			if(valorHoraSeleccionado==null){
				valorHoraSeleccionado=0;
			}
		}

		if(valorPedidoSeleccionado!="---" && (valorPedidoSeleccionado=="hoy"||valorPedidoSeleccionado=="sobrePedido")&&valorPedidoSeleccionado!=0){
			filtrosPedidosActivado=1;
			//alert("Pedido activado");
		}

		//si se activo el tipo de entrega tambien se muestra el valor de colonia 
		if(valorEntregaSeleccionado!="---"&& (valorEntregaSeleccionado=="entregaTienda"||valorEntregaSeleccionado=="entregaDomicilio")&&valorEntregaSeleccionado!=0){
			filtrosEntregasActivado=1;
		}else{
			 selectColonias.innerHTML="<option value='---'>Elige la colonia de tu preferencia</option>";
		}
		if(valorColoniaSeleccionado!="---"&&valorColoniaSeleccionado!=0){
			filtrosColoniasActivado=1;	
		}
		if(valorHoraSeleccionado!="---"&&valorHoraSeleccionado!=0){
			filtroHoraActivado=1;
		}

		if(filtrosPedidosActivado==1 || filtrosEntregasActivado==1 || filtrosColoniasActivado==1){
			document.getElementById('pastelesMuestrasTodosDiv').style.display='none'; 
		}else{
			document.getElementById('pastelesMuestrasTodosDiv').style.display='block'; 
		}
		//alert("El valor de los filtros es Pedido:"+filtrosPedidosActivado+' valorPedido::'+diasElaboracion+"  _Entrega:"+filtrosEntregasActivado+' valorEntrega::'+valorEntregaSeleccionado+"  _Colonia:"+filtrosColoniasActivado+' valorColonia::'+valorColoniaSeleccionado+' _Hora:'+filtroHoraActivado+' valorHora::'+valorHoraSeleccionado);
		idProducto=0;

		$.ajax({
          type: 'POST',
          url: './consultas/consultarPasteleriasFiltro.php',
          data: {	filtrosPedidosActivado:filtrosPedidosActivado,		filtrosEntregasActivado:filtrosEntregasActivado,
          			filtrosColoniasActivado:filtrosColoniasActivado,	filtroHoraActivado:filtroHoraActivado,
          			valorPedidoSeleccionado:valorPedidoSeleccionado,	valorEntregaSeleccionado:valorEntregaSeleccionado,	
          			valorColoniaSeleccionado:valorColoniaSeleccionado,	valorHoraSeleccionado:valorHoraSeleccionado,
          			diasElaboracion:diasElaboracion},
        beforeSend: function(){
        	//alert('antes de mandar la info');
		},
        error: function(xhr){
            //alert("An error occured pasteleriasFiltro: " + xhr.status + " " + xhr.statusText);
        }
        })
        .done(function(msg){
        	//alert("Informacion despues del done filtroPastel:::"+msg);
          	document.getElementById('pasteleriasFiltroDIv').style.display='block';
          	document.getElementById("pasteleriasFiltroDIv").innerHTML =msg;
          	//pastelesMuestrasTodosDiv
          })
        .fail(function() {
          //alert( "error al consultar filtro" );
        });
        //alert("entro a la funcion filtrarBusquedaPastel despues ajax");
	}

</script>