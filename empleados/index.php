<?php 
// Video 21: Ajustes Generales, separar el código que recepciona datos de la interfaz gráfica que sería el documento HTML
require 'empleados.php';
?>


<!DOCTYPE HTML>
<html lang='ES'>
<head>
    <!--==== DATOS INTERNOS DE RED =====-->
    <meta charset='utf-8' />
    <meta http-equiv='X-UA-Compatible' content='IE=edge' />
    <meta name='viewpor' content='width=device-width, user-scalable-yes, initial-scale=1, maximum-scale=3, minimum-scale=1' />
    <meta name='descripcion' content='Página Web desde 0' />
    <meta name='author' content='Juan F Sánchez' />
    <meta name='keywords' content='CRUD PHP, MySQL' />

    <!--==== Icono de la página =====-->
    <link rel='icon' type='icon/png' href='img/' />
    <!--==== Estilos para asignara las páginas =====-->
    <link rel='stylesheet' href='../css/bootstrap.min.css' />
    <script src='../js/jquery-3.3.1.slim.min.js'></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    

    <!--==== Nombre de la página =====-->
    <title>CRUD con PHP y MySQL</title>
</head>

<body>
	<!--============ Video 3: Crear una interfaz gráfica. =============-->

<div class="container"> 	<!-------- ectype="multipart/form-data" Este atributo del formulario va hacer que cuando la información de una imagen nos permite recepcionarla -------->
    <form action="" method="POST" enctype="multipart/form-data">

    <!--============ Video 17: Cambiar apariencia del formulario. =============-->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Empleado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <!-------- (label{lbl$:}+input[name="txt$" placeholder="" id="txt$" require]+br)*6 -------->
                        <!-------- Se elimina esta información <label for="">ID:</label> type="hidden" se hace para ocultarlo de la vista del usuario -------->
                        <input type="hidden" name="txtID" value="<?php echo $txtID; ?>" placeholder="" id="txtID" required>
                        <!-------- Se elimina esta información <br> -------->

                        <div class="form-group col-md-4"> <!-------- para agruparlos -------->
                            <label for="">Nombre(s):</label>
                            <input class="form-control <?php echo (isset($error['Nombre'])) ? "is-invalid": ""; ?>" type="text" name="txtNombre" value="<?php echo $txtNombre; ?>" placeholder="" id="txtNombre" >
                            <div class="invalid-feedback">
                                <?php echo (isset($error['Nombre'])) ? $error['Nombre']: ""; ?>
                            </div>
                            <br>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">Apellido Paterno:</label>
                            <input class="form-control" type="text" name="txtApellidoP" value="<?php echo $txtApellidoP; ?>" placeholder="" id="txtApellidoP" required>
                            <br>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">Apellido Materno:</label>
                            <input class="form-control" type="text" name="txtApellidoM" value="<?php echo $txtApellidoM; ?>" placeholder="" id="txtApellidoM" required>
                            <br>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="">Correo:</label>
                            <!-------- class="form-control" bajar los elementos y ponerlo en vertical -------->
                            <input class="form-control" type="email" name="txtCorreo" value="<?php echo $txtCorreo; ?>" placeholder="" id="txtCorreo" required>
                            <br>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="">Foto:</label>
                            <!--------  -------->
                            <?php if ($txtFoto!= "") { ?>
                                <br/>
                                <img class="img-thumbnail rounded mx-auto d-block" width="100px" src="../img/<?php echo $txtFoto; ?>" />
                                <br/>
                                <br/>
                            <?php }?>


                            <!-------- Para recuperar la información de los datos ingresados al formulario sería: value="" -------->
                            <!-------- Video 12: Se cambia type="file" y se agrega accept="image/*" para examinar documentos o archivos en formato imagen y el asterico es para todo tipo de formato -------->
                            <input class="form-control" type="file" accept="image/*" name="txtFoto" value="<?php echo $txtFoto; ?>" placeholder="" id="txtFoto" require="">
                            <br>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-------- (button[value="btn$" type="submit" name="accion"])*4 -------->
                    <button class="btn btn-success" <?php echo $accionAgregar ?> value="btnAgregar" type="submit" name="accion">Agregar</button>
                    <button class="btn btn-warning" <?php echo $accionModificar ?> value="btnModificar" type="submit" name="accion">Modificar</button>
                    <button class="btn btn-danger" <?php echo $accionEliminar ?> value="btnEliminar" onclick="return Confirmar('¿Relamente deseas borrar?');" type="submit" name="accion">Eliminar</button>
                    <button class="btn btn-primary" <?php echo $accionCancelar ?> value="btnCancelar" type="submit" name="accion">Cancelar</button>            
                </div>
            </div>
        </div>
    </div>
    <br/>
    <br/>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Agregar registro +
    </button>
    <br/>
    <br/>
    	
    </form>

    	<!--============ Video 8: Desplegar información en una tabla HTML =============-->
    	<!-------- .row>table>thead>tr>(th)*4 -------->
    <div class="row">
        <table class="table table-hover table-bordered" >
            <thead class="thead-dark" >
                <tr>
                    <th>Foto</th>
                    <th>Nombre Completo</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <?php
            /* Sirve para mostrar cada uno de los registros mediante un foreach  y obtener de lo que hay en MySQL*/ 
            foreach ($listaEmpleados as $empleado) { ?>
            <tr>
                <td>
                <!-------- Acá se ingresa la imagen que el usuario va ir subiendo con los datos, también se puede colocar un width="100px" para ajustar el tamaño en caso tal que sea más grande -------->
                <img class="img-thumbnail" width="100px" src="../img/<?php echo $empleado['Foto']; ?>" /> </td>
                <td><?php echo $empleado['Nombre']; ?> <?php echo $empleado['ApellidoP']; ?> <?php echo $empleado['ApellidoM']; ?></td>
                <td><?php echo $empleado['Correo']; ?></td>
                <td>
                <!--============ Video 9: Vamos a implementar nuestro Botón de Selecciónar =============-->
                <form action="" method="post">
                <!-------- input:hidden*6 -------->
                <input type="hidden" name="txtID" value="<?php echo $empleado['ID']; ?>">
                
                <!-------- Video 19: Para generar el Preview de la imagen seleccionada -------->
                <input class="btn btn-info" type="submit" value="Seleccionar" name="accion">
                <button class="btn btn-danger" value="btnEliminar" onclick="return Confirmar('¿Relamente deseas borrar?');" type="submit" name="accion">Eliminar</button>
                </form>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
    <?php if ($mostrarModal) { ?>
        <script>
            $('#exampleModal').modal('show');
        </script>
    <?php } ?>
    <script>
        function Confirmar(Mensaje) {
            return (confirm(Mensaje))? true:false; //If ternario
        }
    </script>
</div>

</body>
</html>