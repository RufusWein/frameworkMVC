<?php
namespace Controladores;

/* 
 * Autor : srWhiteSkull
 */
class Sesion {
    //put your code here
    public static function RetieneUsuario($alias,$segundos){
        $token=md5(time());
        setcookie("usuario", md5(time()),time()+$segundos);
        ConsultasSQL::SetCamposUsuario($alias, ['token'=>$token]);
        // Luego se disparará el evento que actualiza el token pasado X segundos
        // que indica el final de sesión automatica
        ConsultasSQL::EjecutaSQL("DROP EVENT vigilante_$alias");
        ConsultasSQL::EjecutaSQL("CREATE EVENT vigilante_$alias ON SCHEDULE AT ".
                                 "CURRENT_TIMESTAMP + INTERVAL $segundos SECOND DO ".
                                 "UPDATE usuarios SET token = LPAD(LEFT(REPLACE(REPLACE(REPLACE(TO_BASE64(UNHEX(MD5(RAND()))), '/', ''), '+', ''), '=', ''), 8), 8, 0)".
                                 "WHERE alias='$alias'");
    }
    
    public static function RecuperaUsuario(){
        // Si el evento no lo ha modificado, se podrá recuperar el usuario
        return ConsultasSQL::GetUsuarioBy('token', filter_input(INPUT_COOKIE, "usuario"));
    }
    
    public static function EliminaUsuario(){
        setcookie("usuario",NULL,time()-1);
    }
}
