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
        $queryUsers = "SELECT DISTINCT * FROM usuario WHERE ID_ESPECIALIDAD = '$esp' ORDER BY NOMBRE_USUARIO ASC";
        $resultUsers = mysqli_query($conn,$queryUsers);
        mysqli_close($conn);
    ?>
    
     <a href="<?php echo ROOT_URL; ?>derivar_carta.php?id=<?php echo $id;?>" role = "button" style="float:left; margin:10px;">
        <img src="images/boton_volver.gif" class="img-fluid" alt="Responsive image" id="btn-back"  style = 'width:150px; height:50px;'>
    </a> 
    <br><br><br>
     <h2 style="float:center" align="center"><strong>Seleccione el usuario al que asignara la carta.</strong></h2>
    <div class="container">
        <table border='1'; class='table table-dark'>
			<tr class='warning'>
				<td>Nombre del empleado</td>
				<td>Apellido del empleado</td>
				<td>Correo del empleado</td>
                <td>Asignar carta a empleado</td>
			</tr>

            <?php
                while($usuarios = mysqli_fetch_array($resultUsers)){
                    echo "<tr class='success'>";
                        echo "<td>$usuarios[3]</td>";
                        echo "<td>$usuarios[4]</td>";
                        echo "<td>$usuarios[5]</td>";
                        echo "<td><a href='". ROOT_URL ."derivar_carta_usr.php?id=$id&esp=$esp&usr=$usuarios[0]&asi=1'><img class='imgCarta' src='images/selecion.png' class='img-sluid' alt='Responsive image' style = 'width:50px; height:50px;'></td>";
                    echo "</tr>";
                }
                extract($_GET);
            ?>
        </table>
        
    </div>

    <div class="modal" id="myModalAsi" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">¿Esta seguro de que quiere asignar la carta a este usuario?</h4>
                </div>
                <div class="modal-footer">
                    <?php echo "<a href='". ROOT_URL ."derivar_carta_usr.php?id=$id&esp=$esp&usr=$usr&asi=2' type='submit' class='btn btn-default'>aceptar</a>"; ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <?php
        if(@$asi==1){
			echo'
				<script>
					$("#myModalAsi").modal("show");
				</script>';
		} elseif (@$asi==2) {
            $sqlAsign="UPDATE carta_recivida SET ID_USUARIO=$usr WHERE ID_CARTA_RECIVIDA=$id";
            require('config/db.php');
            $resAsign=mysqli_query($conn,$sqlAsign);
            mysqli_close($conn);
            echo'<script type="text/javascript">
            alert("Carta asignada correctamente.");
            window.location.href="'.ROOT_URL.'VentanaUsuario.php";
            </script>';
        }
    ?>
    
</body>
</html>