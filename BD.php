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
    function BD($servidor, $usuario, $clave, $baseDeDatos){
        $this->baseDeDatos=$baseDeDatos;
        $this->servidor=$servidor;
        $this->usuario=$usuario;
        $this->clave=$clave;
        
    }
    /**
     * Visualiza las tablas en botones.
     */
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
    /**
     *  Conecta con la base de datos 
     * @return boolean true si tiene éxito la conexión un string con el error si no lo es                                 
     */
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
                $sentenciaCabeceras="SHOW COLUMNS FROM $tabla;";
                $cabeceras= $this->conexion->query($sentenciaCabeceras);
                echo "<tr>";
                $j=0;
                
                while ($row=$cabeceras->fetch_array()){
                    echo "<th>$row[0]</th>" ;
                    $campo[$j++]=$row[0]; // guardamos los nombre de los campos para editar después
                }
                echo "</tr>";
                $cabeceras->free();
               
                
                $sentencia="SELECT * FROM $tabla";
                $listaDeRegistros= $this->conexion->query($sentencia);
                $numeroDeCampos=$listaDeRegistros->field_count;
                while ($row =$listaDeRegistros->fetch_array()) {
                    echo "<tr>";
                    for ($i=0;$i<$numeroDeCampos;$i++){
                        echo "<td><input type='text' name='$campo[$i]' value='$row[$i]' /><input type='hidden' name='nombreDeCampo' value='$campo[0]'/><input type='hidden' name='valorDeCampo' value='$row[0]'/></td>";
                        // el campo tipo hidden pasa en nombre del campo para posterior uso editando o borrando o...
                    }
                     echo "<td><input type='submit' name='editar' id='botonEditarRegistro' value='Editar'/></td>";
                     echo "<td><input type='submit' name='borrar' id='botonBorrarRegistro' value='Borrar'/></td></tr>";
                     
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
    /**
     * borra un registro de la tabla elegida,
     * @param type $tabla tabla de la que borrar el registro
     * @param type $primaryKey campo en el que buscar el valor
     * @param type $valor valor que buscamos para eliminar el registro
     */
    function borrarRegistro($tabla,$primaryKey,$valor) {
        if ($this->conectar()){
            //echo "borrando registro de la tabla $tabla $primaryKey / $valor";
            $sentenciaSQL="DELETE FROM `$tabla` WHERE `$primaryKey`='$valor'";
            if (!$this->conexion->query($sentenciaSQL)){
                
                echo "Falló borrando un registro de la tabla: (" . $this->conexion->errno . ") " . $this->conexion->error;
            }
        } else {
            echo $this->conectar();
        }

        $this->desconectar();
    }
    /**
     * actualiza los valores en la base de datos.
     * 
     * @param type $tabla tabla en la que volcar los resultados
     * @param type $valores array con los valores a cambiar.
     */
    function editarRegistro($tabla,$valores){
        
        if ($this->conectar()){
            $keys= array_keys($valores);
            $values= array_values($valores);
            
            $sentenciaSQL="UPGRADE `$tabla` SET ";
            for ($i=0; $i<($numeroDeCampos-1);$i++){
                $sentenciaSQL.=" $keys[$i] = $values[$i],  ";
            }
            $sentenciaSQL=rtrim($sentenciaSQL, ",");
            $sentenciaSQL=$sentenciaSQL. " WHERE "; //FALTA EL RESTO DE LA SENTENCIA
            if (!$this->conexion->query($sentenciaSQL)){
                
                echo "Falló la modificación de la tabla: (" . $this->conexion->errno . ") " . $this->conexion->error;
            }
        } else {
            echo $this->conectar();
        }

        $this->desconectar();
        
    }
}