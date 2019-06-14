<?php 
    /* 
    * Autor : srWhiteSkull
    */
    use Controladores\Sesion;
    
    $usuario = ($_SESSION['usuario']!=NULL?$_SESSION['usuario']: Sesion::RecuperaUsuario());
    if ($usuario==NULL){
        header("Location: \\");
    }
    Sesion::RetieneUsuario($usuario->getAlias(),60);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="/estilos.css">
    </head>
    <body>
        <div class="cabecera">
            <div><span>Usuario : <?php echo $usuario->getAlias() ?></span></div>
            <div><a href="/salir"><button>Logout</button></a></div>
            <?php if ($usuario->getRol()=="ADMINISTRADOR") { ?>
            <div><a href="/admin"><button>Administrar</button></a></div>
            <?php } ?>
            <div><a href="/"><button>Inicio</button></a></div>
        </div>
        <div class="cuerpo"><span>
        <span><?php
        // put your code here
            echo "Bienvenido ".$usuario->getAlias()."!";
            if (!$usuario->getVerificado()){
                echo "<br>Recuerde revisar el correo para verificar su cuenta por medio del enlace!";
            }
        ?></span>
        </div>
        <a class="pie" href="https://linkedin.com/in/pedro-rodríguez-gonzalez">Pedro A. Rodríguez © 2019</a>
    </body>
</html>
