<?php
    /* 
    * Autor : srWhiteSkull
    */
    use Controladores\Sesion;
    
    $usuario = ($_SESSION['usuario']!=NULL?$_SESSION['usuario']: Sesion::RecuperaUsuario());   
    if ($usuario==NULL){
        header("Location: \\");
    } else { // Solo administradores    
        if ($usuario->getRol()=="USUARIO"){
            header('Location: \home');
        }
    }
    Sesion::RetieneUsuario($usuario->getAlias(), 60);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Administrador</title>
        <link rel="stylesheet" type="text/css" href="/estilos.css">
    </head>
    <body>
        <div class="cabecera">
            <div><span>Administrador : <a href="/home"><?php echo $usuario->getAlias() ?></a></span></div>
            <div><a href="/salir"><button>Logout</button></a></div>
            <div><a href="/"><button>Inicio</button></a></div>
        </div>
        <div class="cuerpo"><span>
        <span><?php
        // put your code here
            echo "Buenas señorito, desea que le sirva un café?"
        ?></span>
        </div>
        <a class="pie" href="https://linkedin.com/in/pedro-rodríguez-gonzalez">Pedro A. Rodríguez © 2019</a>
    </body>
</html>
