<?php
	require('config/config.php');
    require('config/db.php');

    if(isset($_POST['submit'])){
		$body = $_POST['TEXTO_CARTA'];
		date_default_timezone_set('America/La_Paz');
		$fecha = date("Y-m-d H:i:s");
		//$img = $_POST['imagen'];
		//$image = addslashes(file_get_contents($_POST['imagen']['tmp_name']));
		$nombre_imagen = $_FILES['imagen']['name'];
    	$tipo_imagen=$_FILES['imagen']['type'];
		$tamanio_imagen=$_FILES['imagen']['size'];
		
		if($tamanio_imagen<=20000000){
			if($tipo_imagen=="image/jpeg" || $tipo_imagen=="image/jpg" || $tipo_imagen=="image/png" ||
				$tipo_imagen=="image/gif"){ 
				$carpeta_destino=$_SERVER['ROOT_URL'];
				
					move_uploaded_file($_FILES['imagen']['tmp_name'],$nombre_imagen);
					//echo "exito";
	
			} //else {echo "Solo se pueden subir imagenes" ;} 
		}  //else {echo "tamaño muy grande de la imagen" ;}

		$archivo_objetivo=fopen($nombre_imagen,"r");

    	$contenido=fread($archivo_objetivo,$tamanio_imagen); 
	
	    $contenido=addslashes($contenido);

    	fclose($archivo_objetivo);

		$query = "INSERT INTO carta_recivida (TEXTO_CARTA, FECHA_RECEPCION, IMAGEN) VALUES('$body', '$fecha', '$contenido')";

		if(mysqli_query($conn, $query)){
			header('Location: '.ROOT_URL.'');
			
		} else {
			echo 'ERROR: '. mysqli_error($conn);
		}
	}
	
?>

<?php include('inc/header.php'); ?>


    <div class="container">
	<script type="text/javascript">
		function abrir(){
			alert('Su carta ha sido enviada con exito :)');
		}
	</script>
        <div class="alert alert-danger" role="alert">
			<div class="icono-advertencia">
				<img src="images/icono-advertencia.png" style="height: 100px; width: 100px;">
			</div>
            <h4><strong>Recuerda amiguito! Tu seguridad es muy importante para nosotros. Por favor no utilices tus nombres o apellidos, el nombre de tu escuela, el lugar donde vives, el nombre de tus padres o numero de telefono.</strong></h4>
		</div>
		<a href="<?=$_SERVER['HTTP_REFERER'] ?>" role = "button" style="float:left; margin:10px;">
			 <img src="https://image.flaticon.com/icons/svg/137/137623.svg" class="img-fluid" alt="Responsive image" id="btn-back">
		  </a> 
		  <br> <h2>Volver</h2>
		  <br>
        <h1>Cuentanos como estas</h1>
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
			<div class="form-group">
				<textarea name="TEXTO_CARTA" class="form-control" style="height: 20rem;"></textarea><br>
			
				<input type="file" name="imagen" id="imagen" size="20" class="btn btn-info"> 
			
				<input type="submit" name="submit" id="enviar" value="Enviar carta" class="btn" onclick="abrir();">
			</div>			
    </div>