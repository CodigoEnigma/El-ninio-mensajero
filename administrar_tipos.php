<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
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
    
	
	require('config/db.php');
	
    //$query = "SELECT * FROM especialidad";
	//$resultado = mysqli_query($conn , $query) ;
   // $tipos = mysqli_fetch_array($resultado, MYSQL_ASSOC);
    include('inc/header.php');?>
   
   <div class="contenedor" >
        <a href="<?php echo ROOT_URL; ?>Administrar.php" role = "button" style="float:left; margin:10px;">
            <img src="images/boton_volver.gif" class="img-fluid" alt="Responsive image" id="btn-back"  style = 'width:150px; height:50px;'>
        </a> 
    </div>
    <div style="float:right">
                <a class="btn btn-primary" href="<?php echo ROOT_URL; ?>crearEspecialidad.php" role="button" id ="crearEspecialidad" style="margin:20px;">Crear Especialidad</a>
            </div>
	
	<br>
		<table border='1'; class='table table-dark'>
		    <tr class='warning'>
				<td>ID</td>
				<td>Especialidad</td>
				<td>Leer cartas</td>
				<td>Responder cartas</td>
				<td>Derivar cartas</td>
				<td>Postular cartas a boletin</td>
				<td>Editar</td>
				<td>Eliminar</td>
			</tr>
			<?php
            $query = "SELECT * FROM especialidad";
	        $resultado = mysqli_query($conn , $query) ;
           
            while($arreglo = mysqli_fetch_array($resultado, MYSQL_ASSOC)){
                if($arreglo['NOMBRE_ESPECIALIDAD'] != "Administrador" && $arreglo['NOMBRE_ESPECIALIDAD'] != "Editor Boletin" && $arreglo['NOMBRE_ESPECIALIDAD'] != "Lector"){
                    echo "<tr class ='success' >" ;
                echo "<td >". $arreglo['ID_ESPECIALIDAD']. "</td>";
                echo "<td >". $arreglo['NOMBRE_ESPECIALIDAD']. "</td>" ;
                
                $leer = $arreglo['LEER'] ;
                if(!isset($leer) || $leer == 'no'){
                    echo "   <td align='center'><img class='imgCarta' src='images/no.png' class='img-sluid' alt='Responsive image' style ='width:50px; height:50px;'></td>" ;
                }else {
                     echo "   <td align='center'><img class='imgCarta' src='images/leido.png' class='img-sluid' alt='Responsive image' style ='width:50px; height:50px;'></td>" ;
                    
                }
                
                 $responder = $arreglo['RESPONDER'] ;
                 if(!isset($responder) || $responder == 'no'){
                      echo "   <td align='center'><img class='imgCarta' src='images/no.png' class='img-sluid' alt='Responsive image' style ='width:50px; height:50px;'></td>" ;
                 }else{
                      echo "   <td align='center'><img class='imgCarta' src='images/leido.png' class='img-sluid' alt='Responsive image' style ='width:50px; height:50px;'></td>" ;
                 }
                
                 
                 $derivar = $arreglo['DERIVAR'] ;
                 if(!isset($derivar) || $derivar == 'no'){
                     echo "   <td align='center'><img class='imgCarta' src='images/no.png' class='img-sluid' alt='Responsive image' style ='width:50px; height:50px;'></td>" ;
                 }else{
                      echo "   <td align='center'><img class='imgCarta' src='images/leido.png' class='img-sluid' alt='Responsive image' style ='width:50px; height:50px;'></td>" ;
                 }
                
                 $postular = $arreglo['POSTULAR'] ;
                 if(!isset($postular) || $postular == 'no'){
                     echo "   <td align='center'><img class='imgCarta' src='images/no.png' class='img-sluid' alt='Responsive image' style ='width:50px; height:50px;'></td>" ;
                 }else{
                      echo "   <td align='center'><img class='imgCarta' src='images/leido.png' class='img-sluid' alt='Responsive image' style ='width:50px; height:50px;'></td>" ;
                 }
                
                echo "<td><a href='". ROOT_URL ."actualiza_datos_tipo_user.php?id=".$arreglo['ID_ESPECIALIDAD']."'><img class='imgCarta' src='images/ICONO_ACTUALIZAR.png' class='img-sluid' alt='Responsive image' style = 'width:50px; height:50px;'></td>";

				echo "<td><a href='". ROOT_URL ."administrar_tipos.php?id=".$arreglo['ID_ESPECIALIDAD']."&idborrar=2'><img class='imgCarta' src='images/ICONO_ELIMINAR.png' class='img-sluid' alt='Responsive image' style = 'width:50px; height:50px;'></td>";	
	
                echo "</tr>" ;
                }
            }
            	extract($_GET);
            ?>
            </table>
            
		<div class="modal" id="myModal" role="dialog">
        <div class="modal-dialog">
    
          <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Esta seguro de que quiere eliminar la especialidad: 
           <?php  
              require('config/db.php');
		      $query=mysqli_query($conn,"SELECT * FROM especialidad WHERE ID_ESPECIALIDAD = '$id'");
              $res = mysqli_fetch_array($query,MYSQL_ASSOC);
               mysqli_close($conn);
              echo $res['NOMBRE_ESPECIALIDAD'];
              ?></h4>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
        <form method="post">
        <button type="submit" class="btn btn-success btn-primary" name = "aceptar">Aceptar</button>
          
        <?php 	
        
        if(isset($_POST["aceptar"])){
        require('config/db.php');
		$sqlborrar="DELETE FROM especialidad WHERE ID_ESPECIALIDAD='$id'";
        $resborrar=mysqli_query($conn,$sqlborrar);
        if($resborrar){
               $carpeta_destino=$_SERVER['DOCUMENT_ROOT'].'/palabras/';
               unlink($carpeta_destino.$res['NOMBRE_ESPECIALIDAD'].".txt");//MENEJO DE RUTAS
                echo '<script type="text/javascript">
                                    alert("LA ESPECIALIDAD FUE ELIMINADAD CORRECTAMENTE");
                                    window.location.href="'. ROOT_URL .'administrar_tipos.php";
                                    </script>';
              
             
        }else{
              echo '<script type="text/javascript">
                                    alert("LA ESPECIALIDAD NO FUE ELIMINADA. ASEGURECE DE QUE NO TENGA USUARIOS REGISTRADOS");
                                    window.location.href="'. ROOT_URL .'administrar_tipos.php";
                                    </script>';
              
        }}	 
        ?>
        </form>
        <button type="button" class="btn btn-success btn-primary" data-dismiss="modal">Cancelar</button>

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
		
		
</body>
</html>