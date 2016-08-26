<?php
  require_once('connections/conextion.php');
	mysql_select_db($database_conexionproductos, $conexionproductos);
	$query_DatosPasteles = "SELECT * FROM tblcakes WHERE tblcakes.intPasteleria=$pasteleria ORDER BY rand() LIMIT 3";
	//$query_DatosPasteles = "SELECT * FROM tblcakes WHERE tblcakes.intPasteleria=$pasteleria ORDER BY rand()";
  $DatosPasteles = mysql_query($query_DatosPasteles, $conexionproductos) or die(mysql_error());
  $row_DatosPasteles = mysql_fetch_assoc($DatosPasteles);
  $totalRows_DatosPasteles = mysql_num_rows($DatosPasteles);
/*

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
      <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
*/
  echo ' <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
      <style>
      .carousel-inner > .item > img,
      .carousel-inner > .item > a > img {
          width: 70%;
          margin: auto;
      }
      </style>';

  echo '<div id="myCarousel" class="carousel slide" data-ride="carousel">';
    if ($totalRows_DatosPasteles > 0) { // Show if recordset not empty  
      echo '<ol class="carousel-indicators">';
        echo '<li data-target="#myCarousel" data-slide-to="0" class="active"></li>';
        for($i=1;$i<$totalRows_DatosPasteles;$i++){
          echo '<li data-target="#myCarousel" data-slide-to="'.$i.'"></li>';
        }
      echo '</ol>';
      $contador=1;
      
      do { 
        echo '<div class="carousel-inner" role="listbox">';

          if($contador==1){
            
            echo '<div class="item active">';
              echo '<img src="documentos/pasteles/'. $row_DatosPasteles['strImagen'] .'" alt="'. $row_DatosPasteles['strNombre'] .'">';
              echo '<div  class="button">';
                echo "<form name='FComprar".$contador."' action='carrito-add.php' method='get'>";
                echo '<input name="intCantidad" type="hidden" id="intCantidad" value="1"/>';
                $intPasoCarrito=ObtenerIntPasoCarrito($pasteleria);
                  echo '<input name="relCakestore" type="hidden" id="relCakestore" value="'.$intPasoCarrito.'"/>';
                  echo '<input name="recordID" type="hidden" value="'. $row_DatosPasteles['idProducto'].'"/>';
                  echo '<input name="intNombrePasteleria" type="hidden" value="'. $pasteleria.'"/>';
                echo "<input class='btn btn-ok input-field'  name='' type='submit' value='$".$row_DatosPasteles['dblPrecio']."' />";
                echo '</form>';
              echo '</div>';
            echo '</div>';
            
          }else{ 
            
            echo '<div class="item">';
              echo '<img src="documentos/pasteles/'. $row_DatosPasteles['strImagen'] .'" alt="Chania">';
            echo '</div>';
            
          } 
          
        echo '</div>';
        $contador++;
      } while ($row_DatosPasteles = mysql_fetch_assoc($DatosPasteles)); 
      echo '<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">';
        echo '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>';
        echo '<span class="sr-only">Previous</span>';
      echo '</a>';
      echo '<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">';
        echo '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>';
        echo '<span class="sr-only">Next</span>';
      echo '</a>';
    } // Show if recordset not empty 
    
  echo '</div>';
?> 