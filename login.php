<?php
	require('config/config.php');
    require('config/db.php');
    if(!isset($_COOKIE)){
        header('Location: '.ROOT_URL.'');
      } else {
    if(isset($_POST['submit'])){
        $ci = mysqli_real_escape_string($conn, $_POST['ci']);
        $pass = mysqli_real_escape_string($conn, $_POST['pass']);

        if (!empty($ci)) {
            if (filter_var($ci, FILTER_VALIDATE_INT)) {
                if (strlen($ci) > 10) {
                    $errorCi = "La cédula de identidad es demasiado larga.";
                }
        
                if (strlen($ci) < 5) {
                    $errorCi = "La cédula de identidad es demasiado corta.";
                }
            } else {
                $errorCi = "Verifique que la cédula de identidad contenga solamente números.";
            }
        }

        if (!empty($pass)) {
            if (!filter_var($pass, FILTER_VALIDATE_EMAIL)) {
                if(!filter_var($pass, FILTER_VALIDATE_URL)){
                    if(strlen($pass) > 15){
                        $errorPass = "La contraseña es demasiado larga.";
                    }
                    if(strlen($pass) < 8){
                        $errorPass = "La contraseña es demasiado corta.";
                    }
                } else {
                    $errorPass = "Valor invalido.";
                }
            } else {
                $errorPass = "Valor invalido.";
            } 
        }

        if (empty($errorCi) && empty($errorPass)) {
            $queryAdmin = "SELECT CONTRASENIA_ADMIN FROM administrador WHERE ID_ADMINISTRADOR ='$ci'";
            $resultAdmin = mysqli_query($conn, $queryAdmin);
            $arrayCount = mysqli_fetch_row($resultAdmin);
            $count = $arrayCount[0];
            if(strlen($count) == 0){
                $queryUsr = "SELECT CONTRASENIA_USUARIO FROM usuario WHERE ID_USUARIO ='$ci'";
                $resultUsr = mysqli_query($conn, $queryUsr);
                $clave = mysqli_fetch_row($resultUsr);
                $claveLista = $clave[0];
                
                $queryNomUsr = "SELECT NOMBRE_USUARIO FROM usuario WHERE ID_USUARIO ='$ci'";
                $resultNomUsr = mysqli_query($conn, $queryNomUsr);
                $nombre = mysqli_fetch_row($resultNomUsr);
                $nombreListo = $nombre[0];
                
                $queryEsp = "SELECT ID_ESPECIALIDAD FROM usuario WHERE ID_USUARIO ='$ci'";
                $resulEsp = mysqli_query($conn, $queryEsp);
                $esp = mysqli_fetch_row($resulEsp);
                $id_esp = $esp[0];
                
                } else {
                    $claveLista = $count;
                    $queryNomAdmin = "SELECT NOMBRE_ADMINISTRADOR FROM administrador WHERE ID_ADMINISTRADOR ='$ci'";
                    $resultNomAdmin = mysqli_query($conn, $queryNomAdmin);
                    $nombre = mysqli_fetch_row($resultNomAdmin);
                    $nombreListo = $nombre[0];
                }
            
                if(password_verify($pass, $claveLista)) {
                    mysqli_close($conn);
                    session_start();

                    $_SESSION['ci'] = $ci;
                    $_SESSION['nombre'] = $nombreListo;
                    if (strlen($count) == 0) {
                        $_SESSION['roll'] = 'usuario';
                        if($id_esp == 'Edit'){
                            setcookie('nombreUsuario', $_SESSION['nombre']);
                            setcookie('roll', $id_esp);
                            setcookie('id_usuario', $ci);
                            header('Location: '.ROOT_URL.'editor_boletin.php'); // AQUI VIENE EL NOMBRE DE LA VENTANA DEL EDITOR DE BOLETIN
                            }else{
                                setcookie('nombreUsuario', $_SESSION['nombre']);
                                setcookie('roll', $id_esp);
                                setcookie('id_usuario', $ci);
                                header('Location: '.ROOT_URL.'VentanaUsuario.php');
                            }

                        } else {
                            $_SESSION['roll'] = 'administrador';
                            setcookie('nombreUsuario', $_SESSION['nombre']);
                            setcookie('roll', $_SESSION['roll']);
                             setcookie('id_usuario', $ci);
                            header('Location: '.ROOT_URL.'Administrar.php');
                        }
                
                } else {
                    $error = "Contraseña incorrecta. Intente de nuevo.";
                }
        }

    }
}
?>
<?php include('inc/header.php'); ?>

    <div class="container">
        <a href="<?php echo ROOT_URL; ?>" role = "button" style="float:left; margin:10px;">
			 <img src="images/boton_volver.gif" class="img-fluid" alt="Responsive image" id="btn-back"  style = 'width:150px; height:50px;'>
		  </a> 
         <br> 
        
        <div class="cabeceraSesion">
        	<h2>INICIAR SESION</h2>
        </div>
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" class="login">
            <div class="input-group">
                <label>Usuario</label>
                <input type="text" name="ci" placeholder="Cédula de identidad" value="<?php if(isset($ci)) echo $ci?>" required autofocus>
                <!--small id="emailHelp" class="form-text text-muted">No se compartira su información.</small-->
                <small style = "font-size:11px; color:#cc0000; margin-top:10px"><?php if(isset($errorCi)) echo $errorCi ?></small>
            </div>
            <div class="input-group">
                <label>Contraseña</label>
                <input type="password" placeholder="Contraseña" name="pass" required>
                <!--small id="emailHelp" class="form-text text-muted">No comparta su contraseña.</small-->
                <small style = "font-size:11px; color:#cc0000; margin-top:10px"><?php if(isset($errorPass)) echo $errorPass ?></small>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block" name="submit">INGRESAR</button>
            <p style = "font-size:11px; color:#cc0000; margin-top:10px"><?php if(isset($error)) echo $error ?></p>
         
        </form>
    </div> 
