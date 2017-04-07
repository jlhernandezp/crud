<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
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
        <title>Listado de tablas</title>
    </head>
    <body>
        <?php
        if (isset($_POST['botonLista'])){
            $_SESSION['baseDeDatos']=filter_input(INPUT_POST,'botonListaBD');
        }
            $baseDeDatos=new BD($_SESSION['servidor'],$_SESSION['usuario'],$_SESSION['clave'],$_SESSION['baseDeDatos']);
            if ($baseDeDatos->conectar() ){
                $baseDeDatos->verTablas(); 
            }else {
                echo $baseDeDatos->conectar();
            }
            //$baseDeDatos->desconectar();
        
        ?>
    </body>
</html>
