
<?php
	require('config/config.php');
   

    if(isset($_POST['submit'])){
		$body = $_POST['TEXTO_CARTA'];
		date_default_timezone_set('America/La_Paz');
		$fecha = date("Y-m-d H:i:s");
		//$img = $_POST['imagen'];
		//$image = addslashes(file_get_contents($_POST['imagen']['tmp_name']));
		$nombre_imagen = $_FILES['imagen']['name'];
    	$tipo_imagen=$_FILES['imagen']['type'];
		$tamanio_imagen=$_FILES['imagen']['size'];
        
        if($tamanio_imagen != 0){
		 
            if($tamanio_imagen<=20000000){
                if($tipo_imagen=="image/jpeg" || $tipo_imagen=="image/jpg" || $tipo_imagen=="image/png" || $tipo_imagen=="image/gif"){ 
                     $carpeta_destino=$_SERVER['DOCUMENT_ROOT'];
                        move_uploaded_file($_FILES['imagen']['tmp_name'],$nombre_imagen);
                        //echo "exito";

                 } //else {echo "Solo se pueden subir imagenes" ;} 
              }  //else {echo "tamaño muy grande de la imagen" ;}
            
            $directorio = opendir("palabras/") ;
            $estado=0;
            while($archivo=readdir($directorio) ){
                if($estado==0){
                    if(!is_dir($archivo)){
                    $nombre = $archivo ;
                    extract($_GET) ;
                    $texto = explode(" ",$body);
                    $archivo = fopen("palabras/". $archivo,"r");
                    while(!feof($archivo) && $estado==0){
                        $cadena = fgets($archivo);
                        $cadena1 = trim($cadena);
                        foreach($texto as $palabra){
                            $palabra1=trim($palabra);
                            if($cadena1==$palabra1){
                                $nombre1 = rtrim($nombre,".txt");
                                require('config/db.php');
                                $especialidad = mysqli_query($conn,"SELECT ID_ESPECIALIDAD FROM especialidad WHERE NOMBRE_ESPECIALIDAD = '$nombre1'");
                                $clave=mysqli_fetch_array($especialidad) ;
                                mysqli_close($conn);
                                require('config/db.php');
                                $especialistas = mysqli_query($conn, "SELECT ID_USUARIO FROM usuario WHERE ID_ESPECIALIDAD = '$clave[0]'");
                                $cantidad_cartas = 0 ;
                                $usuario_asignado  ;
                                while($usuarios=mysqli_fetch_array($especialistas)){ 
                                    $usuario_actual=$usuarios[0] ;
                                    $cartas = mysqli_query($conn, "SELECT COUNT(ID_USUARIO) FROM carta_recivida WHERE ID_USUARIO = '$usuario_actual'");
                                    $numero_cartas = mysqli_fetch_array($cartas);
                                    $num_cartas = $numero_cartas[0];
                                    if($cantidad_cartas == 0){$cantidad_cartas = $num_cartas ;}
                                    if($cantidad_cartas >= $num_cartas){
                                        $cantidad_cartas = $num_cartas;
                                        $usuario_asignado = $usuario_actual;
                                    }
                                
                                }
                                mysqli_close($conn);
                                $archivo_objetivo=fopen($nombre_imagen,"r");
                                $contenido=fread($archivo_objetivo,$tamanio_imagen); 
                                $contenido=addslashes($contenido);
                                fclose($archivo_objetivo);
                                
                                $fichero = "emojis/". $id. ".png";
                                $archivo_objetivo1=fopen($fichero,"r");
                                $contenido1=fread($archivo_objetivo1, filesize($fichero)); 
                                $contenido1=addslashes($contenido1);
                                fclose($archivo_objetivo1);
                                
                                extract($_GET) ;
                                require('config/db.php');
                                $query = "INSERT INTO carta_recivida (ID_USUARIO, TEXTO_CARTA, FECHA_RECEPCION, IMAGEN, IMAGEN_AVATAR) VALUES('$usuario_asignado','$body', '$fecha', '$contenido','$contenido1')";

                                if(mysqli_query($conn, $query)){
                                    echo'<script type="text/javascript">
                                    alert("Carta Enviada");
                                    window.location.href="index.php";
                                    </script>';
                                 } else {
                                     echo 'ERROR: '. mysqli_error($conn);}
                                 mysqli_close($conn);


                                 unlink($nombre_imagen);

                                
                               
                                }
                            }
                    }  
                    }
                }
    
            }
            
             
            
     }else{
            $directorio = opendir("palabras/") ;
            $estado=0;
            while($archivo=readdir($directorio) ){
                if($estado==0){
                    if(!is_dir($archivo)){
                    $nombre = $archivo ;
                    extract($_GET) ;
                    $texto = explode(" ",$body);
                    $archivo = fopen("palabras/". $archivo,"r");
                    while(!feof($archivo) && $estado==0){
                        $cadena = fgets($archivo);
                        $cadena1 = trim($cadena);
                        foreach($texto as $palabra){
                            $palabra1=trim($palabra);
                            if($cadena1==$palabra1){
                                $nombre1 = rtrim($nombre,".txt");
                                require('config/db.php');
                                $especialidad = mysqli_query($conn,"SELECT ID_ESPECIALIDAD FROM especialidad WHERE NOMBRE_ESPECIALIDAD = '$nombre1'");
                                $clave=mysqli_fetch_array($especialidad) ;
                                mysqli_close($conn);
                                require('config/db.php');
                                $especialistas = mysqli_query($conn, "SELECT ID_USUARIO FROM usuario WHERE ID_ESPECIALIDAD = '$clave[0]'");
                                $cantidad_cartas = 0 ;
                                $usuario_asignado  ;
                                while($usuarios=mysqli_fetch_array($especialistas)){ 
                                    $usuario_actual=$usuarios[0] ;
                                    $cartas = mysqli_query($conn, "SELECT COUNT(ID_USUARIO) FROM carta_recivida WHERE ID_USUARIO = '$usuario_actual'");
                                    $numero_cartas = mysqli_fetch_array($cartas);
                                    $num_cartas = $numero_cartas[0];
                                    if($cantidad_cartas == 0){$cantidad_cartas = $num_cartas ;}
                                    if($cantidad_cartas >= $num_cartas){
                                        $cantidad_cartas = $num_cartas;
                                        $usuario_asignado = $usuario_actual;
                                    }
                                
                                }
                                mysqli_close($conn);
                                require('config/db.php');
                                $fichero = "emojis/". $id. ".png";
                                $archivo_objetivo1=fopen($fichero,"r");
                                $contenido1=fread($archivo_objetivo1, filesize($fichero)); 
                                $contenido1=addslashes($contenido1);
                                fclose($archivo_objetivo1);
                                $query = "INSERT INTO carta_recivida (ID_USUARIO, TEXTO_CARTA, FECHA_RECEPCION, IMAGEN_AVATAR) VALUES('$usuario_asignado','$body', '$fecha', '$contenido1')";
                                $estado = 1 ;
                                if(mysqli_query($conn, $query)){
                                    
                                    echo'<script type="text/javascript">
                                    alert("Carta Enviada");
                                    window.location.href="index.php";
                                    </script>';
                                } else {
                                    echo 'ERROR: '. mysqli_error($conn);
                                      }
                                mysqli_close($conn);
                                }
                            }
                    }  
                    }
                }
    
            }
            
                 
            
        }
                 
                

               
 }
