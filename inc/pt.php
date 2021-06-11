<?php
    
    define( 'pt', true );
    
    /* SETTINGS ----------------------------------------------------- */
    
    $IP = 'http://localhost/periodictable/';
    $LNG = 'de';
    
    $db_host = 'localhost';
    $db_user = 'pt';
    $db_pswd = '12345';
    $db_name = 'periodictable';
    $db_prfx = '';
    
    $db = new mysqli( $db_host, $db_user, $db_pswd, $db_name );
    
    /* INCLUDES ----------------------------------------------------- */
    
    require_once __DIR__ . '/formatter.php';
    require_once __DIR__ . '/property.php';
    require_once __DIR__ . '/element.php';
    
?>
