<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <?php
	require('config/config.php');
    include('inc/header.php'); ?>
    
    <div class="container">
        <div >
           <br>
            <a href="<?php echo ROOT_URL; ?>" role = "button" style="float:left; margin:10px;">
			 <img src="images/boton_volver.gif" class="img-fluid" alt="Responsive image" id="btn-back"  style = 'width:150px; height:50px;'>
            </a> 
            <h2><strong>Escoge un personaje</strong></h2>
            <table border='1'>
                <tr  class='success'>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=Agente%20coulson"><img class='imgCarta' src='emojis/Agente%20coulson.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=Airon%20man"><img class='imgCarta' src='emojis/Airon%20man.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=Anna"><img class='imgCarta' src='emojis/Anna.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=Betty"><img class='imgCarta' src='emojis/Betty.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=Black%20widow"><img class='imgCarta' src='emojis/Black%20widow.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=Blanca%20Nieves"><img class='imgCarta' src='emojis/Blanca%20Nieves.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                </tr>
                <tr  class='success'>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=Capitan%20america"><img class='imgCarta' src='emojis/Capitan%20america.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=Cenicienta"><img class='imgCarta' src='emojis/Cenicienta.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=Elena"><img class='imgCarta' src='emojis/Elena.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=Elsa"><img class='imgCarta' src='emojis/Elsa.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=Genio"><img class='imgCarta' src='emojis/Genio.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=Giant%20man"><img class='imgCarta' src='emojis/Giant%20man.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                </tr>
                <tr  class='success'>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=Hawkeye"><img class='imgCarta' src='emojis/Hawkeye.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=Hector"><img class='imgCarta' src='emojis/Hector.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=Hulk"><img class='imgCarta' src='emojis/Hulk.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=La%20bella"><img class='imgCarta' src='emojis/La%20bella.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=La%20Bestia"><img class='imgCarta' src='emojis/La%20Bestia.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=Loki"><img class='imgCarta' src='emojis/Loki.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                </tr>
                 <tr  class='success'>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=Mulan"><img class='imgCarta' src='emojis/Mulan.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=Nick%20fury"><img class='imgCarta' src='emojis/Nick%20fury.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=Pocahontas"><img class='imgCarta' src='emojis/Pocahontas.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=Thor"><img class='imgCarta' src='emojis/Thor.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=Valiente"><img class='imgCarta' src='emojis/Valiente.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                    <td>
                        <a href="<?php echo ROOT_URL; ?>carta.php?id=Vanellope"><img class='imgCarta' src='emojis/Vanellope.png' class='img-sluid' alt='Responsive image' style = 'width:120px; height:120px;'></a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    
</body>
</html>