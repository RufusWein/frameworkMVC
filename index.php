<?php
    /* 
    * Autor : srWhiteSkull
    */
    
    //error_reporting(0); // Evitar avisos o errores
    require_once 'Controladores/ConsultasSQL.php';
    require_once 'Controladores/CorreoE.php';
    require_once 'Controladores/Sesion.php';
    require_once 'Modelos/Usuario.php';
    require_once 'vendor/autoload.php';

    use Controladores\Sesion;
        
    /////////////////////// ENRUTADOR ///////////////////
    session_start();
    
    $_SESSION['usuario']= Controladores\Sesion::RecuperaUsuario();         
    if (isset($_SESSION['usuario'])){
        if ($_SESSION['usuario']==NULL){
            $_SESSION['usuario']= Controladores\Sesion::RecuperaUsuario(); 
        } else {
            Sesion::RetieneUsuario($_SESSION['usuario']->getAlias(), 60);
        }
    } 

    $request = filter_input(INPUT_SERVER,'REQUEST_URI'); 
    $rutas = ["/"         => "indice"  , // MAPA
              "/login"    => "login"   ,
              "/registro" => "registro",
              "/salir"    => "salir"   ,
              "/admin"    => "admin"   ,
              "/home"     => "home"    ];
    
    if (array_key_exists($request, $rutas)!=false){
        require "Vistas/$rutas[$request].php"; // Redireccionamiento 
    } else {
        $_SESSION['usuario']=Controladores\ConsultasSQL::VerificaEmail(substr($request,1));
        
        if ($_SESSION['usuario']!=NULL){ // VERIFICANDO
            // Guardamos en el navegador el alias como clave con un valor random
            Sesion::RetieneUsuario($_SESSION['usuario']->getAlias(), 60); //segundos
            header('Location: \home');
        } else {
            require "Vistas/404.php"; // PAGINA NO ENCONTRADA
        }
    }

