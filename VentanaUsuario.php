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
?>

	<?php include('inc/header.php');
        echo "<br>";

		echo "<h2><strong>Bienvenido: ". $nombre . "</strong> </h2>";
		
		//echo '<h2 style="text-align:right">Alertas:</h2>';
		
    	require('config/db.php');
		$sql=("SELECT * FROM carta_recivida WHERE ID_USUARIO='$id'");
		$query=mysqli_query($conn,$sql);
        $permisos = "SELECT * FROM especialidad WHERE ID_ESPECIALIDAD='$rol'" ;
        $obten_permisos = mysqli_query($conn, $permisos);
        $permisos_obtenidos = mysqli_fetch_array($obten_permisos, MYSQL_ASSOC);
        $leer = $permisos_obtenidos['LEER'];
        $responder = $permisos_obtenidos['RESPONDER'];
        $postular = $permisos_obtenidos['POSTULAR'];
        $name = $permisos_obtenidos['NOMBRE_ESPECIALIDAD'];
        echo '<h2 ><strong>Rol: '.$name.'</strong></h2>'; 
    
        echo '<h2 style="text-align:center"><strong>CARTAS ASIGNADAS</strong></h2>'; 
        ?>
         
          
		<table border="1"; class="table table-dark" style="margin-left: auto;margin-right: auto;max-width:70%">
			<tr class='warning'>
				<td>Fecha de recepcion</td>
				<?php if($leer == 'si'): ?>
				    <td>Leer carta</td>
				    <td>Carta Leida</td>
               <?php endif ; ?>
               <?php if($responder == 'si'):?>
                <td>Carta Respondida</td>
                <?php endif ;?>
                <?php if($postular == 'si'):?>
                <td>Postulada a Boletin</td>
                <?php endif;?>
			 </tr>     

        <?php		
            while($arreglo = mysqli_fetch_array($query, MYSQL_ASSOC)){	
            
			echo "<tr class='success'>";
                echo "<td>". $arreglo['FECHA_RECEPCION']."</td>";
                
                
                if($leer == 'si'){
                    echo "<div style='float:center'>
                    <td align='center'><a href=".ROOT_URL."lectura_carta.php?id=". $arreglo['ID_CARTA_RECIVIDA']. "><img class='imgCarta' src='images/leer.png' class='img-sluid' alt='Responsive image' style ='width:50px; height:50px;'></td>
                    </div>";
                    $leida = $arreglo['LEIDA'] ;
                    if($leida == "si"){
                        echo "<div style='float:center'>
                        <td align='center'><img class='imgCarta' src='images/leido.png' class='img-sluid' alt='Responsive image' style ='width:50px; height:50px;'></td>
                        </div>";
                    }else{
                         echo "   <td align='center'><img class='imgCarta' src='images/no.png' class='img-sluid' alt='Responsive image' style ='width:50px; height:50px;'></td>" ;
                    }

                }
                
                
                
                if($responder == 'si'){
                    $resp = $arreglo['RESPUESTA'] ;
                    if(isset($resp) && trim($resp)){
                        echo "<div style='float:center'>
                        <td align='center'><img class='imgCarta' src='images/responder.png' class='img-sluid' alt='Responsive image' style ='width:50px; height:50px;'></td>
                        </div>";
                    }else {
                         echo "   <td align='center'><img class='imgCarta' src='images/no.png' class='img-sluid' alt='Responsive image' style ='width:50px; height:50px;'></td>" ;
                    }
                }
                
                
                if($postular == 'si'){
                    $fav = $arreglo['POSTULACION_BOLETIN'] ;
                    if($fav == "si"){
                        echo "<div style='float:center'>
                        <td align='center'><img class='imgCarta' src='images/favoritos.png' class='img-sluid' alt='Responsive image' style ='width:50px; height:50px;'></td>
                        </div>";
                    }else{
                         echo "   <td align='center'><img class='imgCarta' src='images/no.png' class='img-sluid' alt='Responsive image' style ='width:50px; height:50px;'></td>" ;
                    }
                
                }
                
               
				
				//echo "<td><a href='carta.php?id=$arreglo[0]'>$arreglo[2]</a></td>";
				//echo "<td>$arreglo[8]</td>";
				//echo "<td>$arreglo[5]</td>";
				//echo "<td>$arreglo[]</td>";
				//echo "<td><a href='actualizar.php?id=$arreglo[0]'><img src='images/actualizar.gif' class='img-rounded'></td>";

				//echo "<td ><a href='Administrar.php?id=$arreglo[0]&idborrar=2 ' ><img src='images/eliminar.png' class='img-rounded'/></a></td>";	
	           echo "</tr>";

		}
        mysqli_close($conn);

		echo "</table>";

		extract($_GET);
?>



    <?php 
    if(@$idborrar==2){
    				echo'
<script>
    				$("#myModal").modal("show");
    				</script>';
    			}

    ?>
    
</body>
</html>