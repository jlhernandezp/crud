<!DOCTYPE html>
<!--
Este requisito lo implementamos en el fichero gestionarTabla.php
Ahora se trata de visualizar el contenido de la base de datos.
Tendremos que obtener los nombres de los campos.
Crear una tabla en html donde la primera fila serán los nombres de los campos, y luego cada registro en una fila.
Cada registro lo podremos editar (para cambiar) o borrar, esto lo gestionaremos con un botón en cada fila *En la tabla tendremos la acción de Insertar para crear un nuevo registro o cancelar para volver a la página anterior (tablas.php), y tener la posibilidad de visualizar otra tabla.
Veamos un diagrama de caso de uso con todas las posibles acciones.
-->
<?php
spl_autoload_register(function ($clase) {
    require_once "$clase.php";}
);
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
        <?php
        if (!isset($_SESSION['tablaElegida'])){
            $_SESSION['tablaElegida']=filter_input(INPUT_POST,'tabla');
        }
        if (isset($_POST['borrar'])){
           
            $baseDeDatos=new BD($_SESSION['servidor'],$_SESSION['usuario'],$_SESSION['clave'],$_SESSION['baseDeDatos']);
            $baseDeDatos->borrarRegistro($_SESSION['tablaElegida']); 
        }
        if (!isset($_POST['editar'])){
            
            
            echo "<form name='basesDeDatos' method='post' action='gestionarTabla.php'>";
            $baseDeDatos=new BD($_SESSION['servidor'],$_SESSION['usuario'],$_SESSION['clave'],$_SESSION['baseDeDatos']);
            $baseDeDatos->verRegistros($_SESSION['tablaElegida']); 
    //        $baseDeDatos->desconectar();
            
            echo "</form>";
        } else {
            print_r($_POST);
            print_r($_SERVER['SCRIPT_FILENAME']);
        }
            
         ?>
    </body>
</html>
