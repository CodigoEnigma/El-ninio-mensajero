<?php
	require('config/config.php');
	require('config/db.php');
?>

<?php include('inc/header.php'); ?>
	<div class="container">
		<div class="text-center">
			<p></p>
        	<h1>Carta del niño</h1>
			<p></p>
			<br>
        
		<div class="card" style="height: 330px;width:1110px; >
  		<img src="..." class="card-img-top" alt="...">
 		 <div class="card-body">
   		 <h5 class="card-title">CARTA</h5>
  		  <p class="card-text">Por este conducto, me permito manifestar que mi gremio de artesanos del estado de Hidalgo, quiere formar parte de esta asociación, teniendo la intención formal de ingresar a la asociación de artesanos de México S.C. y formar parte de esta asociación y así contribuir con nuestras aportaciones y recibir los beneficioss que esta asociación nos obsequia.

			Esperamos recibir de esta gran asociación la capacitación para el comercio, la fabricación y la adquisición de materiales, que nos son necesarios para realizar las artesanías.

		Esperamos cumplir todos los requisitos que nos sean establecidos y formar parte de esta asociación en el mejor tiempo.

Yo  Francisco Terreros Zapata, como representante de los artesanos del estado de Hidalgo he sido seleccionado como representante legal y mandaré los documentos necesarios para entrar en la asociación y traer en un momento dado los propios productos.

Agradeciendo su atención le reiteramos nuestros respetos.</p>
		  </div>
      <br>
		</div>

    <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
      <div class="form-group">
        <textarea name="TEXTO_CARTA" class="form-control" style="height: 20rem;"></textarea><br>
        <a href="<?php echo ROOT_URL; ?>OpcionesCarta.php" class="btn btn-primary">REGRESAR</a>
        <input type="submit" name="submit" value="ANEXAR" class="btn btn-primary">
      </div>
    	</div>
	</div>