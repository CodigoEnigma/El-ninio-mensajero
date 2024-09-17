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
        include('inc/header.php');
        extract($_GET);
        require('config/db.php');
        $queryEspec = 'SELECT DISTINCT * FROM especialidad WHERE NOMBRE_ESPECIALIDAD NOT LIKE "Administrador" ORDER BY NOMBRE_ESPECIALIDAD ASC';
        $resultEspec = mysqli_query($conn,$queryEspec);
        mysqli_close($conn);
    ?>
    
    <a href="<?php echo ROOT_URL; ?>lectura_carta.php?id=<?php echo $id;?>" role = "button" style="float:left; margin:10px;">
        <img src="images/boton_volver.gif" class="img-fluid" alt="Responsive image" id="btn-back"  style = 'width:150px; height:50px;'>
    </a> 
    <br><br><br>
    <h2 style="float:center" align="center"><strong>Seleccione una especialidad.</strong></h2>
    <div class="container">
        <table border='1'; class='table table-dark'>
			<tr class='warning'>
				<td>Id de la especialidad</td>
				<td>Nombre de la especialidad</td>
				<td>Seleccionar</td>
			</tr>

            <?php
                while($especs = mysqli_fetch_array($resultEspec)){
                    $nombre_esp = $especs[1] ;
                    if($nombre_esp != "Editor Boletin" && $nombre_esp != "Lector"){
                        
                         echo "<tr class='success'>";
                        echo "<td>$especs[0]</td>";
                        echo "<td>$nombre_esp</td>";
                        echo "<td><a href='". ROOT_URL ."derivar_carta_usr.php?id=$id&esp=$especs[0]'><img class='imgCarta' src='images/usuario.png' class='img-sluid' alt='Responsive image' style = 'width:50px; height:50px;'></td>";
                    echo "</tr>";
                    }
                   
                }

            ?>
        </table>
    </div>
    
</body>
</html>