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
    if(!isset($_COOKIE)){
		header('Location: '.ROOT_URL.'');
	} else {
		if($_COOKIE['roll'] != 'administrador'){
			header('Location: '.ROOT_URL.'');
		}
	}
	
?>
<?php include('inc/header.php'); ?>
        <div class="container">
                <a href="<?php echo ROOT_URL; ?>administrar_tipos.php" role = "button" style="float:left; margin:10px;">

                    <img src="images/boton_volver.gif" class="img-fluid" alt="Responsive image" id="btn-back"  style = 'width:150px; height:50px;'>

                </a> <br> 
                
                <div class="cabeceraSesion">
                    <h2>CREAR ESPECIALIDAD</h2>
                </div>
                <form class="login" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                    <div class="input-group">
                        <label>Especialidad *</label>
                        <input type="text" name="especialidad" placeholder="Indroduzca nueva especialidad">
                        
                    </div>
                    <label><strong>*Permisos:</strong> Puede selecionar uno o mas permisos</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="leerCartas" value="1">
                            <label class="form-check-label">
                                Leer cartas
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="responderCartas" value="2" >
                            <label class="form-check-label" >
                                Responder cartas
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="derivarCartas" value="3">
                            <label class="form-check-label" >
                                Derivar cartas
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="postularCartas" value="4">
                            <label class="form-check-label" >
                                Postular cartas para boletin
                            </label>
                        </div>
                        <div class="input-group">
                            <label>*Agrega un archivo .txt con las palabras clave</label>
                            <input type="file" name="texto" id="texto" class="btn btn-info" style="height: 40px;"> 
                        </div>
                        <div>
                          <a href="<?php echo ROOT_URL; ?>administrar_tipos.php" class="btn btn-primary btn-block"  name="cancelar">Cancelar </a> 
                          <br>
                     </div>
                    
                    <button type="submit" class="btn btn-primary btn-block" name="crear_especialidad">Crear especialidad</button>
                    <br>
                    <label>Los campos marcados con <strong>*</strong> son campos obligatorios</label>
                </form>
        </div> 
        
        <?php 
    
        if(isset($_POST['crear_especialidad'])){
            
            if(isset($_POST['especialidad'])){
                $nombre = trim($_POST['especialidad']);
                $nombre_esp = substr($nombre,0,4);//substring
            }
            
            if(isset($_POST['leerCartas'])){
                $leer= 'si';    
            }else{
                $leer = 'no';
            }
            
            if(isset($_POST['responderCartas'])){
                $responder= 'si';
            }else{
                $responder= 'no';
            }
            
            if(isset($_POST['derivarCartas'])){
                $derivar = 'si';    
            }else{
                $derivar = 'no';
            }
            
            if(isset($_POST['postularCartas'])){
                 $postular= 'si';
            }else{
                $postular = 'no';
            }
            
            require('config/db.php');
            $verificacion_nombre = "SELECT * FROM especialidad WHERE NOMBRE_ESPECIALIDAD='$nombre'";
            
            $resultado= mysqli_query($conn, $verificacion_nombre);
         //  $mostrar = mysqli_fetch_array($resultado);
              // echo "esa especialidad ya existe";
            $arreglo = mysqli_fetch_array($resultado, MYSQL_ASSOC);
             
            if($arreglo['NOMBRE_ESPECIALIDAD'] != null){
                echo "ESTA ESPECIALIDA YA EXISTE" ;
            }else{
                
                $nombre_texto = $_FILES['texto']['name'];
    	        $tipo_texto=$_FILES['texto']['type'];
		        $tamanio_texto=$_FILES['texto']['size'];
                
                if($tamanio_texto != 0){
                    if($tipo_texto=="text/plain"){ 
                         $carpeta_destino=
                         $carpeta_destino=$_SERVER['DOCUMENT_ROOT'].'/palabras/'; //DIRECTORIO
                         move_uploaded_file($_FILES['texto']['tmp_name'],$carpeta_destino.$nombre.".txt");//MANEJO DE RUTAS
                         
                           
                         $query = "INSERT INTO especialidad (ID_ESPECIALIDAD, NOMBRE_ESPECIALIDAD, LEER, RESPONDER, DERIVAR, POSTULAR) VALUES('$nombre_esp','$nombre', '$leer', '$responder', '$derivar', '$postular')";
                         if( mysqli_query($conn, $query)){
                                 echo'<script type="text/javascript">
                                                alert("La especialidad fue registrada con exito");
                                                window.location.href="'.ROOT_URL.'administrar_tipos.php";
                                                </script>';
                         }else{echo 'ERROR: '. mysqli_error($conn);}
                     } else {echo'<script type="text/javascript">
                                                alert("Solo se pueden subir archivos de texto .txt");
                                                window.location.href="'.ROOT_URL.'crearEspecialidad.php";
                                                </script>'; }    
                }else{
                    echo'<script type="text/javascript">
                                                alert("Selecione un archivo de texto .txt");
                                                window.location.href="'.ROOT_URL.'crearEspecialidad.php";
                                                </script>';
                }
               
                
            mysqli_close($conn);}
            
            //$query = "INSERT INTO carta_recivida (ID_USUARIO, TEXTO_CARTA, FECHA_RECEPCION, IMAGEN_AVATAR) VALUES('$usuario_asignado','$body', '$fecha', '$contenido1')";
        }
            
    ?>
</body>
</html>