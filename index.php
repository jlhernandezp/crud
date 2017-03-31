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
        <title>Gestor de bases de datos</title>
        <style type="text/css">
            div {
                
            }
            fieldset{
                border: 0.25em solid;
                align : center;
                position: absolute;
                left: 20%;
                top: 30%;
                margin-left: -115px;
                margin-top: -80px;
                padding:10px;
                background-color: #eee;
                
              }

            legend{
                  font-size: 2em;
                  color: green;
                  font-weight: bold;
              }
                
            input[type=submit] {
                  padding:5px 15px 10px 10px; 
                  background:#ccc; 
                  border:2;
                  cursor:pointer;
                  border-radius: 5px; 
                  margin: 1em;
                  font-size: 1em;
              }
              li input[type=submit]{
                  border:0;
                  background-color:#fff;
                  text-decoration:underline;
                  color:#000; cursor:pointer;
                  
              }
        </style>
    </head>
    <body>
        <div>
        <fieldset>
            <legend id="elegirServidor">Datos de conexion</legend>
            <form name="formularioServidor" id="formularioServidor" method="post" action="index.php">
                <label>Servidor: <input type="text" name="servidor" size="25" /></label> 
                <label>Usuario: <input type="text" name="usuario" size="25" /></label> 
                <label>Contraseña: <input type="text" name="clave" size="25" /></label>
                <input type="submit" value="Conectar" name="conectar" />
            </form>
        </fieldset>
       </div>
        <?php
            if (isset($_POST['servidor'])){
                /*
                 * Intentar la conexión, si tiene éxito
                 * se muestran las tablas.
                 * 
                 */
                 

                $myConexion= new mysqli($_POST['servidor'],$_POST['usuario'],$_POST['clave']);

                if ($myConexion->connect_error){
                    echo "Error en la conexión: $miConexion->connect_error";

                } else {
                    $_SESSION['servidor']=$_POST['servidor'];
                    $_SESSION['usuario']=$_POST['usuario'];
                    $_SESSION['clave']=$_POST['clave'];
                    
                    $sentenciaMysql="SHOW DATABASES";
                    $basesDeDatos=$myConexion->query($sentenciaMysql);
                    echo "<div><fieldset>";
                    echo "<legend id='tablas'>Bases de datos del servidor ".$_POST['servidor']."</legend>";
                    echo "<form name='basesDeDatos' method='post' action='tablas.php'>";
                   
                    echo "<lu>";
                    while ($row =$basesDeDatos->fetch_array()) {

                        echo "<li><input type='submit' name='botonLista' id='botonLista' value='$row[0]'/></li>";
                    }
                    echo "</lu>";
                    echo "</fieldset></form></div>";
                }
                $myConexion->close(); 
               
            } 
        ?>
    </body>
</html>
