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
                echo "<form name='basesDeDatos' method='post' action='gestionarTabla.php'>";

                echo "<lu>";
                while ($row =$listaDeTablas->fetch_array()) {

                    echo "<li><input type='submit' name='tabla' id='listaBoton' value='$row[0]'/></li>";
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
    /*
     * Muestra los registros con formato de tabla dentro de un formulario que se 
     * define en la página web. añade dos botones al final de cada registro para
     * trabajar con cada regisgro. Las dos lineas comentadas generan un formulario 
     * completo.
     * 
     * @param $tabla tabla sobre la que trabajar 
     */
    
    function verRegistros($tabla) {
         if ($this->conectar()){
          //  $this->conexion= new mysqli($this->servidor, $this->usuario, $this->clave, $this->baseDeDatos);
            
                echo "<div><fieldset>";
                echo "<legend id='tablas'>Registros de la tabla $tabla</legend>";
               // echo "<form name='basesDeDatos' method='post' action='gestionarTabla.php'>";
                echo "<table>";
                $sentencia="SHOW COLUMNS FROM $tabla;";
                $cabeceras= $this->conexion->query($sentencia);
                echo "<tr>";
                while ($row=$cabeceras->fetch_array()){
                    echo "<th>$row[0]</th>" ;
                }
                echo "</tr>";
                $cabeceras->close();
               
                
                $sentencia="SELECT * FROM $tabla";
                $listaDeRegistros= $this->conexion->query($sentencia);
                 $numeroDeCampos=$listaDeRegistros->field_count;
                while ($row =$listaDeRegistros->fetch_array()) {
                    echo "<tr>";
                    for ($i=0;$i<$numeroDeCampos;$i++){
                        echo "<td>$row[$i]</td>";
                    }
                     echo "<td><input type='submit' name='editar$row[$i]' id='botonEditarRegistro' value='Editar'/></td>";
                     echo "<td><input type='submit' name='borrar$row[$i]' id='botonBorrarRegistro' value='Borrar'/></td></tr></li>";
                     
                }
                echo "</table>";
                echo "</fieldset></div>";
                // echo "</form></fieldset></div>";
                $listaDeRegistros->close();
                $this->desconectar();
        } else {
            echo $this->conectar();
        }
    }
}