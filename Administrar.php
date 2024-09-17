<?php
	require('config/config.php');
	require('config/db.php');
	session_start();

	if(!isset($_COOKIE)){
		header('Location: '.ROOT_URL.'');
	} else {
		if($_COOKIE['roll'] != 'administrador'){
			header('Location: '.ROOT_URL.'');
		}
	}
	$nombre = $_COOKIE['nombreUsuario'];
    $rol1 = $_COOKIE['roll'];
 include('inc/header.php');
		echo "<table border='1'; class='table table-dark';>";
			echo "<tr class='warning'>";
				echo "<td>ID</td>";
				echo "<td>Nombre</td>";
				echo "<td>Apellido</td>";
				echo "<td>Especialidad</td>";
				echo "<td>Correo</td>";
				echo "<td>Editar</td>";
				echo "<td>Borrar</td>";
			echo "</tr>";
	?>

	<br>
	<h2 align="left"><strong>Bienvenido: <?php echo $nombre?> </strong> </h2>
   <h2><strong>Rol: Administrador</strong></h2>
    
		
<h3 align="center"><strong>Administración de usuarios registrados</strong> </h3>




<button type="button" class="btn btn-default" href=''></button>

	<?php
        $sql=("SELECT * FROM usuario");
		$query=mysqli_query($conn,$sql);
        while($arreglo=mysqli_fetch_array($query,MYSQL_ASSOC)){	
			echo "<tr class='success'>";
            echo "<td>".$arreglo['ID_USUARIO']."</td>"; 
            echo "<td>".$arreglo['NOMBRE_USUARIO']."</td>";
            echo "<td>".$arreglo['APELLIDOS_USUARIO']."</td>";
            $id_especialidad = $arreglo['ID_ESPECIALIDAD'] ;
            $obtengo_especialidad = mysqli_query($conn, "SELECT  NOMBRE_ESPECIALIDAD FROM especialidad WHERE ID_ESPECIALIDAD = '$id_especialidad'");
            $obtengo_especialidad1 = mysqli_fetch_array($obtengo_especialidad,MYSQL_ASSOC);
            echo "<td>".$obtengo_especialidad1['NOMBRE_ESPECIALIDAD']."</td>";
            
            echo "<td>".$arreglo['CORREO_USUARIO']."</td>";
            //echo "<td>$arreglo[5]</td>";
            
             echo '<td><a href="'. ROOT_URL .'actualizar.php?id='.$arreglo['ID_USUARIO'].'"><img class="imgCarta" src="images/ICONO_ACTUALIZAR.png" class="img-sluid" alt="Responsive image" style = "width:50px; height:50px;"></td>';
            
            echo '<td><a href="'. ROOT_URL .'Administrar.php?id='.$arreglo['ID_USUARIO'].'&idborrar=2"><img class="imgCarta" src="images/ICONO_ELIMINAR.png" class="img-sluid" alt="Responsive image" style = "width:50px; height:50px;"></td>';
            

            
	
			echo "</tr>";

		}

		echo "</table>";
		 mysqli_close($conn);

		


		extract($_GET);


?>
    <div class="modal" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Esta seguro de que quiere eliminar al usuario: 
           <?php 
              require('config/db.php');
              $sql=("SELECT * FROM usuario");
		      $query=mysqli_query($conn,"SELECT * FROM usuario WHERE ID_USUARIO = '$id'");
              $res = mysqli_fetch_array($query,MYSQL_ASSOC);
               mysqli_close($conn);
              echo $res['NOMBRE_USUARIO']." ".$res['APELLIDOS_USUARIO'] ;
              ?></h4>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">

        	 <form method="post">


          <button type="submit" class="btn btn-success btn-primary" name = "aceptar">Aceptar</button>
          
          <?php 	if(isset($_POST["aceptar"])){
          require('config/db.php');
		$sqlborrar="DELETE FROM usuario WHERE ID_USUARIO=$id";
		$resborrar=mysqli_query($conn,$sqlborrar);
        mysqli_close($conn);
        if($resborrar){
               echo '<script type="text/javascript">
                                    alert("EL USUARIO FUE ELIMINADO CORRECTAMENTE");
                                    window.location.href="'. ROOT_URL .'Administrar.php";
                                    </script>';
        }else{
             echo '<script type="text/javascript">
                                    alert("EL USUARIO NO SE PUDO ELIMINAR. ASEGURECE QUE NO TENGA CARTAS ASIGNADAS");
                                    window.location.href="'. ROOT_URL .'Administrar.php";
                                    </script>';
            }
        }	 ?>

</form>
         <button type="button" class="btn btn-success btn-primary" data-dismiss="modal">Cancelar</button>

        </div>
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
