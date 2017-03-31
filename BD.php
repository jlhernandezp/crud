<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BD
 *
 * @author 104 1
 */
class BD {
    var $baseDeDatos;
    var $servidor;
    var $usuario;
    var $clave;
    var $conexion;
    
    /*
     * Constructor
     */
    function BD($servidor,$usuario,$clave, $baseDeDatos){
        $this->baseDeDatos=$baseDeDatos;
        $this->servidor=$servidor;
        $this->usuario=$usuario;
        $this->clave=$clave;
        
    }
    function verTablas(){
        if ($this->conectar()){
          //  $this->conexion= new mysqli($this->servidor, $this->usuario, $this->clave, $this->baseDeDatos);
            $sentencia="SHOW TABLES";
            $listaDeTablas= $this->conexion->query($sentencia);
                echo "<div><fieldset>";
                echo "<legend id='tablas'>Tablas de la base de datos $this->baseDeDatos</legend>";
                echo "<form name='basesDeDatos' method='post' action='tablas.php'>";

                echo "<lu>";
                while ($row =$listaDeTablas->fetch_array()) {

                    echo "<li><input type='submit' name='$row[0]' id='listaBoton' value='$row[0]'/></li>";
                }
                echo "</lu>";
                echo "</fieldset></form></div>";
                $this->desconectar();
        } else {
            echo $this->conectar();
        }
    }
    function conectar(){
        
        $myConexion= new mysqli($this->servidor, $this->usuario, $this->clave, $this->baseDeDatos);
        if ($myConexion->connect_error){
                    return "Error en la conexión: $myConexion->connect_error";

                } else {
                    $this->conexion=$myConexion;
                    return true;
        }
    
    }

    function desconectar(){
        $this->conexion->close();
    }
}