<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>El niño mensajero</title>
</head>
<body>
    <?php
    
    require('config/config.php');
    include('inc/header.php'); 
    ?>
    
     <a href="<?php echo ROOT_URL; ?>" role = "button" style="float:left; margin:10px;">
                <img src="images/boton_volver.gif" class="img-fluid" alt="Responsive image" id="btn-back"  style = 'width:150px; height:50px;'> </a>
    
    <br><br><br>
    <h2 style="text-align:center"><strong>Boletines disponibles</strong></h2>
        <table border="1"; class="table table-dark" style="margin-left: auto;margin-right: auto;max-width:70%">
			<tr class='warning'>
                <td>Fecha de creacion</td>
				<td>Leer Carta</td>
             </tr>
             
          <?php
            require('config/db.php');
            $query = mysqli_query($conn,"SELECT * FROM boletin");
             while($arreglo = mysqli_fetch_array($query, MYSQL_ASSOC)){
                echo "<tr class='success'>";
                echo "<td>".$arreglo['FECHA_CREACION']."</td>";
                
                 echo "<div style='float:center'>
                    <td align='center'><a href=".ROOT_URL."boletin.php?id=". $arreglo['ID_BOLETIN']. "><img class='imgCarta' src='images/leer.png' class='img-sluid' alt='Responsive image' style ='width:50px; height:50px;'></td>
                    </div>";
                 echo "</tr>";
             
             }
             mysqli_close($conn);
            ?>   
             
             
             
        </table>
    
    
    
    
</body>
</html>