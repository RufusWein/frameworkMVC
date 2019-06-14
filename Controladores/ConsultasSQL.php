<?php
namespace Controladores;

use mysqli;
use \Modelos\Usuario;
use Controladores\CorreoE;

/* 
 * Autor : srWhiteSkull
 */

class ConsultasSQL {
    // Datos de la base de datos
    static $servidor = "localhost";
    static $usuario  = "root";
    static $password = "password";
    static $db       = "datos";

    public static function Login($alias, $password) {
        $id =NULL;       
        $sql = "SELECT * FROM Usuarios WHERE alias='$alias'";
        $resultado = ConsultasSQL::EjecutaSQL($sql);

        if ($resultado->num_rows > 0) {
            $resultado = $resultado->fetch_assoc();
            if (password_verify($password, $resultado["password"])){
                $id = $resultado["id"];   
            }
        } 

        return $id;
    }
    
    public static function GetUsuarioBy($campo, $valor) {
        $usuario=NULL;       
        $sql = "SELECT * FROM Usuarios WHERE $campo='$valor' LIMIT 1";
        $resultado = ConsultasSQL::EjecutaSQL($sql);

        if ($resultado->num_rows > 0) {
            $resultado = $resultado->fetch_assoc();
            $usuario = new Usuario($resultado["id"],
                                   $resultado["alias"],
                                   $resultado["email"],
                                   $resultado["password"],
                                   $resultado["rol"],
                                   $resultado["verificado"]);
        } 
        
        return $usuario;
    }

    public static function RegistrarUsuario($alias, $email, $password){
        $codigo=NULL;        
        // comprobamos alias libre o email no repetido
        $sql = "SELECT * FROM Usuarios WHERE alias='$alias'";
        $resultado = ConsultasSQL::EjecutaSQL($sql);
        if ($resultado->num_rows > 0) { $codigo = "EALIAS"; }
        
        $sql = "SELECT * FROM Usuarios WHERE email='$email'";
        $resultado = ConsultasSQL::EjecutaSQL($sql);
        if ($resultado->num_rows > 0) { $codigo = "EEMAIL"; }
            
        // introducimos usuario sin verificar 
        if ($codigo==NULL){
            $password = password_hash($password, PASSWORD_BCRYPT);
            $sql="INSERT INTO Usuarios (alias , email, password) VALUES ('$alias','$email','$password')";
            if (ConsultasSQL::EjecutaSQL($sql)==TRUE) { $codigo="OK"; } 
        }
                
        // enviamos email de verificacion
        new CorreoE($email, "Mensaje de verificación de cuenta de correo", "Por favor, pincha en el enlace para verificar, http://localhost/$password");
        return $codigo;
    }
    
    public static function SetCamposUsuario($alias, $campos){
        $codigo = NULL;           
        $sql="UPDATE USuarios SET ";
        foreach ($campos as $campo=>$valor){
            $sql.="$campo='$valor',";
        }
        $sql=rtrim($sql,',');
        $sql.=" WHERE alias='$alias'";
        if (ConsultasSQL::EjecutaSQL($sql)==TRUE) { $codigo="OK"; } 
        
        return $codigo;
    }
    
    public static function EjecutaSQL($sql){
        $conexion = new mysqli(ConsultasSQL::$servidor, ConsultasSQL::$usuario, ConsultasSQL::$password, ConsultasSQL::$db);
        if ($conexion->connect_error) {
            die("Error en la conexión SQL: " . $conexion->connect_error);
        }       
        
        $resultado = $conexion->query($sql); 
        
        $conexion->close();
        return $resultado;        
    }
    
    public static function VerificaEmail($codigo){
        $usuario=NULL;
        $sql = "SELECT * FROM Usuarios WHERE password='$codigo' LIMIT 1";
        $resultado = ConsultasSQL::EjecutaSQL($sql);
        if ($resultado->num_rows > 0) { 
            $resultado = $resultado->fetch_assoc();
            $usuario = new Usuario($resultado["id"],
                                   $resultado["alias"],
                                   $resultado["email"],
                                   $resultado["password"],
                                   $resultado["rol"],
                                   1); // Verficamos, pero si hay un problema la info no persiste
            // verificamos en la bd
            if (!ConsultasSQL::EjecutaSQL("UPDATE Usuarios SET verificado=1 WHERE password='$codigo'")) {
                $usuario = NULL;
            }
        }
            
        return $usuario;
    }
}