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
    var $servidor;
    var $usuario;
    var $clave;
    var $miconexion;
    /*
     * Constructor
     */
    function BD($servidor, $usuario,$clave){
        $this->servidor=$servidor;
        $this->usuario=$usuario;
        $this->clave=$clave;
        $this->myConexion=new msqli($this->servidor, $this->usuario, $this->clave);
    }
    function conectar() {
       
        if ($this->$myConexion->connect_error){
            return "Error en la conexión: ".$this->myConexion->connect_error;
        } else {
            return false;
        }
    }
    function desconectar(){
        $this->myConexion->close();
    }
}
