<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Animalear BD</title>
	</head>
	<body>
		<?php
			//realizamos la conexión con mysql
			$con = mysqli_connect('localhost', 'root', '', 'bd_botiga_animals');

			//como la sentencia SIEMPRE va a buscar todos los registros de la tabla tbl_anunci, pongo en la variable $sql.
			$sql = "SELECT * FROM tbl_anunci,tbl_contacte WHERE tbl_anunci.contact_id=tbl_contacte.contact_id";
			
				if(!empty($_REQUEST['municipio'])){
					$sql.=" AND tbl_anunci.mun_id=$_REQUEST[municipio]"; //Añadimos la busqueda del municipio

				} else {
					// no añadimos municipio a la busqueda para que busque todos
				}
				if(empty($_REQUEST['perros']) && empty($_REQUEST['gatos']) && empty($_REQUEST['pajaros']) && empty($_REQUEST['otros'])){
					if(!empty($_REQUEST['opcion'])){
						if($_REQUEST['opcion']==1){
							$sql.=" AND raca_id BETWEEN 8 AND 14";
						} else if ($_REQUEST['opcion']==2){
							$sql.=" AND raca_id BETWEEN 15 AND 19";
						} else if ($_REQUEST['opcion']==3){
							$sql.=" AND raca_id BETWEEN 20 AND 21";
						} else {
							$sql.=" AND raca_id BETWEEN 22 AND 26";
						}
					} else {
						// no añadimos animal a la busqueda para que busque todos
					}
				} else if (!empty($_REQUEST['perros'])){
					$sql.=" AND raca_id=$_REQUEST[perros]";
				} else if (!empty($_REQUEST['gatos'])){
					$sql.=" AND raca_id=$_REQUEST[gatos]";
				} else if (!empty($_REQUEST['pajaros'])){
					$sql.=" AND raca_id=$_REQUEST[pajaros]";
				} else {
					$sql.=" AND raca_id=$_REQUEST[otros]";
				}
			//lanzamos la sentencia sql
			$datos = mysqli_query($con, $sql);
			
			if(mysqli_num_rows($datos)>0){ // vemos si hay resultados o no en la busqueda realizada, si hay realizamos el muestreo de los datos
				
				while($anuncio = mysqli_fetch_array($datos)){
					echo "<b>Anuncio:</b> $anuncio[anu_contingut]<br/>";
					echo "<b>Fecha anuncio:</b> $anuncio[anu_data]<br/>";
					echo "<b>Estado:</b> $anuncio[anu_tipus]<br/>";
					echo "<b>Nombre de contacto:</b> $anuncio[contact_nom]<br/>";
					echo "<b>Teléfono de contacto:</b> $anuncio[contact_telf]<br/>";
					if(!empty($anuncio['anu_foto'])){
						$fichero="img/$anuncio[anu_foto]";
						if(file_exists($fichero)){
							//en el caso que la imagen exista, la muestra por pantalla
							echo "<img src='$fichero'><br/>";
						} else {
							echo "<img src='img/no_disponible.jpg'><br/>"; //mostramos una imagen de 'imagen no disponible' en el caso que no exista el fichero en la ubicación
						}
					} else {
							//si la imagen del producto no existe, cargaremos una imagen de 'imagen no disponible'
							echo "<img src='img/no_disponible.jpg'><br/>";
					}
				}
			} else { // si no hay datos en la busqueda mostramos por pantalla que no hay resultados en la busqueda realizada
				echo "No hay resultados";
			}
			//cerramos la conexión con la base de datos
			mysqli_close($con);
		?>
	</body>
</html>