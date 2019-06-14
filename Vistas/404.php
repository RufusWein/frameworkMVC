<?php 
    /* 
    * Autor : srWhiteSkull
    */
    use Controladores\Sesion;
    
    $usuario = ($_SESSION['usuario']!=NULL?$_SESSION['usuario']: Sesion::RecuperaUsuario());
    if ($usuario!=NULL) {
        Sesion::RetieneUsuario($usuario->getAlias(),60);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Página no encontrada</title>
        <link rel="stylesheet" type="text/css" href="/estilos.css">
    </head>
    <body>
        <div class="cabecera">
            <?php if ($usuario!=NULL) { ?>
            <div><span>Usuario : <a href="/home"><?php echo $usuario->getAlias() ?></a></span></div>
            <div><a href="/salir"><button>Logout</button></a></div>
            <?php } else { ?>
            <div><a href="/login"><button>Login</button></a></div>
            <div><a href="/registro"><button>Registro</button></a></div>
            <?php } ?>
            <div><a href="/"><button>Inicio</button></a></div>
        </div>
        <div class="cuerpo"><span>
        <span><?php
        // put your code here
            echo "Error 404! Página no existe!";
        ?></span>
        </div>
        <a class="pie" href="https://linkedin.com/in/pedro-rodríguez-gonzalez">Pedro A. Rodríguez © 2019</a>
    </body>
</html>
