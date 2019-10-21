<?php
	require('config/config.php');
	require('config/db.php');

	session_start();

	extract($_GET);

		$sql="SELECT * FROM usuario WHERE ID_USUARIO=$id";
		$ressql=mysqli_query($conn,$sql);
		$row=mysqli_fetch_row ($ressql);

	if (isset($_POST['editar'])) {
		$ciR = mysqli_real_escape_string($conn, $_POST['ci']);
		$tipoR = substr(mysqli_real_escape_string($conn, $_POST['tipo']),0,3);
		$nombreR = mysqli_real_escape_string($conn, $_POST['nombre']);
		$apellidoR = mysqli_real_escape_string($conn, $_POST['apellido']);

	$query = "UPDATE usuario SET ID_ESPECIALIDAD='$tipoR', NOMBRE_USUARIO='$nombreR', APELLIDOS_USUARIO='$apellidoR' WHERE ID_USUARIO=$ciR";
	if(mysqli_query($conn, $query)){
		header('Location: '.ROOT_URL.'Administrar.php');
	}
		$error = "No se pudieron guardar sus cambios.";
	}
?>

<?php include('inc/header.php'); ?>
<div class="container">

	  <a href="<?php echo ROOT_URL; ?>Administrar.php" role = "button" style="float:left; margin:10px;">
    <img src="https://image.flaticon.com/icons/svg/137/137623.svg" class="img-fluid" alt="Responsive image" id="btn-back">
  </a><br> 
  <h3>Volver</h3>

	

	<hr class="soft">
        <div class="cabeceraSesion">
        	<h2>EDICION DE USUARIOS</h2>
        </div>


	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"  class="login">
		CI<br>
		<div class="input-group">
			<input type="text" name="ci" value= "<?php echo $row[0] ?>" ><br>
		</div>
			Nombre<br>
		<div class="input-group">
			 <input type="text" name="nombre" value="<?php echo $row[3];?>">
		</div>
			Apellido<br> 
		<div class="input-group">
			<input type="text" name="apellido" value="<?php echo $row[4];?>">
		</div>
			Tipo<br> 
		<div class="input-group">
			<input type="text" name="tipo" value="<?php echo $row[7];?>">
		</div>
			<br>
			<a href="<?php echo ROOT_URL; ?>Administrar.php" name="cancel" style="margin-right: 70px; margin-left:10px" class="btn btn-success btn-primary">ATRAS</a>
			<button type="submit" name="editar" class="btn btn-success btn-primary">GUARDAR</button>
		</form>
	</hr>
	</div>
	



