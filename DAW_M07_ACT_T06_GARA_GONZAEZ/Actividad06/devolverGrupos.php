<html>
	<head>
		<title> LISTA DE GRUPOS </title>
	</head>
	<body>
        <?php
            require_once("lib/nusoap.php");
            $client = new soapclient('http://localhost/Actividad06/servidor.php?wsdl');

            if(isset($_POST["id_genero"])){
                $id_genero = $_POST["id_genero"];
            }

            if(isset($_POST["nombre"])){
                $nombre = $_POST["nombre"];
            }

            if(empty($id_genero) || empty($nombre)) {
                echo "<h3 style='color: red;'> Faltan campos por rellenar en el formulario. </h3>";
            } else {
                echo "<h3 style='color: blue;'> Se han encontrado los siguientes grupos del género '$nombre'. </h3>";
                $grupos = $client->devolver_grupos($id_genero);
                
                echo "<table border='1'>
                <tr><td>ID</td><td>GRUPO</td></tr>";
                foreach ($grupos as $grupo) {
                    echo "<tr>";
                    echo "<td>{$grupo->id_genero}</td>";
                    echo "<td>{$grupo->nombre}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        ?>
        <br><hr>
		<form action="cliente.php" method="post">
			<input type="submit" value="Volver">
		</form>
	</body>
</html>