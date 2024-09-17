<?php
	require('config/config.php');
	
	session_start();
	if(!isset($_COOKIE)){
		header('Location: '.ROOT_URL.'');
	} else {
		if($_COOKIE['roll'] != 'administrador'){
			//$queryEspec = 'SELECT * FROM especialidad';
      		//$resultEspec = mysqli_query($conn,$queryEspec);
			//$especs = mysqli_fetch_array($resultEspec, MYSQL_ASSOC);
			header('Location: '.ROOT_URL.'');
		} else {

			extract($_GET);
                require('config/db.php');
				$sql="SELECT * FROM usuario WHERE ID_USUARIO='$id'";
				$ressql=mysqli_query($conn,$sql);
				$row=mysqli_fetch_array ($ressql, MYSQL_ASSOC);
                mysqli_close($conn);
			
		}//FIN ELSE
	}
?>

<?php include('inc/header.php'); 

?>




	 <a href="<?php echo ROOT_URL; ?>Administrar.php" role = "button" style="float:left; margin:10px;">
			 <img src="images/boton_volver.gif" class="img-fluid" alt="Responsive image" id="btn-back"  style = 'width:150px; height:50px;'>
            </a> 
  

	<?php
        
        if (isset($_POST['editar'])) {
                require('config/db.php');
				$ciR = mysqli_real_escape_string($conn, $_POST['ci']);
				$tipoR = mysqli_real_escape_string($conn, $_POST['especialidad']);
				$nombreR = mysqli_real_escape_string($conn, $_POST['nombre']);
				$apellidoR = mysqli_real_escape_string($conn, $_POST['apellido']);
                
               
            

			$query = "UPDATE usuario SET ID_ESPECIALIDAD='$tipoR', NOMBRE_USUARIO='$nombreR', APELLIDOS_USUARIO='$apellidoR' WHERE ID_USUARIO=$ciR";

           
			if(mysqli_query($conn, $query)){
				
				 echo'<script type="text/javascript">
                                    alert("Actualizacion realizada con exito");
                                    window.location.href="'. ROOT_URL .'Administrar.php";
                                    </script>';
                }else{
                        echo'<script type="text/javascript">
                                    alert("No se pudo actualizar'.$tipoR.'");
                                    window.location.href="'. ROOT_URL .'actualizar.php?id='.$id.'";
                                    </script>';   }
				
			}

    ?>







	<hr class="soft">
        <div class="cabeceraSesion">
        	<h2>EDICION DE USUARIOS</h2>
        </div>


	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"  class="login">
		
		<div class="input-group">
		    <label>Cedula de Identidad</label> <br>
			<input type="text" name="ci" value= "<?php echo $row['ID_USUARIO'] ?>" ><br>
		</div>
		<div class="input-group">
        	 <label>Nombre</label>
			 <input type="text" name="nombre" value="<?php echo $row['NOMBRE_USUARIO'];?>">
		</div>
		
		<div class="input-group">
		    <label>Apellidos</label> 

			<input type="text" name="apellido" value="<?php echo $row['APELLIDOS_USUARIO'];?>">
		</div>
       
        <div class="input-group">
         <label>Especialidad: </label><br>
          <select name="especialidad" >
            <option value=""><?php $esp = $row['ID_ESPECIALIDAD'];
                                require('config/db.php');
                                $consulta_especialidad = mysqli_query($conn,"SELECT NOMBRE_ESPECIALIDAD FROM especialidad WHERE ID_ESPECIALIDAD ='$esp'");
                                $resultado_especialidad = mysqli_fetch_array($consulta_especialidad,MYSQL_ASSOC);
                                 mysqli_close($conn);  
                                echo $resultado_especialidad['NOMBRE_ESPECIALIDAD'] ;
                
                
                ?></option> 
            <?php require('config/db.php');
                $query=mysqli_query($conn,"SELECT * FROM especialidad");
                while($especialidad= mysqli_fetch_array($query,MYSQL_ASSOC)){
                    echo '<option value="'.$especialidad['ID_ESPECIALIDAD'].'">'. $especialidad['NOMBRE_ESPECIALIDAD'].'</option>' ;
                }
               mysqli_close($conn);
                ?>
          </select> 
        </div>
		
		    <button type="submit" name="editar" class="btn btn-primary btn-block">Guardar</button>
			<br>
			<a href="<?php echo ROOT_URL; ?>Administrar.php" name="cancel"  class="btn btn-primary btn-block">Cancelar</a>
			<br>
			
		</form>
	</hr>
	
