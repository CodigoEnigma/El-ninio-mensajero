
       

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
       
       
       <?php 
        
include('inc/header.php'); 
 extract($_GET);
$query = "SELECT * FROM especialidad WHERE ID_ESPECIALIDAD='$id'" ;
require('config/db.php');
$cons = mysqli_query($conn, $query);
$valores = mysqli_fetch_array($cons, MYSQL_ASSOC);
$nombre_especialidad = $valores['NOMBRE_ESPECIALIDAD'];
$leer = $valores['LEER'];
$responder  = $valores['RESPONDER'];
$derivar = $valores['DERIVAR'];
$postular =  $valores['POSTULAR'];
$nombre = $valores['NOMBRE_ESPECIALIDAD'] ;
mysqli_close($conn);
?>  
   
   
   
   
   
<?php
$carpeta_destino=$_SERVER['DOCUMENT_ROOT'].'/palabras/';
     if(isset($_POST['actualizar_especialidad'])){
         if(isset($_POST['actualizar_especialidad'])){
            
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
             
            if($arreglo['NOMBRE_ESPECIALIDAD'] != null && $nombre != $nombre_especialidad){
                 echo'<script type="text/javascript">
                             alert("Ya existe una especialidad con el nombre '.$nombre.'");
                             window.location.href="'.ROOT_URL.'administrar_tipos.php";
                             </script>';
            }else{
                    if($nombre != $nombre_especialidad){
                        rename($carpeta_destino.$nombre_especialidad.".txt",$carpeta_destino.$nombre.".txt");
                    }
                    $query = "UPDATE `especialidad` SET `ID_ESPECIALIDAD` = '$id', `NOMBRE_ESPECIALIDAD` = '$nombre', `LEER` = '$leer', `RESPONDER` = '$responder', `DERIVAR` = '$derivar', `POSTULAR` = '$postular' WHERE `especialidad`.`ID_ESPECIALIDAD` = '$id'";
                    if( mysqli_query($conn, $query)){
                        
                        echo'<script type="text/javascript">
                             alert("Actualizacion exitosa");
                             window.location.href="'.ROOT_URL.'administrar_tipos.php";
                             </script>';
                                
                         }else{echo 'ERROR: '. mysqli_error($conn);}
                    
                    
                }
               
                
            mysqli_close($conn);}
     }
?>



    
<div class="container"> 
   
    <a href="<?php echo ROOT_URL; ?>administrar_tipos.php" role = "button" style="float:left; margin:10px;">
			 <img src="images/boton_volver.gif" class="img-fluid" alt="Responsive image" id="btn-back"  style = 'width:150px; height:50px;'>
            </a> 
   </div>
 <div class="cabeceraSesion">
                    <h2>EDITAR ESPECIALIDAD</h2>
                </div>
                <form class="login" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                    <div class="input-group">
                        <label>Especialidad *</label>
                        <input type="text" name="especialidad" placeholder="Indroduzca nueva especialidad" value="<?php echo $nombre;?>" >
                        
                    </div>
                    <label><strong>*Permisos:</strong> Puede selecionar uno o mas permisos</label>
                       <?php if($leer == 'si'):?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="leerCartas" value="1" checked >
                            <label class="form-check-label">
                                Leer cartas
                            </label>
                        </div>
                        <?php else :?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="leerCartas" value="1" >
                            <label class="form-check-label">
                                Leer cartas
                            </label>
                        </div>
                        <?php endif;?>
                        <?php if($responder == 'si'):?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="responderCartas" value="2" checked>
                            <label class="form-check-label" >
                                Responder cartas
                            </label>
                        </div>
                        <?php else:?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="responderCartas" value="2">
                            <label class="form-check-label" >
                                Responder cartas
                            </label>
                        </div>
                        <?php endif;?>
                        <?php if($derivar== 'si'):?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="derivarCartas" value="3" checked>
                            <label class="form-check-label" >
                                Derivar cartas
                            </label>
                        </div>
                        <?php else :?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="derivarCartas" value="3">
                            <label class="form-check-label" >
                                Derivar cartas
                            </label>
                        </div>
                        <?php endif;?>
                        <?php if($postular== 'si'):?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="postularCartas" value="4" checked>
                            <label class="form-check-label" >
                                Postular cartas para boletin
                            </label>
                        </div>
                        <?php else: ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="postularCartas" value="4">
                            <label class="form-check-label" >
                                Postular cartas para boletin
                            </label>
                        </div>
                        <?php endif;?>
                        <br>
                        <label>Los campos marcados con <strong>*</strong> son campos obligatorios</label>
                        <div>
                          <a href="<?php echo ROOT_URL; ?>editar_palabras.php?id=<?php echo $id; ?>" class="btn btn-primary btn-block"  name="cancelar">Añadir o eliminar palabras clave </a> 
                          <br>
                        </div>
                    <button type="submit" class="btn btn-primary btn-block" name="actualizar_especialidad">Actualizar</button>
                    <br>
                    <div>
                          <a href="<?php echo ROOT_URL; ?>administrar_tipos.php" class="btn btn-primary btn-block"  name="cancelar">Cancelar </a> 
                          <br>
                     </div>
                </form>
        
    