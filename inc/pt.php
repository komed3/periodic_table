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
    require_once __DIR__ . '/table.php';
    require_once __DIR__ . '/mtable.php';
    
    /* FUNCTIONS ---------------------------------------------------- */
    
    function get404() {
        
        require_once __DIR__ . '/pages/404.php';
        
        $page = new Error_Page();
        print $page->output();
        
    }
    
    function getSearchBar() {
        
        global $_IP, $lng;
        
        return '<form action="' . $_IP . $lng->msg( 'search-page' ) . '" method="get" autocomplete="on" class="search-bar">' .
            '<input type="text" name="q" value="' .
                ( empty( $_GET['q'] ) ? '' : $_GET['q'] ) . '" placeholder="' .
                $lng->msg( 'search-placeholder' ) . '" />' .
            '<button type="submit" class="icon">search</button>' .
        '</form>';
        
    }
    
    /* URL ---------------------------------------------------------- */
    
    $url = array_map(
        'urldecode',
        array_slice(
            explode( '/', $_SERVER[ 'REQUEST_URI' ] ),
            2
        )
    );
    
?>
