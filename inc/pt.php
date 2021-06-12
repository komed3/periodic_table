<?php
    
    define( 'pt', true );
    
    /* SETTINGS ----------------------------------------------------- */
    
    $_IP = 'http://localhost/periodictable/';
    $_LNG = 'de';
    
    $db_host = 'localhost';
    $db_user = 'pt';
    $db_pswd = '12345';
    $db_name = 'periodictable';
    $db_prfx = '';
    
    /* INCLUDES ----------------------------------------------------- */
    
    require_once __DIR__ . '/database.php';
    require_once __DIR__ . '/language.php';
    require_once __DIR__ . '/formatter.php';
    require_once __DIR__ . '/linker.php';
    require_once __DIR__ . '/page.php';
    require_once __DIR__ . '/property.php';
    require_once __DIR__ . '/element.php';
    
    /* URL ---------------------------------------------------------- */
    
    $url = array_slice( explode( '/', $_SERVER[ 'REQUEST_URI' ] ), 2 );
    
    /* 404 ---------------------------------------------------------- */
    
    function get404() {
        
        
        
    }
    
?>
