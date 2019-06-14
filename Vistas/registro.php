<?php 
    /* 
    * Autor : srWhiteSkull
    */
    use Controladores\Sesion;
    
    $usuario = ($_SESSION['usuario']!=NULL?$_SESSION['usuario']: Sesion::RecuperaUsuario());
    if ($usuario!=NULL){
        header("Location: \home");
    }

    use Controladores\ConsultasSQL;
    // En caso de login
    $alias    = filter_input(INPUT_POST,'alias');
    $email    = filter_input(INPUT_POST,'email');
    $password = filter_input(INPUT_POST,'password');
    $rpassword = filter_input(INPUT_POST,'rpassword');  
    
    if ($alias!=NULL && $password!=NULL && $rpassword!=NULL && $email!=NULL){
        // comprueba si existe
        if ($password==$rpassword){ 
            $codigo = ConsultasSQL::RegistrarUsuario($alias, $email, $password);
            if ($codigo == "OK"){ 
                $_SESSION['usuario']= ConsultasSQL::GetUsuarioBy('email',$email);
                Sesion::RetieneUsuario($_SESSION['usuario']->getAlias(), 60);
                
                header("Location: \home");
            // ERRORES /////////////////////////////////
            } else if ($codigo=="EALIAS") { // ERROR
                $errorAlias = "Ya existe ese alias, escoja otro!";
            } else if ($codigo=="EEMAIL")  { // ERROR
                $errorEmail = "Correo en uso!";
            } else { // ERROR
                $errorGeneral="ERROR! No deje ningún campo vacío y siga las instrucciones!";
            }
        } else { // password no confirmada
            $errorPassword = "Password sin confirmar!";
        }
    } 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Registro</title>
        <link rel="stylesheet" type="text/css" href="/estilos.css">
    </head>
    <body>
         <div class="cabecera">
            <div><a href="/"><button>Inicio</button></a></div>
            <div><a href="/login"><button>Login</button></a></div>
        </div>
        <div class="cuerpo">
            <form method="POST" action="/registro">
                <p><span>Alias           :</span><input name="alias" type="text" required="required" pattern="^[\pA-Za-z0-9\s]{9,14}$" title="Se permiten caracteres y números al menos 8 y un max. de 13"
                <?php if (isset($alias) && !isset($errorAlias)) { echo "value='$alias'"; } ?>></p>
                <?php if (isset($errorAlias)) { echo "<p>$errorAlias</p>"; } ?>
                <p><span>Email           :</span><input name="email" type="email" required="required" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{1,}$" title="Usa una dirección de correo válida"
                <?php if (isset($email) && !isset($errorEmail)) { echo "value='$email'"; } ?>></p>
                <?php if (isset($errorEmail)) { echo "<p>$errorEmail</p>"; } ?>
                <p><span>Password        :</span><input name="password"  type="password" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,15}" title="Debe tener al menos un número y alguna letra minúscula y mayúscula, y tener al menos 8 caracteres con un max. de 15"></p>
                <p><span>Repite password :</span><input name="rpassword" type="password" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,15}" title="Debe tener al menos un número y alguna letra minúscula y mayúscula, y tener al menos 8 caracteres con un max. de 15"></p>
                <?php if (isset($errorPassword)) { echo "<p>$errorPassword</p>"; } ?>
                <button>Registrar</button>
                <?php if (isset($errorGeneral)) { echo "<p>$errorGeneral</p>"; } ?>
            </form>
        </div>
        <a class="pie" href="https://linkedin.com/in/pedro-rodríguez-gonzalez">Pedro A. Rodríguez © 2019</a>
    </body>
</html>
