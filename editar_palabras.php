<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>El niño mensajero</title>
    
    <style>
    
    #div1 {
     overflow:scroll;
     height:200px;
     width:700px;
    margin: 0 auto;
    }
    #div1 table {
        
        width:700px;
        background-color:lightgray;
    }
        
    </style>
    
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
   
   
   
    <?php 
       
include('inc/header.php'); 
 extract($_GET);
?>  


   
    <a href="<?php echo ROOT_URL; ?>actualiza_datos_tipo_user.php?id=<?php echo $id; ?>" role = "button" style="float:left; margin:10px;">
			 <img src="images/boton_volver.gif" class="img-fluid" alt="Responsive image" id="btn-back"  style = 'width:150px; height:50px;'>
            </a> 

              
    <div class="cabeceraSesion">
                    <h2>AÑADIR O ELIMINAR PALABRAS CLAVE</h2>
                </div>
                <form class="login" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                    <div class="input-group">
                        <label>Escribe la palabra clave</label>
                        <input type="text" name="palabra" placeholder="Escribe un palabra"> 
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" name="añadir">Añadir palabra</button>
                    <br>
                    <button type="submit" class="btn btn-primary btn-block" name="eliminar">Eliminar palabra</button>
                    <br>
                </form>
               <br>
                   
   
   
   <?php 
    
    $query = "SELECT * FROM especialidad WHERE ID_ESPECIALIDAD='$id'" ;
    require('config/db.php');
    $cons = mysqli_query($conn, $query);
    $valores = mysqli_fetch_array($cons, MYSQL_ASSOC);
    $nombre_especialidad = $valores['NOMBRE_ESPECIALIDAD'];
    mysqli_close($conn);

    $carpeta_destino=$_SERVER['DOCUMENT_ROOT'].'/palabras/'.$nombre_especialidad.".txt";//DIRECTORIO
    $archivo = fopen("$carpeta_destino","r") or die ("PROBLEMAS AL ABRIR EL ARCHIVO TXT") ;
    echo '<div id="div1" style ="float: center">' ;
    echo '<table border="1">';
    $tamaño_tabla = 0 ;
        while(!feof($archivo)){
            $traer = fgets($archivo);
            //$salto_de_linea = nl2br($traer); reconoce caracteres de salto de linea
            $hola =trim($traer) ;
                
             if($hola != ""){
                  if($tamaño_tabla == 0){
                    echo" <tr>";
                    echo "<td>".$traer."</td>";
                    $tamaño_tabla = $tamaño_tabla +1 ;
                }else if($tamaño_tabla != 0 && $tamaño_tabla !=6){
                        echo "<td>".$traer."</td>";
                        $tamaño_tabla = $tamaño_tabla +1 ;
                    }else if ($tamaño_tabla == 6){
                            echo "<td>".$traer."</td>";
                            echo" </tr>";
                            $tamaño_tabla = $tamaño_tabla +1 ;
                        }
                }   
        }
    echo "</table>";
    echo "</div>";
    fclose($archivo);
    if(isset($_POST['añadir'])){
        $existe = 0 ;
        $texto = fopen("$carpeta_destino","a+") or die ("problemas");
         while(!feof($texto) && $existe == 0){
             $cadena = fgets($texto);
             $cadena1 = trim($cadena);
             if($cadena1 == $_POST['palabra']){
                 $existe = 1 ;
             }
         }
        if($existe == 0){
            fwrite($texto, "\n");
            fwrite($texto,$_POST['palabra']);
            fclose($texto);
            echo'<script type="text/javascript">
                                        alert("PALABRA AÑADIDA CON EXITO A LA ESPECIALIDAD:'.$nombre_especialidad.' ");
                                        window.location.href="'. ROOT_URL .'editar_palabras.php?id='.$id.'";
                                        </script>';    
        }else{
            echo'<script type="text/javascript">
                                    alert("ESTA PALABRA YA ES PALABRA CLAVE DE:'.$nombre_especialidad.' ");
                                    window.location.href="'. ROOT_URL .'editar_palabras.php?id='.$id.'";
                                    </script>';
        }
        

        
    }
    
    if(isset($_POST['eliminar'])){
        $estado = 0;
        rename("$carpeta_destino",$_SERVER['DOCUMENT_ROOT'].'/palabras/cambio.txt');//DIRECTORIO
        $text = fopen($_SERVER['DOCUMENT_ROOT'].'/palabras/cambio.txt', "r");//DIRECTORIO
        $texto1 = fopen("$carpeta_destino","a") or die ("problemas");
        while(!feof($text)){
               $cadena = fgets($text);
                $cadena1 = trim($cadena);
            if($cadena1 != $_POST['palabra']){ 
                fwrite($texto1,$cadena1);
                fwrite($texto1, "\n");
            }else{
                $estado = 1;
            }
        }
        fclose ($text);
        unlink($_SERVER['DOCUMENT_ROOT'].'/palabras/cambio.txt');
        if($estado == 1){
            echo'<script type="text/javascript">
                                    alert("PALABRA ELIMINADA CON EXITO");
                                    window.location.href="'. ROOT_URL .'editar_palabras.php?id='.$id.'";
                                    </script>';
        }else{
             echo'<script type="text/javascript">
                                    alert("ESTA PALABRA NO SE ENCUENTRA ENTRE LAS PALABRAS CLAVE ");
                                    window.location.href="'. ROOT_URL .'editar_palabras.php?id='.$id.'";
                                    </script>';
        }
        //$archivo =  fopen("$carpeta_destino","a") or die ("problemas");
        //$borrado = 0 ;}
        
    }
    
    ?>


</body>
</html>