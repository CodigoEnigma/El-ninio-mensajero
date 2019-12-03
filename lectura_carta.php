<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>El niño mensajero</title>
    <style>
    
        body{
  background-color: #f0f0f0;
}

.burbuja{
  background: #fff;
  float: left;
  position: static;
  padding: 20px;
  color: #222;
  border-radius: 3px;
  margin-left: 20px;
  width: 755px;
  border: 1px solid black;
  border-radius: 1px 40px 40px 40px;
  margin-bottom: 5px;
}
.burbujaRespuesta{
  float: left;
  position: static;
  background: #fff;
  padding: 20px;
  color: #222;
  border-radius: 3px;
  margin-left: 145px;
  width: 850px;
  border: 1px solid black;
  border-radius: 1px 40px 40px 40px;
  margin-bottom: 30px;
  margin-top: 10px;
}

.imagen{
  display: inline;
  align-content: center;
}
        
    </style>
</head>
<body>
    <?php
     require('config/config.php');
    session_start();
    if(!isset($_COOKIE)){
		header('Location: '.ROOT_URL.'');
	}else{
        $nombre = $_COOKIE['nombreUsuario'];
        $id = $_COOKIE['id_usuario'];
        $rol = $_COOKIE['roll'];
    } 
    
    include('inc/header.php');
    extract($_GET);
	require('config/db.php');
	$query = 'SELECT * FROM carta_recivida where ID_CARTA_RECIVIDA='.$id.'';
	$result = mysqli_query($conn, $query);
	$carta = mysqli_fetch_array($result, MYSQL_ASSOC);
    $query1 = "UPDATE `carta_recivida` SET `LEIDA` = 'si' WHERE `carta_recivida`.`ID_CARTA_RECIVIDA` = '$id'";
    $result1 = mysqli_query($conn, $query1);
    $permisos= "SELECT * FROM especialidad WHERE ID_ESPECIALIDAD ='$rol' ";
    $perm = mysqli_query($conn, $permisos) ;
    $permisos_obtenidos = mysqli_fetch_array($perm, MYSQL_ASSOC);
    $leer = $permisos_obtenidos['LEER'];
    $responder = $permisos_obtenidos['RESPONDER'];
    $postular = $permisos_obtenidos['POSTULAR'];
    $derivar= $permisos_obtenidos['DERIVAR'];
	mysqli_close($conn);
    $estado = $carta['POSTULACION_BOLETIN'];
    ?>
    
    <div class="contenedor" >
        <a href="<?php echo ROOT_URL; ?>VentanaUsuario.php" role = "button" style="float:left; margin:10px;">
            <img src="images/boton_volver.gif" class="img-fluid" alt="Responsive image" id="btn-back"  style = 'width:150px; height:50px;'>
        </a> 
  </div>
  <br><br><br><br>
  
   <div>
  
       <?php if($leer=='si'):?>
              
              
              <div class="imagenCarta" style="float:left">			
			    <img src="data:image/png;base64,<?php echo base64_encode($carta['IMAGEN_AVATAR']) ?>" height="100" width="100">				
                </div>
              
                <div class="burbuja">
            <h5><strong>Enviado</strong></h5>
            <?php
            echo $_SERVER['DOCUMENT_ROOT'];
            
           
            echo "<br>".$carta['TEXTO_CARTA'];
            echo "<br><br>".$carta['FECHA_RECEPCION'];
            $imagen = $carta['IMAGEN'];
                                    if(!is_null($imagen)){
                                        echo "<div align='center'>" ;
                                        echo "<h5><strong>Imagen adjuntada a la carta</strong></h5>" ;
                                        echo "<img src='data:image/jpeg;base64,". base64_encode($imagen)."' height='125' width='125'>" ;
                                        echo "</div>" ;
                                    }
            
            ?>

        </div>
        
              
         <?php endif;?> 
     <br><br>
     <?php if($responder =='si'):?>
                <br><br><br>
                <div style="float:left; margin:40px;">
                    <h4 align="center"><strong>Responder a la carta</strong></h4>
                <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
			        <div class="form-group" align="center">
				        <textarea name="TEXTO_CARTA" class="form-control" style = 'width:750px; height:350px;'></textarea><br>
				        <input type="submit" name="submit" id="enviar" value="Responder" class="btn">
                    </div>	
                </form>		 
                </div>		    
                <?php endif;?>
    
    <?php if($postular =='si'):?>
           <div  style="float:right; margin:30px; ">
                  
                    <?php if(!isset($estado) || $estado == "no") : ?>
                      
                    <form method="POST" action="<?php echo ROOT_URL; ?>lectura_carta.php?id=<?php echo $id?>" enctype="multipart/form-data">
			        <div class="form-group" align="center">
				        <h5><strong>Postular a Boletin</strong></h5>
				        <input type="submit" name="si" id="postular" value="SI" class="btn btn-success btn-primary">
                    </div>	
                    </form>	 
                            
                    <?php elseif($estado == "si"):?>
                            
                    <form method="POST" action="<?php echo ROOT_URL; ?>lectura_carta.php?id=<?php echo $id?>" enctype="multipart/form-data">
			        <div class="form-group" align="center">
				        <h5><strong>Dejar de Postular a Boletin</strong></h5>
				        <input type="submit" name="no" id="dejarpostular" value="SI" class="btn btn-success btn-primary" style="'width:70px; height:25px">
                    </div>	
                    </form>	    
                           
                    <?php endif ; ?>
            </div>	           
			  <?php endif;?>   
 <?php if($derivar == 'si'):?>
    
     <div  style="float:right">
            <p class="cartasParrafo"><strong>Asignar Carta</strong></p>
            <a class="btn btn-info btn-lg" href="<?php echo ROOT_URL; ?>derivar_carta.php?id=<?php echo $id; ?>" role="button" id = "iconos">
            <img class="imgCarta" src="images/reasignacion.png" class="img-fluid" alt="Responsive image">
           	</a>
         </div>
    <?php endif ;?> 
                 
   </div>
    
			  
			  
		 	  
			  
			  	 <?php
    
     if(isset($_POST['no'])){
            require('config/db.php');
             $consulta1 =  "UPDATE `carta_recivida` SET `POSTULACION_BOLETIN` = 'no' WHERE `carta_recivida`.`ID_CARTA_RECIVIDA` = '$id'" ;
            $cambio = mysqli_query($conn, $consulta1) ;
             mysqli_close($conn);
            echo'<script type="text/javascript">
                                    alert("Postulacion a boletin ¡CANCELADA!");
                                    window.location.href="'.ROOT_URL.'VentanaUsuario.php";
                                    </script>';
           
        }
    
        if(isset($_POST['si'])){
            require('config/db.php');
             $consulta1 =  "UPDATE `carta_recivida` SET `POSTULACION_BOLETIN` = 'si' WHERE `carta_recivida`.`ID_CARTA_RECIVIDA` = '$id'" ;
            $cambio = mysqli_query($conn, $consulta1) ;
             mysqli_close($conn);
             echo'<script type="text/javascript">
                                    alert("Postulado a boletin. ¡EXITOSA!");
                                    window.location.href="'.ROOT_URL.'VentanaUsuario.php";
                                    </script>';
           
        }
            
    ?>
    
    <?php
    
        if(isset($_POST['submit'])){
		$body = $_POST['TEXTO_CARTA'];
        require('config/db.php');
        $consulta ="UPDATE `carta_recivida` SET `RESPUESTA` = '$body' WHERE `carta_recivida`.`ID_CARTA_RECIVIDA` = '$id'" ;
        $resultado = mysqli_query($conn, $consulta);
        if($resultado){
                                   echo'<script type="text/javascript">
                                    alert("Respuesta Enviada");
                                    window.location.href="VentanaUsuario.php";
                                    </script>';
            echo "actualizado" ;
                                 } else {
                                     echo 'ERROR: '. mysqli_error($conn);}
                                 mysqli_close($conn);

    }
    
    
    ?>
			  
			  
   
</body>
</html>