<?php 
    /* 
    * Autor : srWhiteSkull
    */
    use Controladores\ConsultasSQL;
    use Controladores\Sesion;
    
    $usuario = ($_SESSION['usuario']!=NULL?$_SESSION['usuario']: Controladores\Sesion::RecuperaUsuario());
    if ($usuario!=NULL){
        $opcion=["ADMINISTRADOR"=>"/admin", "USUARIO"=>"/home"][$usuario->getRol()];
        header("Location: $opcion");
    }    
    
    // En caso de login
    $alias    = filter_input(INPUT_POST,'alias');
    $password = filter_input(INPUT_POST,'password');
    
    if ($alias!=NULL && $password!=NULL){
        // comprueba si existe
        $id=ConsultasSQL::Login($alias, $password);
        if ($id!=NULL){ // Login OK, redireccionamos al home
            $_SESSION['usuario']=ConsultasSQL::GetUsuarioBy('id',$id);
            Sesion::RetieneUsuario($_SESSION['usuario']->getAlias(),60);
            
            $opcion=["ADMINISTRADOR"=>"/admin", "USUARIO"=>"/home"][$_SESSION['usuario']->getRol()];
            header("Location: $opcion");
        } else { // ERROR
            $errorGeneral="ERROR! No existe el usuario o el password es incorrecto!";
        }
    } else {
        if ($alias!=NULL){
            // falta el password
            $errorPassword="Falta el password";
        } else if ($password!=NULL) {
            // falta el alias
            $errorAlias="Falta el alias";
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="/estilos.css">
    </head>
    <body>        
        <div class="cabecera">
            <div><a href="/"><button>Inicio</button></a></div>
            <div><a href="/registro"><button>Registro</button></a></div>
        </div>
        <div class="cuerpo">
            <form method="POST" action="/login">
                <p><span>Alias    :</span><input name="alias" required="required"></p>
                <?php if (isset($errorAlias)) { echo "<p>$errorAlias</p>"; } ?>
                <p><span>Password :</span><input name="password" type="password" required="required"></p>
                <?php if (isset($errorPassword)) { echo "<p>$errorPassword</p>"; } ?>
                <button>Acceder</button>
                <?php if (isset($errorGeneral)) { echo "<p>$errorGeneral</p>"; } ?>
            </form>
        </div>
        <a class="pie" href="https://linkedin.com/in/pedro-rodríguez-gonzalez">Pedro A. Rodríguez © 2019</a>
    </body>
</html>
