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
 if (isset($_POST['accion'])){
     
     switch ($_POST['accion']){
         case "Cancelar":
             header('Location:tablas.php');
             break;
         case "Insertar":
             header('Location:insertar.php');
             break;
    }
            
} 
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
        <?php
       
              
        $_SESSION['tablaElegida']= (isset($_POST['tabla'])) ? filter_input(INPUT_POST,'tabla') : $_SESSION['tablaElegida'];
        $_POST['accion']= (isset($_POST['accion'])) ?$_POST['accion']: null;
        
        switch ($_POST['accion']){
            case "Borrar": 
                echo "Borrando";
                echo "esta es la tabla de la que vamos a borrar ".$_SESSION['tablaElegida'];
                $baseDeDatos=new BD($_SESSION['servidor'],$_SESSION['usuario'],$_SESSION['clave'],$_SESSION['baseDeDatos']);
                $baseDeDatos->borrarRegistro($_SESSION['tablaElegida'],$_POST['nombreDeCampo'],$_POST['valorDeCampo']); 
                break;

            case "Editar":
                $baseDeDatos=new BD($_SESSION['servidor'],$_SESSION['usuario'],$_SESSION['clave'],$_SESSION['baseDeDatos']); 
                $baseDeDatos->editarRegistro($_SESSION['tablaElegida'],$_POST); 
                break;
        /*    case "Insertar":
                 $baseDeDatos=new BD($_SESSION['servidor'],$_SESSION['usuario'],$_SESSION['clave'],$_SESSION['baseDeDatos']); 
                $baseDeDatos->insertarRegistro($_SESSION['tablaElegida'],$_POST); 
                break;
         *
         */
        }
                
                echo "<form name='basesDeDatos' method='post' action='gestionarTabla.php'>";
                $baseDeDatos=new BD($_SESSION['servidor'],$_SESSION['usuario'],$_SESSION['clave'],$_SESSION['baseDeDatos']);
                $baseDeDatos->verRegistros($_SESSION['tablaElegida']); 
 
                echo "<input type='submit' name='accion' value='Cancelar'  />";
                echo "<input type='submit' name='accion' value='Insertar'  />";
                echo "</form>";
       
            
         ?>
        
    </body>
</html>
