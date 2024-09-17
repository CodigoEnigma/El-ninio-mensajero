
<?php
	require('config/config.php');
   

    if(isset($_POST['submit'])){
		$body = $_POST['TEXTO_CARTA'];
		if($body != ""){
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
                     
                        move_uploaded_file($_FILES['imagen']['tmp_name'],$_SERVER['DOCUMENT_ROOT']."/temporal/".$nombre_imagen);
                        //echo "exito";

                 
            $carpeta_destino=$_SERVER['DOCUMENT_ROOT'].'/palabras/';
            $directorio = opendir($carpeta_destino) ; //directorio de donde se abren los archivos txt
            $estado=0;
            while($archivo=readdir($directorio) ){
                if($estado==0){
                    if(!is_dir($archivo)){
                    $nombre = $archivo ;
                    extract($_GET) ;
                    $texto = explode(" ",$body);
                    $archivo = fopen($carpeta_destino. $archivo,"r");//DIRECCIONEES
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
                                $cantidad_cartas = null;
                                $usuario_asignado  ;
                                while($usuarios=mysqli_fetch_array($especialistas)){ 
                                    $usuario_actual=$usuarios[0] ;
                                    $cartas = mysqli_query($conn, "SELECT COUNT(ID_USUARIO) FROM carta_recivida WHERE ID_USUARIO = '$usuario_actual'");
                                    $numero_cartas = mysqli_fetch_array($cartas);
                                    $num_cartas = $numero_cartas[0];
                                    if($cantidad_cartas == null && $num_cartas == 0){
                                            $cantidad_cartas = $num_cartas ;
                                            $usuario_asignado = $usuario_actual ;
                                        }
                                    if($cantidad_cartas == null && $num_cartas != 0){
                                             $cantidad_cartas = $num_cartas ;
                                            $usuario_asignado = $usuario_actual ;
                                        }
                                    if($cantidad_cartas >= $num_cartas){
                                                $cantidad_cartas = $num_cartas;
                                                $usuario_asignado = $usuario_actual;
                                        }
                                
                                }
                                mysqli_close($conn);
                                $archivo_objetivo=fopen($_SERVER['DOCUMENT_ROOT']."/temporal/".$nombre_imagen,"r");//directorio
                                $contenido=fread($archivo_objetivo,$tamanio_imagen); 
                                $contenido=addslashes($contenido);
                                fclose($archivo_objetivo);
                                
                                $fichero =$_SERVER['DOCUMENT_ROOT'] ."/emojis/". $id. ".png";//url
                                $archivo_objetivo1=fopen($fichero,"r");
                                $contenido1=fread($archivo_objetivo1, filesize($fichero)); 
                                $contenido1=addslashes($contenido1);
                                fclose($archivo_objetivo1);
                                
                                extract($_GET) ;
                                require('config/db.php');
                                $query = "INSERT INTO carta_recivida (ID_USUARIO, TEXTO_CARTA, FECHA_RECEPCION, IMAGEN, IMAGEN_AVATAR) VALUES('$usuario_asignado','$body', '$fecha', '$contenido','$contenido1')";
                                $estado = 1;
                                if(mysqli_query($conn, $query)){
                                    echo'<script type="text/javascript">
                                    alert("Tu cartita fue enviada con éxito");
                                    window.location.href="'. ROOT_URL .'index.php";
                                    </script>';
                                 } else {
                                     echo 'ERROR: '. mysqli_error($conn);}
                                 mysqli_close($conn);


                                 unlink($_SERVER['DOCUMENT_ROOT']."/temporal/".$nombre_imagen);//url
                                }
                            }//fin foreacg
                    } //fin while 
                    }
                }
    
            }
            if($estado == 0){
                require('config/db.php');
                $especialistas = mysqli_query($conn, "SELECT ID_USUARIO FROM usuario WHERE ID_ESPECIALIDAD = 'Lect'");
                $cantidad_cartas = null ;
                $usuario_asignado  ;
                while($usuarios=mysqli_fetch_array($especialistas)){ 
                        $usuario_actual=$usuarios[0] ;
                        $cartas = mysqli_query($conn, "SELECT COUNT(ID_USUARIO) FROM carta_recivida WHERE ID_USUARIO = '$usuario_actual'");
                        $numero_cartas = mysqli_fetch_array($cartas);
                        $num_cartas = $numero_cartas[0];
                        if($cantidad_cartas == null && $num_cartas == 0){
                        $cantidad_cartas = $num_cartas ;
                        $usuario_asignado = $usuario_actual ;
                        }
                        if($cantidad_cartas == null && $num_cartas != 0){
                             $cantidad_cartas = $num_cartas ;
                            $usuario_asignado = $usuario_actual ;
                        }
                        //if($cantidad_cartas != 0 && $num_cartas >= 0){
                          //  $cantidad_cartas = $num_cartas ;
                            //$usuario_asignado = $usuario_actual ;
                        //}
                        if($cantidad_cartas >= $num_cartas){
                                $cantidad_cartas = $num_cartas;
                                $usuario_asignado = $usuario_actual;
                        }
                        }
                        mysqli_close($conn);
                        $archivo_objetivo=fopen($_SERVER['DOCUMENT_ROOT']."/temporal/".$nombre_imagen,"r");//uurl
                        $contenido=fread($archivo_objetivo,$tamanio_imagen); 
                        $contenido=addslashes($contenido);
                        fclose($archivo_objetivo);
                                
                        $fichero = $_SERVER['DOCUMENT_ROOT']."/emojis/". $id. ".png";
                        $archivo_objetivo1=fopen($fichero,"r");//url
                        $contenido1=fread($archivo_objetivo1, filesize($fichero)); 
                        $contenido1=addslashes($contenido1);
                        fclose($archivo_objetivo1);
                                
                        extract($_GET) ;
                        require('config/db.php');
                        $query = "INSERT INTO carta_recivida (ID_USUARIO, TEXTO_CARTA, FECHA_RECEPCION, IMAGEN, IMAGEN_AVATAR) VALUES('$usuario_asignado','$body', '$fecha', '$contenido','$contenido1')";
                        $estado = 1 ;
                        if(mysqli_query($conn, $query)){
                                    echo'<script type="text/javascript">
                                    alert("Tu cartita fue enviada con éxito");
                                    window.location.href="'. ROOT_URL .'index.php";
                                    </script>';
                            } else {echo 'ERROR: '. mysqli_error($conn);}
                        mysqli_close($conn);
                        unlink($_SERVER['DOCUMENT_ROOT']."/temporal/".$nombre_imagen);//url

            }
             }else{
                    echo'<script type="text/javascript">
                                    alert("Solo se puden añadir imagenes a la cartita");
                                    window.location.href="'. ROOT_URL .'carta.php?id=chico";
                                    </script>';
                } //else {echo "Solo se pueden subir imagenes" ;} 
            } //else {echo "tamaño muy grande de la imagen" ;}
            
     }else{
            $carpeta_destino=$_SERVER['DOCUMENT_ROOT'].'/palabras/';
            $directorio = opendir($carpeta_destino) ;//url
            $estado=0;
            while($archivo=readdir($directorio) ){
                if($estado==0){
                    if(!is_dir($archivo)){
                    $nombre = $archivo ;
                    extract($_GET) ;
                    $texto = explode(" ",$body);
                    $archivo = fopen($carpeta_destino. $archivo,"r");//url
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
                                $cantidad_cartas = null;
                                $usuario_asignado  ;
                                while($usuarios=mysqli_fetch_array($especialistas)){ 
                                    $usuario_actual=$usuarios[0] ;
                                    $cartas = mysqli_query($conn, "SELECT COUNT(ID_USUARIO) FROM carta_recivida WHERE ID_USUARIO = '$usuario_actual'");
                                    $numero_cartas = mysqli_fetch_array($cartas);
                                    $num_cartas = $numero_cartas[0];
                                    if($cantidad_cartas == null && $num_cartas == 0){
                                        $cantidad_cartas = $num_cartas ;
                                        $usuario_asignado = $usuario_actual ;
                                    }
                                    if($cantidad_cartas == null && $num_cartas != 0){
                                         $cantidad_cartas = $num_cartas ;
                                        $usuario_asignado = $usuario_actual ;
                                    }
                                    if($cantidad_cartas >= $num_cartas){
                                            $cantidad_cartas = $num_cartas;
                                            $usuario_asignado = $usuario_actual;
                                    }
                                
                                }
                                mysqli_close($conn);
                                require('config/db.php');
                                $fichero = $_SERVER['DOCUMENT_ROOT']."/emojis/". $id. ".png";
                                $archivo_objetivo1=fopen($fichero,"r");//url
                                $contenido1=fread($archivo_objetivo1, filesize($fichero)); 
                                $contenido1=addslashes($contenido1);
                                fclose($archivo_objetivo1);
                                $query = "INSERT INTO carta_recivida (ID_USUARIO, TEXTO_CARTA, FECHA_RECEPCION, IMAGEN_AVATAR) VALUES('$usuario_asignado','$body', '$fecha', '$contenido1')";
                                $estado = 1 ;
                                if(mysqli_query($conn, $query)){
                                    
                                    echo'<script type="text/javascript">
                                    alert("Tu cartita fue enviada con éxito");
                                    window.location.href="'.ROOT_URL.'index.php";
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
    
            }//fin de mientras hayan archivos
            
                 
            if($estado == 0){
               require('config/db.php');
               $especialistas = mysqli_query($conn, "SELECT ID_USUARIO FROM usuario WHERE ID_ESPECIALIDAD = 'Lect'");
               $cantidad_cartas = null;
               $usuario_asignado  ;
               while($usuarios=mysqli_fetch_array($especialistas)){ 
                    $usuario_actual=$usuarios[0] ;
                    $cartas = mysqli_query($conn, "SELECT COUNT(ID_USUARIO) FROM carta_recivida WHERE ID_USUARIO = '$usuario_actual'");
                    $numero_cartas = mysqli_fetch_array($cartas);
                    $num_cartas = $numero_cartas[0];
                    if($cantidad_cartas == null && $num_cartas == 0){
                        $cantidad_cartas = $num_cartas ;
                        $usuario_asignado = $usuario_actual ;
                    }
                    if($cantidad_cartas == null && $num_cartas != 0){
                         $cantidad_cartas = $num_cartas ;
                        $usuario_asignado = $usuario_actual ;
                    }
                    if($cantidad_cartas >= $num_cartas){
                            $cantidad_cartas = $num_cartas;
                            $usuario_asignado = $usuario_actual;
                    }
                                
                }
                mysqli_close($conn);
                require('config/db.php');
                $fichero = $_SERVER['DOCUMENT_ROOT']."/emojis/". $id. ".png";//url
                $archivo_objetivo1=fopen($fichero,"r");
                $contenido1=fread($archivo_objetivo1, filesize($fichero)); 
                $contenido1=addslashes($contenido1);
                fclose($archivo_objetivo1);
                $query = "INSERT INTO carta_recivida (ID_USUARIO, TEXTO_CARTA, FECHA_RECEPCION, IMAGEN_AVATAR) VALUES('$usuario_asignado','$body', '$fecha', '$contenido1')";
                $estado = 1 ;
                if(mysqli_query($conn, $query)){
                                    
                       echo'<script type="text/javascript">
                            alert("Tu cartita fue enviada con éxito");
                            window.location.href="'.ROOT_URL.'index.php";
                            </script>';
                    } else {echo 'ERROR: '. mysqli_error($conn);}
                mysqli_close($conn);
            }
        }
        }else {
            
                          
                       echo'<script type="text/javascript">
                            alert("Texto vacio, cartita no enviada");
                            window.location.href="'.ROOT_URL.'index.php";
                            </script>';
            
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
		    
         <div  style="float:right">
            <p class="cartasParrafo"><strong><?php extract($_GET);echo $id;?></strong></p>
            <a class="btn btn-info btn-lg"  role="button" id = "iconos">
            <img class="imgCarta" src="emojis/<?php extract($_GET);echo $id;?>.png" class="img-fluid" alt="Responsive image">
           	</a>
         </div>
      
            
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
			<div class="form-group" align="center">
			    <h2><strong>Cuentanos tus aventuras</strong></h2>
				<textarea name="TEXTO_CARTA" class="form-control" style = 'width:750px; height:350px;'></textarea><br>
			
				<input type="file" name="imagen" id="imagen" size="20" class="btn btn-info"> 
			
				<input type="submit" name="submit" id="enviar" value="Enviar carta" class="btn">
               <a class="btn btn-primary" href="<?php echo ROOT_URL; ?>" role="button" id ="crearEspecialidad" style="margin:20px;">Cancelar envio de carta</a>
            </div>	
        </form>		
    </div>	

