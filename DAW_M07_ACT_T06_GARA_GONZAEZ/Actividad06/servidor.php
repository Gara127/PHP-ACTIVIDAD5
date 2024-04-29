<?php
	require_once("lib/nusoap.php");
	require_once("database.php");

	//CONFIGURCIÓN DEL SERVIDOR

	$namespace = "http://localhost/Actividad06/servidor.php";
	$server = new soap_server();
	$server->configureWSDL("Mi super servicio web", $namespace);
	$server->soap_defencoding = "UTF-8";

	//FUNCIONES DEL SERVIDOR

	function devolver_generos(){
		$objetoConectar = new Conectar();
		$con = $objetoConectar->conectar();

		$generos = array();
		$resultado = obtener_generos($con);
		while($info = obtener_info($resultado)){
			array_push($generos, $info);
		}

		cerrar_conexion($con);
		return $generos;
	}

	function add_grupo($nombre, $genero){
		$objetoConectar = new Conectar();
		$con = $objetoConectar->conectar();

		crear_grupo($con, $nombre, $genero);
		cerrar_conexion($con);
	}

	function devolver_grupos($genero){
		$objetoConectar = new Conectar();
		$con = $objetoConectar->conectar();

		$grupos = array();
		$resultado = obtener_grupos($con, $genero);
		while($info = obtener_info($resultado)){
			array_push($grupos, $info);
		}

		cerrar_conexion($con);
		return $grupos;
	}

	//REGISTRO DE FUNCIONES EN EL SERVIDOR

	$server->wsdl->addComplexType(
		'ArrayOfStrings',
		'complexType',
		'array',
		'',
		'SOAP-ENC:Array',
		array(),
		array('elemento' => array('name' => 'elemento', 'type' => 'xsd:string', 'minOccurs' => '0', 'maxOccurs' => 'unbounded'))
	);

	$server->register(
		'devolver_grupos',								//Nombre de la función a ejecutar
		array('nombre'=>'xsd:string', 'genero'=>'xsd:int'),				//Parámetros de entrada
		array('generos' => 'tns:ArrayOfStrings'),				                    //Valores devueltos
		$namespace,
		false,										//soapaction
		'rpc',										//Cómo se envían los mensajes
		'encoded',									//Serialización
		'Función que devuelve un array de grupo'
	);

	$server->register(
		'add_grupo',								//Nombre de la función a ejecutar
		array('nombre'=>'xsd:string', 'genero'=>'xsd:int'),				//Parámetros de entrada
		array(),				                    //Valores devueltos
		$namespace,
		false,										//soapaction
		'rpc',										//Cómo se envían los mensajes
		'encoded',									//Serialización
		'Función que crea nuevos grupos'
	);

	$server->register(
		'devolver_generos',								//Nombre de la función a ejecutar
		array(),									//Parámetros de entrada
		array('generos' => 'tns:ArrayOfStrings'),			//Valores devueltos
		$namespace,
		false,										//soapaction
		'rpc',										//Cómo se envían los mensajes
		'encoded',									//Serialización
		'Función que devuelve los géneros'
	);

	$server->service(file_get_contents("php://input"));
?>