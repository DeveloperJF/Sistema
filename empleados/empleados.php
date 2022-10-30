<?php

//print_r($_POST);
// para visualizar en cada espacio lo que se ingresa

/* Video 5: Recepcionar datos enviados con el metodo POST con las diferentes variables.
 */

 // Asignar los valores del POST que el formulario nos envía mediante un if ternario
$txtID = (isset($_POST['txtID'])) ?$_POST['txtID']:""; // isset nos permite validar si la variable tiene algo o llega vacío.
$txtNombre = (isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtApellidoP = (isset($_POST['txtApellidoP']))?$_POST['txtApellidoP']:"";
$txtApellidoM = (isset($_POST['txtApellidoM']))?$_POST['txtApellidoM']:"";
$txtCorreo = (isset($_POST['txtCorreo']))?$_POST['txtCorreo']:"";
/* Video 12 */
$txtFoto = (isset($_FILES['txtFoto']['name']))?$_FILES['txtFoto']['name']:"";
// Para recepcionar el Botón de acción para distinguirlo entre varios que hay
$accion = (isset($_POST['accion'])?$_POST['accion']:"");

/*  Video 20: Validar registro por parte del servidor */
$error = array ();

/*  Video 18: Activar y Desactivar Botones */
$accionAgregar = ""; // Variable aislada, para identificar para Activar o Desactivar dicho botón.
$accionModificar = $accionEliminar = $accionCancelar = "disabled";
$mostrarModal = false;


/* Video 6: Insertar información a nuestra base de datos
 */
//icluir conexion.php
include ("../conexion/conexion.php");

// Evaluar lo que presionó el usuario de algunos de los botones 
switch ($accion) {
    case 'btnAgregar':
        if ($txtNombre == "") {
            $error ['Nombre'] = "Escribe el Nombre";
        }
        if ($txtApellidoP == "") {
            $error ['ApellidoP'] = "Escribe el Apellido Paterno";
        }
        if ($txtApellidoM == "") {
            $error ['ApellidoM'] = "Escribe el Apellido Materno";
        }
        if ($txtCorreo == "") {
            $error ['Correo'] = "Escribe el Correo";
        }
        if ($txtFoto == "") {
            $error ['Foto'] = "Sube la Foto";
        }
        if (count($error) > 0) {
            $mostrarModal = true;
            break;
        }


        // $pdo se obtiene la conexión que se creó y prepare (prepara la instrucción SQL para que INSERTAR en la base de datos)
        $sentencia = $pdo->prepare("INSERT INTO empleados(Nombre, ApellidoP, ApellidoM, Correo, Foto) VALUES (:Nombre, :ApellidoP, :ApellidoM, :Correo, :Foto)"); // Con los 2 puntos se crean referencias para poder  insertar información se pone los 2 puntos para pasarle variables y valores que se declararon con anterioridad

        $sentencia -> bindParam(':Nombre', $txtNombre);
        $sentencia -> bindParam(':ApellidoP', $txtApellidoP);
        $sentencia -> bindParam(':ApellidoM', $txtApellidoM);
        $sentencia -> bindParam(':Correo', $txtCorreo);

        /* SE OBTIENE LA FECHA Y EL NOMBRE DEL ARCHIVO */
        /* Video 13: Como copiar una fotografía a nuestro servidor y nos lo muestra en la tabla de registros. */
        $Fecha = new DateTime(); // Se identifica la fecha en que se subió la imagen para diferenciar entre varios archivos que tienen el mismo nombre 
        $nombreArchivo = ($txtFoto!= "") ?$Fecha -> getTimestamp (). "_" .$_FILES['txtFoto']['name']:"imagen.jpg";
        
        // Es el nombre que PHP me está devolviendo cuando el usuario selecciona esa fotografía, La recolecta
        $tmpFoto = $_FILES['txtFoto']['tmp_name']; 

        // Después de recolectar la foto se copia al servidor con la función move_uploaded_file, esta lo recibe la fotografía temporal y el lugar destino donde se quiere mandar, junto con el nombre nuevo del archivo
        if ($tmpFoto!="") {
            move_uploaded_file ($tmpFoto, "../img/".$nombreArchivo);
        }

        $sentencia -> bindParam(':Foto', $nombreArchivo);
        $sentencia -> execute (); // Lo que nos permite es ejecutar esa instrucción SQL con la misma sentencia (Objeto)
        header('Location: index.php');
    break;

    
    
    case 'btnModificar': 
        

        /* Video 10: Vamos a modificar registros mediante la sentencia UPDATE */
        // Evalua los diferentes casos en los que la acción recupera un valor de acuerdo a botón que oprima.
        $sentencia = $pdo -> prepare ("UPDATE empleados SET
        Nombre = :Nombre,
        ApellidoP = :ApellidoP,
        ApellidoM = :ApellidoM,
        Correo = :Correo
        WHERE
        ID = :ID");

        $sentencia -> bindParam(':Nombre', $txtNombre);
        $sentencia -> bindParam(':ApellidoP', $txtApellidoP);
        $sentencia -> bindParam(':ApellidoM', $txtApellidoM);
        $sentencia -> bindParam(':Correo', $txtCorreo);
        
        $sentencia -> bindParam(':ID', $txtID);
        $sentencia -> execute ();

        /* Video 14: Modificar foto en los registros. */
        $Fecha = new DateTime(); 
        $nombreArchivo = ($txtFoto!= "") ?$Fecha -> getTimestamp (). "_" .$_FILES['txtFoto']['name']:"imagen.jpg";
        
        $tmpFoto = $_FILES['txtFoto']['tmp_name']; 

        if ($tmpFoto!="") {
            move_uploaded_file ($tmpFoto, "../img/".$nombreArchivo);


            /* Video 16: Agregar Borrado de la modificación y además validar nuestros campos. Lo que significa este fragmento de código es que cuando se cambia una foto por otra nueva se debe eliminar la anterior antes de AGREGAR LA NUEVA FOTO*/
            $sentencia = $pdo -> prepare ("SELECT Foto FROM empleados WHERE ID = :ID");
            $sentencia -> bindParam(':ID', $txtID);
            $sentencia -> execute ();
            $empleado = $sentencia -> fetch(PDO::FETCH_LAZY); // Devuelve un dato de la tabla seleccionada (Foto)
            print_r ($empleado);

            if (isset($empleado['Foto'])) {
                if (file_exists("../img/".$empleado['Foto'])) { // Verifica que si hay una foto en la carpeta y el unlink haría el borrado de la foto 
                    if ($empleado['Foto']!= "imagen.jpg") { // para dejar la imagen.jpg y no la elimine
                        unlink ("../img/".$empleado['Foto']);
                    }
                }
            }

            // AGREGAR LA NUEVA FOTO
            $sentencia = $pdo -> prepare ("UPDATE empleados SET
            Foto = :Foto WHERE ID = :ID");
            $sentencia -> bindParam(':Foto', $nombreArchivo);
            $sentencia -> bindParam(':ID', $txtID);
            $sentencia -> execute ();
        }

        // header en PHP se utiliza para hacer una redicción a la ubicación que queremos.
        header('Location: index.php');

        echo $txtID;
        echo "Presionaste btnModificar";
    break;

     /* Video 11: Crear let from empleados y se incluye un botón para eliminar */
    
        case 'btnEliminar':
        /* Video 15: Borrar foto en la carpeta de donde se guardan las fotos. */
        // Con la siguiente instrucción se selecciona la foto de la tabla empleados
        $sentencia = $pdo -> prepare ("SELECT Foto FROM empleados WHERE ID = :ID");
        $sentencia -> bindParam(':ID', $txtID);
        $sentencia -> execute ();
        $empleado = $sentencia -> fetch(PDO::FETCH_LAZY); // Devuelve un dato de la tabla seleccionada (Foto)
        print_r ($empleado);

        if (isset($empleado['Foto']) && ($empleado['Foto']!= "imagen.jpg")) { // para dejar la imagen.jpg y no la elimine
            if (file_exists("../img/".$empleado['Foto'])) { // Verifica que si hay una foto en la carpeta y el unlink haría el borrado de la foto
                unlink ("../img/".$empleado['Foto']);
                
            }
        }

        $sentencia = $pdo -> prepare ("DELETE FROM empleados WHERE ID = :ID");
        $sentencia -> bindParam(':ID', $txtID);
        $sentencia -> execute ();
        header('Location: index.php');
        
        echo $txtID;
        echo "Presionaste btnEliminar";
    break;
        case 'btnCancelar':
        header('Location: index.php');
    break;
    case 'Seleccionar':
        $accionAgregar = "disabled";
        $accionModificar = $accionEliminar = $accionCancelar = "";
        $mostrarModal = true;

        // Se selecciona de la tabla empleados todos los campos y se consulten 
        $sentencia = $pdo -> prepare ("SELECT * FROM empleados WHERE ID = :ID");
        $sentencia -> bindParam(':ID', $txtID);
        $sentencia -> execute ();
        $empleado = $sentencia -> fetch(PDO::FETCH_LAZY);

        /* Sustituye la información del Forech -> form -> input termina eliminándola lo que está adentro y con esto dependemos completamente de la "SELECT * FROM empleados WHERE id = :id" DE ARRIBA */
        $txtNombre = $empleado['Nombre'];
        $txtApellidoP = $empleado['ApellidoP'];
        $txtApellidoM = $empleado['ApellidoM'];
        $txtCorreo = $empleado['Correo'];
        $txtFoto = $empleado['Foto'];


    break;

}
// Video 7: Acceder a la base de datos
// Instrucción de SQL
$sentencia = $pdo -> prepare ("SELECT * FROM `empleados` WHERE 1");
$sentencia -> execute ();
$listaEmpleados = $sentencia -> fetchAll (PDO::FETCH_ASSOC); /* Ejecuta la instrucción de SQL (execute) y después se lo va asignar a $listaEmpleados, se obtiene directamente trabajando la variable $listaEmpleados. Y lo regresa con PDO::FETCH_ASSOC, esto lo devuelve o asociar información de la base de datos a un arreglo.
*/

/* Este proceso se antes de imprimir los datos en una tabla. Con esto se monitorea si la información de la sentencia de SQL: $sentencia = $pdo -> prepare ("SELECT * FROM `empleados` WHERE 1") es la que yo espero.
*/
// para visualizar en cada espacio lo que se ingresa
//print_r ($listaEmpleados);

?>