<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>El niño mensajero</title>
</head>
<body>
    <?php
	require('config/config.php');
  require('config/db.php');

  session_start();
   include('inc/header.php');
    
    ?>
 <a href="<?php echo ROOT_URL; ?>Administrar.php" role = "button" style="float:left; margin:10px;">
			 <img src="images/boton_volver.gif" class="img-fluid" alt="Responsive image" id="btn-back"  style = 'width:150px; height:50px;'>
            </a> 
            
  <div class="cabecera">
    <h1>REGISTRAR USUARIO</h1>
  </div>
  
  <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" class="registrar">
  
  <small style = "font-size:11px; color:#cc0000; margin-top:10px"><?php if(isset($errorR)) echo $errorR?></small>
    
     <div class="input-group">
      <label>Cédula de identidad*</label>
      <input type="text" name="ci" value="<?php if(isset($ciR)) echo $ciR?>" required autofocus>
      <small style = "font-size:11px; color:#cc0000; margin-top:10px"><?php if(isset($errorCiR)) echo $errorCiR ?></small>
    </div>
   
  </form>
  <?php
    
    
    ?>
  
</body>
</html>