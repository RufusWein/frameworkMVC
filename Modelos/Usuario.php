<?php
namespace Modelos;

/* 
 * Autor : srWhiteSkull
 */
class Usuario {
    function __construct(){
        // $id, $alias, $email, $password, $rol, $verificado
        $argumentos=func_get_args();
        if ($argumentos[0]!=NULL){
            $this->id = $argumentos[0];
        }
        
        if ($argumentos[1]!=NULL){
            $this->alias = $argumentos[1];
        }
        
        if ($argumentos[2]!=NULL){
            $this->email = $argumentos[2];
        }
        
        if ($argumentos[3]!=NULL){
            $this->password = $argumentos[3];
        }
        
        if ($argumentos[4]!=NULL){
            $this->rol = $argumentos[4];
        }
        
        if ($argumentos[5]!=NULL){
            $this->verificado = $argumentos[5];
        }
    }
    //////////////////////////////////
    private $id;
    
    public function getId(){
        return $this->id;
    }    
    //////////////////////////////////
    private $alias;
    
    public function getAlias(){
        return $this->alias;
    }
    
    public function setAlias($alias){
        $this->alias=$alias;
        
        return $this;
    }
    ///////////////////////////////////
    private $email;
    
    public function getEmail(){
        return $this->email;
    }
    
    public function setEmail($email){
        $this->email=$email;
                
        return $this;
    }
    /////////////////////////////////////
    private $password;
    
    public function getPassword(){
        return $this->password;
    }
    
    public function setPassword($password){
        $this->email=$password;
                
        return $this;
    }
    //////////////////////////////////////
    private $rol;
    
    public function getRol(){
        return $this->rol;
    }
    
    public function setRol($rol){
        $this->rol=$rol;
                
        return $this;
    }
    /////////////////////////////////////////
    private $verificado;
    
    public function getVerificado(){
        return $this->verificado;
    }
    
    public function setVerificado($verificado){
        $this->verificado=$verificado;
                
        return $this;
    }
}
