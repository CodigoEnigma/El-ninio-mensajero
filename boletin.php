<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>El niño mensajero</title>
</head>
<body>
   <?php 
   
    include('inc/header.php'); 
     require('config/config.php');
  require('config/db.php');


     ?>
	<div class="container">
		<a href="<?php echo ROOT_URL; ?>lista_boletin.php" role = "button" style="float:left; margin:10px;">
			 <img src="images/boton_volver.gif" class="img-fluid" alt="Responsive image" id="btn-back"  style = 'width:150px; height:50px;'>
        </a> 
 </div>
        <br><br>
		
		<br><br>

	
<div align="center">
    <h1 align="center"><strong>Boletín</strong></h1>    
	<div class="estilo_boletin"style = 'width:750px; height:350px;'align="center">
		<div class="card">
  <div class="card-body">
    <?php  
    
		extract($_GET);

     $query = "SELECT * FROM boletin WHERE ID_BOLETIN = '$id'";
     $resultado = $conn->query($query);

      if ($resultado->num_rows > 0) {
          while ($row = $resultado -> fetch_assoc()) {
            echo $row["TEXTO_BOLETIN"];
                        # code...
          }
      }
    

    ?>
  </div>
</div></div>
  </div>
  <br>



  <!--PAGINACION LA VARIABLE NUMERO DE CARTAS DEBERIA DE OBTENERSE DE TODAS LAS CARTAS QUE TENGAMOS DIVIDIDA ENTRE LA 
  CANTIDAD DE CARTAS QUE QUISIERAMOS QUE SE MUESTRE EN CADA "PAGINA"  -->
  
 
  
</body>
</html>