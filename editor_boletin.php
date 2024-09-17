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
    	
    
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>El niño mensajero</title>
</head>
    <body>
        <br>
        <div style="float:right">
                <a class="btn btn-primary" href="<?php echo ROOT_URL; ?>edicion_boletin.php" role="button" id ="crearEspecialidad" style="margin:30px;">Administrar boletines</a>
            </div>
		<h2 align="left"><strong>Bienvenido: <?php echo $nombre?></strong> </h2>
		<h2 align="left"><strong>Rol: <?php
                require('config/db.php');
                $nom_esp = mysqli_query( $conn, "SELECT NOMBRE_ESPECIALIDAD FROM especialidad WHERE ID_ESPECIALIDAD = '$rol'");
                $res_nombre_esp = mysqli_fetch_array($nom_esp, MYSQL_ASSOC);
                mysqli_close($conn);
                echo $res_nombre_esp['NOMBRE_ESPECIALIDAD'];
               
            
            ?>
		</strong> </h2>
		<br>
		<h2 style="text-align:center"><strong>CARTAS ASIGNADAS</strong></h2>
        <table border="1"; class="table table-dark" style="margin-left: auto;margin-right: auto;max-width:70%">
			<tr class='warning'>
                <td>ID Carta</td>
                <td>Fecha de envio de carta</td>
				<td>Leer Carta</td>
             </tr>
             
          <?php
            require('config/db.php');
            $query = mysqli_query($conn,"SELECT * FROM carta_recivida WHERE POSTULACION_BOLETIN = 'si'");
             while($arreglo = mysqli_fetch_array($query, MYSQL_ASSOC)){
                echo "<tr class='success'>";
                echo "<td>".$arreglo['ID_CARTA_RECIVIDA']."</td>";
                 echo "<td>".$arreglo['FECHA_RECEPCION']."</td>";
                 echo "<div style='float:center'>
                    <td align='center'><a href=".ROOT_URL."lec_carta.php?id=". $arreglo['ID_CARTA_RECIVIDA']. "><img class='imgCarta' src='images/leer.png' class='img-sluid' alt='Responsive image' style ='width:50px; height:50px;'></td>
                    </div>";
                 echo "</tr>";
             
             }
             mysqli_close($conn);
            ?>   
             
             
             
        </table>
    </body>
</html>