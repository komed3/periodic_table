<?php
    
    define( 'pt', true );
    
    $sTime = microtime( true );
    
    /* SETTINGS ----------------------------------------------------- */
    
    $_IP = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/periodictable/';
    $_GITHUB = 'https://github.com/komed3/periodic_table';
    $_LNG = 'de';
    
    $db_host = 'localhost';
    $db_user = 'pt';
    $db_pswd = '12345';
    $db_name = 'periodictable';
    $db_prfx = '';
    
    $_props = [
        'classification' => [
            'set', 'group', 'period', 'block', 'age', 'crystal_system',
            'bravais', 'metal', 'heavy_metal', 'magnetism', 'superconductivity',
            'radioactivity', 'goldschmidt', 'acid_base', 'basicity'
        ],
        'trend' => [
            'magnetic_susceptibility', 'density', 'electron_affinity',
            'potential', 'pauling', 'allen', 'mulliken', 'sanderson',
            'allred_rochow', 'ghosh_gupta', 'pearson', 'mohs', 'vickers',
            'brinell'
        ],
        'interactive' => [
            'phase', 'discovery'
        ],
        'property' => [
            'radioactive', 'natural', 'native', 'vital', 'clean',
            'stable', 'noble', 'semiconductor', 'light', 'heavy',
            'rare', 'platinum', 'refractory', 'mendeleev'
        ]
    ];
    
    /* INCLUDES ----------------------------------------------------- */
    
    require_once __DIR__ . '/database.php';
    require_once __DIR__ . '/language.php';
    require_once __DIR__ . '/formatter.php';
    require_once __DIR__ . '/linker.php';
    require_once __DIR__ . '/page.php';
    require_once __DIR__ . '/property.php';
    require_once __DIR__ . '/element.php';
    require_once __DIR__ . '/table.php';
    require_once __DIR__ . '/longtable.php';
    
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
    
    /* URL / QUERY -------------------------------------------------- */
    
    $url = array_map(
        'urldecode',
        array_slice(
            explode( '/', explode( '?', $_SERVER[ 'REQUEST_URI' ] )[0] ),
            2
        )
    );
    
    $args = $_REQUEST;
    
?>
