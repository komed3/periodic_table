<?php
    
    define( 'pt', true );
    
    $sTime = microtime( true );
    
    /* SETTINGS ----------------------------------------------------- */
    
    $_IP = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/periodictable/';
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
    
    $url = array_map( 'urldecode', array_slice( explode( '/', $_SERVER[ 'REQUEST_URI' ] ), 2 ) );
    
    /* 404 ---------------------------------------------------------- */
    
    function get404() {
        
        
        
    }
    
?>
