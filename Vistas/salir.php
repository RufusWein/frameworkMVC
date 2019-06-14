<?php
    /* 
    * Autor : srWhiteSkull
    */
    
    $_SESSION["id_usuario"]=NULL;
    Controladores\Sesion::EliminaUsuario();
    
    session_destroy(); 
    
    header("Location: \\");
