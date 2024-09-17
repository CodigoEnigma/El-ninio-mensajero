<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>El niño mensajero</title>
</head>
<body>
    
    
    
    <?php
	require('config/config.php');
    

	session_start();
    if(!isset($_COOKIE)){
		header('Location: '.ROOT_URL.'');
	}else{
        $nombre = $_COOKIE['nombreUsuario'];
        $id = $_COOKIE['id_usuario'];
        $rol = $_COOKIE['roll'];
    } 
include('inc/header.php'); 
    	extract($_GET);
    
    ?>
     <a href="<?php echo ROOT_URL; ?>/editor_boletin.php" role = "button" style="float:left; margin:10px;">
			 <img src="images/boton_volver.gif" class="img-fluid" alt="Responsive image" id="btn-back"  style = 'width:150px; height:50px;'>
    </a> 
    <br>
    <h2 style ="margin-right: 90px; " align="center"><strong>Carta recomendadas para boletin</strong></h2>'
    
    
    
				
                    <?php
    
                         require('config/db.php');
                        $consulta="SELECT * FROM carta_recivida where ID_CARTA_RECIVIDA = '$id'";
                        $carta = mysqli_query($conn,$consulta);
                         while($arreglo = mysqli_fetch_array($carta, MYSQL_ASSOC)){
                             $consulta1 = "SELECT NOMBRE_USUARIO,APELLIDOS_USUARIO, NOMBRE_ESPECIALIDAD FROM especialidad, usuario, carta_recivida WHERE carta_recivida.ID_USUARIO = usuario.ID_USUARIO and usuario.ID_ESPECIALIDAD = especialidad.ID_ESPECIALIDAD  and carta_recivida.ID_CARTA_RECIVIDA = '$id'" ;
                             
                             $obtener_uss_espe = mysqli_query($conn,$consulta1);
                             
                             $res_user_esp = mysqli_fetch_array($obtener_uss_espe,MYSQL_ASSOC);
                             
                             echo ' <h3 style ="margin-right: 90px; " align="left"><strong>Carta recomendada por: '.$res_user_esp['NOMBRE_USUARIO'].' '.$res_user_esp['APELLIDOS_USUARIO'].'</strong></h3>' ;
                             echo ' <h3 style ="margin-right: 90px; " align="left"><strong>Esta carta pertenece a la especialidad: '.$res_user_esp['NOMBRE_ESPECIALIDAD'].'</strong></h3>' ;
                             echo ' <div class="burbuja" >';
                             echo '<img src="data:image/png;base64,'.base64_encode($arreglo['IMAGEN_AVATAR']).'" height="100" width="100" align="left">' ;
                             echo '<h5><strong>Carta enviada la fecha: '.$arreglo['FECHA_RECEPCION'].'</strong></h5>';
                             echo "<br>".$arreglo['TEXTO_CARTA'];
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