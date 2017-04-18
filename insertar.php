<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    spl_autoload_register(function ($clase) {
        require_once "$clase.php";});
    session_start();
if (isset($_POST['accion'])){
        switch ($_POST['accion']) {
            case "Cancelar":
                header('Location:gestionarTabla.php');
                break;
            case "Insertar":
                $baseDeDatos=new BD($_SESSION['servidor'],$_SESSION['usuario'],$_SESSION['clave'],$_SESSION['baseDeDatos']); 
                $baseDeDatos->insertarRegistro($_SESSION['tablaElegida'],$_POST);
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
          echo "<form name='insertar' method='post' action='.'>";

            $baseDeDatos=new BD($_SESSION['servidor'],$_SESSION['usuario'],$_SESSION['clave'],$_SESSION['baseDeDatos']); 
            $baseDeDatos->rellenarCampos($_SESSION['tablaElegida']); 
            
            echo "<input type='submit' name='accion' value='Insertar' />";
            echo "<input type='submit' name='accion' value='Cancelar' />";
                
         echo "</form>";
        ?>
    </body>
</html>
