<?php
	require('config/config.php');
	require('config/db.php');
	session_start();
	
?>


<?php include('inc/header.php'); ?>

            <a href="<?php echo ROOT_URL; ?>editor_boletin.php" role = "button" style="float:left; margin:10px;">
                <img src="images/boton_volver.gif" class="img-fluid" alt="Responsive image" id="btn-back"  style = 'width:150px; height:50px;'> </a>
           
           <div style="float:right">
                <a class="btn btn-primary" href="<?php echo ROOT_URL; ?>edicion_boletinF.php?id=""" role="button" id ="crearEspecialidad" style="margin:30px;">Crear boletin</a>
            </div>
		  <br>

	<?php
		$sql=("SELECT * FROM boletin");
		$query=mysqli_query($conn,$sql);
		echo '<div class="cabecera">';
		echo "<table border='1'; class='table table-dark';>";
			echo "<tr class='warning'>";
				echo "<td>Texto</td>";
				echo "<td>Fecha</td>";
				echo "<td>Editar</td>";
				echo "<td>Eliminar</td>";
			echo "</tr>";
		echo '</div>';
	?>

	
<h2> Administración de Boletin</h2>
	

	<?php

				//echo "<table>";

		while($arreglo=mysqli_fetch_array($query)){


			echo "<tr class='success'>";
				echo "<td>$arreglo[1]</td>";
				echo "<td>$arreglo[3]</td>";
				echo "<td><a href='". ROOT_URL ."edicion_boletinF.php?id=".$arreglo['ID_BOLETIN']."'><img class='imgCarta' src='images/ICONO_ACTUALIZAR.png' class='img-sluid' alt='Responsive image' style = 'width:50px; height:50px;'></td>";
                
                echo "<td><a href='edicion_boletin.php?id=$arreglo[0]&idborrar=2'><img class='imgCarta' src='images/ICONO_ELIMINAR.png' class='img-sluid' alt='Responsive image' style = 'width:50px; height:50px;'></td>";	


			//	echo "<td><a href='actualizar.php?id=$arreglo[0]'><img src='images/actualizar.gif' class='img-rounded'></td>";

			//	echo "<td ><a href='Administrar.php?id=$arreglo[0]&idborrar=2 ' ><img src='images/eliminar.png' class='img-rounded'/></a></td>";	
	
			echo "</tr>";

		}
		//echo </table>";
		

		


		extract($_GET);


?>





<div class="modal" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" style="color:black">Esta seguro que desea eliminar el boletin 
           </h4>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">

        	 <form method="post">


          <button type="submit" class="btn btn-success btn-primary" name = "aceptar">Aceptar</button>
          
          <?php 	if(isset($_POST["aceptar"])){
          require('config/db.php');
		$sqlborrar="DELETE FROM `boletin` WHERE `boletin`.`ID_BOLETIN` = '$id'";
		$resborrar=mysqli_query($conn,$sqlborrar);
        mysqli_close($conn);
        if($resborrar){
               echo '<script type="text/javascript">
                                    alert("BOLETIN ELIMINADO CON ÉXITO");
                                    window.location.href="'. ROOT_URL .'edicion_boletin.php";
                                    </script>';
        }
        }	 ?>

</form>
         <button type="button" class="btn btn-success btn-primary" data-dismiss="modal">Cancelar</button>

        </div>
      </div>
      
    </div>
  </div>
  




    <?php 
    if(@$idborrar==2){
    				echo'
                    <script>
    				$("#myModal").modal("show");
    				</script>';
    			}

    ?>