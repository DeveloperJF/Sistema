<?php
/* Video 2: Como conectarnos a una base de datos con PHP y MySQL.
    
     */

// La forma de conectar es más sencillo. Información del servidor
$servidor = "mysql:dbname=empresa;host=127.0.0.1";
$usuario = "root";
$pass = "";

// Nos permite que si no hay un error que nos permita entrar
try {
    $pdo = new PDO($servidor, $usuario, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); //array (PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" ) nos sirve para que la simbología en SQL como Pérez aparezca así y no P@rez.
    
    //echo "Conectado..."; 
    }
catch(PDOException $e) // Si hay un error no nos permite conectar
    {
    echo "Conexión Mala :( " . $e->getMessage();
    }
 
    /* Video 1: Creación de Base de Datos, acá no se genera ningún registro

    Video 4: Como funciona el metodo POST mediante PHP y como imprimir la información

    
     */
?>