<?php
    class Conectar{
        public static function conectar(){
            
            require_once("datos.php");
            $con = mysqli_connect($host, $user, $password) or die("Error al conectar con la base de datos");
            crear_bdd($con);
            mysqli_select_db($con, $dbname);
            crear_tabla_genero($con);
            crear_tabla_grupo($con);
            return $con;
        }
    }

    // BBDD

    function crear_bdd($con){
        mysqli_query($con, "create database if not exists audioteca;");
        mysqli_query($con, "create user if not exists supervisor identified by '1234';");
        mysqli_query($con, "GRANT ALL ON `audioteca`.* TO supervisor;");
    }

    function crear_tabla_genero($con){
        mysqli_query($con, "create table if not exists genero(
                    id_genero int primary key auto_increment, 
                    nombre varchar(100)) 
                    ");

        $generos = obtener_generos($con);
        $filas = obtener_num_filas($generos);
    
        if($filas == 0){
            mysqli_query($con, "insert into genero (nombre) values ('Pop')");    
            mysqli_query($con, "insert into genero (nombre) values ('Rock')");
            mysqli_query($con, "insert into genero (nombre) values ('Soul')");
            mysqli_query($con, "insert into genero (nombre) values ('Country')");
            mysqli_query($con, "insert into genero (nombre) values ('Musica clasica')");            
        }
    }
    
    
    function crear_tabla_grupo($con){
        mysqli_query($con, "create table if not exists grupo(
                    id_grupo int primary key auto_increment, 
                    nombre varchar(100),
                    id_genero int,
                    CONSTRAINT fk_genero FOREIGN KEY(id_genero) REFERENCES genero(id_genero))
                    ");
    }

    // FUNCIONES AUXILIARES

    function obtener_info($resultado){
        return mysqli_fetch_array($resultado);
    }

    function cerrar_conexion($con){
        mysqli_close($con);
    }

    function obtener_num_filas($resultado){
        return mysqli_num_rows($resultado);
    }

    // GENEROS

    function obtener_generos($con){
        $consulta = "select * from genero";
        $generos = mysqli_query($con, $consulta);
        return $generos; 
    }

    // GRUPOS

        function obtener_grupos($con, $genero){
            $consulta = "select * from grupo where id_genero = $genero";
            $grupos = mysqli_query($con, $consulta);
            return $grupos;
        }

    function crear_grupo($con, $nombre, $id_genero){
        mysqli_query($con, "insert into grupo(nombre, id_genero) values('$nombre', '$id_genero')");
    } 

?>