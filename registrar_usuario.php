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

      $numeros = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

      if(!isset($_COOKIE)){
        header('Location: '.ROOT_URL.'');
      } else {
        if($_COOKIE['roll'] == 'administrador'){
          //$queryEspec = 'SELECT * FROM especialidad';
          //$resultEspec = mysqli_query($conn,$queryEspec);
          //$especs = mysqli_fetch_all($resultEspec, MYSQLI_ASSOC);

          if (isset($_POST['registrar'])) {
            $ciR = mysqli_real_escape_string($conn, $_POST['ci']);
            $ciAdmin = mysqli_real_escape_string($conn, $_SESSION['ci']);
            $tipoR = mysqli_real_escape_string($conn, $_POST['especialidad']);
            $nombreR = mysqli_real_escape_string($conn, $_POST['nombre']);
            $apellidoR = mysqli_real_escape_string($conn, $_POST['apellido']);
            $emailR = mysqli_real_escape_string($conn, $_POST['email']);
            $passR1 = mysqli_real_escape_string($conn, $_POST['password_1']);
            $passR2 = mysqli_real_escape_string($conn, $_POST['password_2']);

            if(!empty($ciR) &&!empty($nombreR) && !empty($apellidoR) && !empty($tipoR) && !empty($emailR) && !empty($passR1) && !empty($passR2)){

              if (filter_var($ciR, FILTER_VALIDATE_INT)) {
                if(strlen($ciR) >= 5 && strlen($ciR) <= 10){
                  $aux = $ciR;
                  $auxArray = array();
                  while ($aux != 0) {
                    $auxArray[] = $aux % 10;
                    $aux = intval($aux/10);
                  }
                  if (count(array_unique($auxArray)) == 1) {
                    $errorCiR = "La cédula de identidad proporcionada tiene una secuencia improbable o tiene un caracter invalido.";
                  }
                } else {
                  $errorCiR = "La cédula de identidad debe tener entre 5 y 10 numeros.";
                }
              } else {
                $errorCiR = "La cédula de identidad solo permite numeros.";
              }

              if (!filter_var($nombreR, FILTER_VALIDATE_EMAIL)) {
                if(!filter_var($nombreR, FILTER_VALIDATE_URL)){
                  if(strlen($nombreR) < 1 && strlen($nombreR) > 15){
                    $errorNombreR = "El nombre no puede tener mas de 15 caracteres.";
                  } else {
                    for ($i=0; $i < strlen($nombreR); $i++) { 
                      for ($j=0; $j < count($numeros); $j++) { 
                        if ($nombreR[$i] == $numeros[$j]) {
                          $errorNombreR = "El nombre no puede contener números.";
                        }
                      }
                    }
                  }
                } else {
                  $errorNombreR = "No se permite ese tipo de contenido.";
                }
              } else {
                $errorNombreR = "No se permite ese tipo de contenido.";
              }

              if (!filter_var($apellidoR, FILTER_VALIDATE_EMAIL)) {
                if(!filter_var($apellidoR, FILTER_VALIDATE_URL)){
                  if(strlen($apellidoR) < 1 && strlen($apellidoR) > 15){
                    $errorApellidoR = "El apellido no puede tener mas de 15 caracteres.";
                  } else {
                    for ($i=0; $i < strlen($apellidoR); $i++) { 
                      for ($j=0; $j < count($numeros); $j++) { 
                        if ($apellidoR[$i] == $numeros[$j]) {
                          $errorApellidoR = "El nombre no puede contener números.";
                        }
                      }
                    }
                  }
                } else {
                  $errorApellidoR = "No se permite ese tipo de contenido.";
                }
              } else {
                $errorApellidoR = "No se permite ese tipo de contenido.";
              }

              if (!filter_var($passR1, FILTER_VALIDATE_EMAIL)) {
                if(!filter_var($passR1, FILTER_VALIDATE_URL)){
                  if(strlen($passR1) < 8 || strlen($passR1) > 15){
                    $errorPassR1 = "Introduzca un valor entre 8 y 15 caracteres.";
                  }
                } else {
                  $errorPassR1 = "No se permite ese tipo de contenido.";
                }
              } else {
                $errorPassR1 = "No se permite ese tipo de contenido.";
              }

              if ($passR2 != $passR1) {
                $errorPassR2 = "Las contraseñas no coinciden.";
              }

              if (empty($errorCiR) && empty($errorNombreR) && empty($errorApellidoR) && empty($errorPassR1) && empty($errorPassR2)) {

                $queryDupA = "SELECT * FROM administrador WHERE ID_ADMINISTRADOR='$ciR'";
                $duplicadoA = mysqli_query($conn,$queryDupA);
                //$duplicadoA = mysqli_fetch_array($resultDupA);

                $queryDupU = "SELECT * FROM usuario WHERE ID_USUARIO='$ciR'";
                $duplicadoU = mysqli_query($conn,$queryDupU);
                //$duplicadoU = mysqli_fetch_array($resultDupU);

                if (!mysqli_num_rows($duplicadoU) && !mysqli_num_rows($duplicadoA)) {

                  $pass_cifrada=password_hash($passR1, PASSWORD_DEFAULT);

                  $queryEspecNom = "SELECT NOMBRE_ESPECIALIDAD FROM especialidad WHERE ID_ESPECIALIDAD = '$tipoR'";
                  $resultEspecNom = mysqli_query($conn,$queryEspecNom);
                  $especNomArray = mysqli_fetch_row($resultEspecNom);
                  $especNom = mysqli_real_escape_string($conn, $especNomArray[0]);

                  if ($tipoR == "Admin") {
                    $queryReg = "INSERT INTO administrador(ID_ADMINISTRADOR, NOMBRE_ADMINISTRADOR, APELLIDOS_ADMINISTRADOR, CORREO_ADMINISTRADOR, CONTRASENIA_ADMIN) VALUES('$ciR', '$nombreR', '$apellidoR', '$emailR', '$pass_cifrada')";
                  } else {
                    $queryReg = "INSERT INTO usuario(ID_USUARIO, ID_ADMINISTRADOR, ID_ESPECIALIDAD, NOMBRE_USUARIO, APELLIDOS_USUARIO, CORREO_USUARIO, CONTRASENIA_USUARIO, ESPECIALIDAD_USUARIO) VALUES('$ciR', '$ciAdmin', '$tipoR', '$nombreR', '$apellidoR', '$emailR', '$pass_cifrada', '$especNom')";
                  }

                  if (mysqli_query($conn,$queryReg)) {
                    mysqli_close($conn);

                     echo '<script type="text/javascript">
                                    alert("EL USUARIO FUE REGISTRADO CORRECTAMENTE");
                                    window.location.href="'. ROOT_URL .'Administrar.php";
                                    </script>';
                  } else {
                    mysqli_close($conn);
                     echo '<script type="text/javascript">
                                    alert("");
                                    window.location.href="'. ROOT_URL .'Administrar.php";
                                    </script>';
                    $errorR = "No se pudo realizar el registro. Intente de nuevo.";
                  }

                } else {
                  mysqli_close($conn);
                  $errorR = "Este usuario ya esta registrado.";
                }
              }

            }

          }
        } else{
          header('Location: '.ROOT_URL.'login.php');
        }
      }
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
     <div class="input-group">
      <label>Nombre*</label>
      <input type="text" name="nombre" value="<?php if(isset($nombreR)) echo $nombreR?>" required>
      <small style = "font-size:11px; color:#cc0000; margin-top:10px"><?php if(isset($errorNombreR)) echo $errorNombreR ?></small>
    </div>
    <div class="input-group">
      <label>Apellido*</label>
      <input type="text" name="apellido" value="<?php if(isset($apellidoR)) echo $apellidoR?>" required>
      <small style = "font-size:11px; color:#cc0000; margin-top:10px"><?php if(isset($errorApellidoR)) echo $errorApellidoR ?></small>
    </div>
    
    
    
    <div class="input-group">
      <select name="especialidad" required>
        <option value="">Elige una opción</option> 
        
           
          <?php require('config/db.php');
                $query=mysqli_query($conn,"SELECT * FROM especialidad");
                while($especialidad= mysqli_fetch_array($query,MYSQL_ASSOC)){
                    echo '<option value="'.$especialidad['ID_ESPECIALIDAD'].'">'. $especialidad['NOMBRE_ESPECIALIDAD'].'</option>' ;
                }
               mysqli_close($conn);
                ?>    
                 
        
      </select> 
    </div>
    
    
    
    
    <div class="input-group">
      <label>Email*</label>
      <input type="email" name="email" value="<?php if(isset($emailR)) echo $emailR?>" required>
    </div>
    <div class="input-group">
      <label>Contraseña*</label>
      <input type="password" name="password_1" required>
      <small style = "font-size:11px; color:#cc0000; margin-top:10px"><?php if(isset($errorPassR1)) echo $errorPassR1?></small>
    </div>
    <div class="input-group">
      <label>Confirmar Contraseña*</label>
      <input type="password" name="password_2" required>
      <small style = "font-size:11px; color:#cc0000; margin-top:10px"><?php if(isset($errorPassR2)) echo $errorPassR2?></small>
    </div>
     <label>Los campos marcados con <strong>*</strong> son campos obligatorios</label>
     <div>
      <a href="<?php echo ROOT_URL; ?>Administrar.php" class="btn btn-primary btn-block"  name="cancelar">Cancelar </a> 
     </div>
     <br>
     <div>
        <button type="submit" class="btn btn-primary btn-block" name="registrar" >Registrar</button>
     </div>
      
     
   
  </form>
  
</body>
</html>