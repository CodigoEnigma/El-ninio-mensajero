<nav class="navbar navbar-inverse navbar-dark bg-dark">
    <div class="container">
        <div class="navbar-header">
        <?php if(isset($_SESSION['roll'])): ?>
            <?php if($_SESSION['roll'] == 'administrador'): ?>
                <a class="navbar-brand" href="<?php echo ROOT_URL; ?>Administrar.php"><h1>EL NIÑO MENSAJERO</h1></a>
            <?php else: ?>
                <a class="navbar-brand" href="<?php echo ROOT_URL; ?>"><h1>EL NIÑO MENSAJERO</h1></a>
            <?php endif; ?>
        <?php else: ?>
                <a class="navbar-brand" href="<?php echo ROOT_URL; ?>"><h1>EL NIÑO MENSAJERO</h1></a>
        <?php endif; ?>
        </div>
        <!--div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="nav-item"><a class="nav-link" href="?php echo ROOT_URL; ?>login.php">Iniciar sesion</a></li>
            </ul>
        </div-->
        <div>
            
            <?php if(isset($_SESSION['roll'])): ?>
                <?php if($_SESSION['roll'] == 'administrador'): ?>
                    <a class="btn btn-primary" href="<?php echo ROOT_URL; ?>registrar_usuario.php" role="button" id = "registrar">Registrar usuario</a>

                    <a class="btn btn-primary" href="<?php echo ROOT_URL; ?>administrar_tipos.php" role="button" id ="crearEspecialidad">Administrar Especialidad</a>
                    

                    <button class="btn btn-primary" onclick="cerrarSesion()">Cerrar sesion</button>
                <?php elseif ($_SESSION['roll'] == 'usuario'): ?>
                    <button class="btn btn-primary" onclick="cerrarSesion()">Cerrar sesion</button>
                <?php endif; ?>
            <?php else: ?>
                <a class="btn btn-primary" href="<?php echo ROOT_URL; ?>login.php" role="button" id = "login">Iniciar sesion</a>
            <?php endif; ?>

            <script>
                function cerrarSesion() {
                    window.location='unset.php';
                    
                }
            </script>
        </div>
    </div>
</nav>