?>



<?php include('inc/header.php'); ?>


    <div class="contenedor">
	<script type="text/javascript">
		function abrir(){
			alert('Su carta ha sido enviada con exito :)');
		}
	</script>
        <div class="alert alert-danger" role="alert">
			<div class="icono-advertencia">
				<img src="images/icono-advertencia.png" style="height: 100px; width: 100px;">
			</div>
            <h4><strong>RECUERDA AMIGUITO! Tu seguridad es muy importante para nosotros. Por favor no utilices tus nombres o apellidos, el nombre de tu escuela, el lugar donde vives, el nombre de tus padres o numero de telefono.</strong></h4>
		</div>
		    <a href="<?php echo ROOT_URL; ?>" role = "button" style="float:left; margin:10px;">
            <img src="images/boton_volver.gif" class="img-fluid" alt="Responsive image" id="btn-back"  style = 'width:150px; height:50px;'>
		    </a> 
         <div  style="float:right">
            <p class="cartasParrafo"><strong>Escoje un pesonaje</strong></p>
            <a class="btn btn-info btn-lg" href="<?php echo ROOT_URL; ?>avatares.php" role="button" id = "iconos">
            <img class="imgCarta" src="emojis/<?php extract($_GET);echo $id;?>.png" class="img-fluid" alt="Responsive image">
           	</a>
         </div>
      
        <h1 align="center"><Strong>¡Cuentanos cómo estas!</Strong></h1>
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
			<div class="form-group" align="center">
				<textarea name="TEXTO_CARTA" class="form-control" style = 'width:750px; height:350px;'></textarea><br>
			
				<input type="file" name="imagen" id="imagen" size="20" class="btn btn-info"> 
			
				<input type="submit" name="submit" id="enviar" value="Enviar carta" class="btn">
            </div>	
        </form>		
    </div>	

