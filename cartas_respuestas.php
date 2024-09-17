<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>El niño mensajero</title>
</head>
<body>
   
    <?php include('inc/header.php');
        require('config/config.php');
    require('config/db.php');
    ?>
    
    
    <div class="container"></div>
    
    <a href="<?php echo ROOT_URL; ?>" role = "button" style="float:left; margin:10px;">
			 <img src="images/boton_volver.gif" class="img-fluid" alt="Responsive image" id="btn-back"  style = 'width:150px; height:50px;'>
    </a> 
    <br>
    <br>
    <h1 style ="margin-right: 90px; " align="center"><strong>Cartas respondidas</strong></h1>
    
				
                    <?php
                        $consulta='SELECT * FROM carta_recivida where RESPUESTA IS NOT NULL ';
                        $carta = mysqli_query($conn,$consulta);
                         while($arreglo = mysqli_fetch_array($carta, MYSQL_ASSOC)){
                             
                             echo ' <div class="burbuja" >';
                             echo '<img src="data:image/png;base64,'.base64_encode($arreglo['IMAGEN_AVATAR']).'" height="100" width="100" align="left">' ;
                             echo '<h5><strong>Carta enviada la fecha: '.$arreglo['FECHA_RECEPCION'].'</strong></h5>';
                             $salto_de_linea = nl2br($arreglo['TEXTO_CARTA']);
                             echo "<br>".$salto_de_linea;
                             $imagen = $arreglo['IMAGEN'];
                                    if(!is_null($imagen)){
                                        echo "<div align='center'>" ;
                                        echo "<h5><strong>Imagen adjuntada a la carta</strong></h5>" ;
                                        echo "<img src='data:image/jpeg;base64,". base64_encode($imagen)."' height='125' width='125'>" ;
                                        echo "</div>" ;
                                    }
                             echo ' </div>';
                             echo '<div class="burbujaRespuesta">';
                             echo '<h5><strong>Respuesta</strong></h5>';
                             echo "<br><br>".$arreglo['RESPUESTA'];
                             echo '</div>';
                           
                         }
                ?>			
						
</body>
</html>