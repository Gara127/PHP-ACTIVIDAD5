<html>
	<head>
		<title> CREAR GRUPO </title>
	</head>
	<body>
        <?php
            require_once("lib/nusoap.php");
            $client = new soapclient('http://localhost/Actividad06/servidor.php?wsdl');

            if(isset($_POST["nombre"])){
                $nombre = $_POST["nombre"];
            }
        
            if(isset($_POST["id_genero"])){
                $genero = $_POST["id_genero"];
            }

            if(empty($genero) || empty($nombre)) {
                echo "<h3 style='color: red;'> Faltan campos por rellenar en el formulario. </h3>";
            } else {
                // Llama a la función add_grupo con los parámetros obtenidos del formulario
		        $client->add_grupo($nombre, $genero);
                echo "<h3 style='color: green;'> Grupo creado con éxito. </h3>";
            }
        ?>
        <br><hr>
		<form action="cliente.php" method="post">
			<input type="submit" value="Volver">
		</form>
	</body>
</html>