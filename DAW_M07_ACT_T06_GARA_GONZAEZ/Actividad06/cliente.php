<html>
	<head>
		<title> INICIO </title>
	</head>
	<body>
		<?php
			require_once("lib/nusoap.php");
			$client = new soapclient('http://localhost/Actividad06/servidor.php?wsdl');

			echo "<h3>GRUPOS DE MÚSICA</h3>";

			$generos = $client->devolver_generos();
			
			if(count($generos) == 0){
				echo "<h3 style='color: red;'> No se han encontrado géneros </h3>";
			} else {
				echo "<form method='post' action='crearGrupo.php'>
				Nombre del grupo: <input type='text' name='nombre'><br>
				Genero: <select name='id_genero'>";
				foreach ($generos as $genero) {
					echo "<option value='$genero->id_genero'>$genero->nombre</option>";
				}
				echo "</select><br>
				<input type='submit' name='btn_crear_grupo' value='Crear'></form>";
				echo "<hr></br>";                
			}

			echo "<h3>GÉNEROS MUSICALES</h3>";
			echo "<p>Elige de la lista el género del que deseas consultar grupos: <p>";
			echo "<form method='post' action='devolverGrupos.php'>
			<table border='1'>
			<tr><td>GENERO</td><td>ELIGE</td></tr>";
			foreach ($generos as $genero) {
				echo "<tr>";
				echo "<td>{$genero->nombre}</td>
				<input type='hidden' name='nombre' value='$genero->nombre'>";
				echo "<td><input type='radio' name='id_genero' value='$genero->id_genero'></td>";
				echo "</tr>";
			}
			echo "<tr><td colspan='2'><input type='submit' name='btn_devolver_genero' value='Selecciona'/></td></tr>";
			echo "</table></form>";
		?>
	</body>
</html>
