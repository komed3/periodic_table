<?php
    
    define( 'pt', true );
    
    $sTime = microtime( true );
    
    /* GITHUB LINK -------------------------------------------------- */
    
    $_GITHUB = 'https://github.com/komed3/periodic_table';
    
    /* URL / QUERY -------------------------------------------------- */
    
    $url = array_map(
        'urldecode',
        array_slice(
            explode(
                '/',
                explode( '?', $_SERVER[ 'REQUEST_URI' ] )[0]
            ),
            2
        )
    );
    
    $args = $_REQUEST;
    
    /* LOAD SETTINGS ------------------------------------------------ */
    
    require_once __DIR__ . '/config.php';
    
    /* LOAD REQUIRED INCLUDES --------------------------------------- */
    
    require_once __DIR__ . '/database.php';
    require_once __DIR__ . '/language.php';
    
    /* PROPERTIES --------------------------------------------------- */
    
    $_props = [
        'classification' => [
            'set', 'group', 'period', 'block', 'age', 'crystal_system',
            'bravais', 'metal', 'heavy_metal', 'magnetism', 'superconductivity',
            'radioactivity', 'goldschmidt', 'acid_base', 'basicity',
            'trace', 'bio'
        ],
        'trend' => [
            'potential', 'molar_volume', 'density', 'r_calc', 'electron_affinity',
            'magnetic_susceptibility', 'pauling', 'allen', 'mulliken', 'sanderson',
            'allred_rochow', 'ghosh_gupta', 'pearson', 'mohs', 'vickers', 'brinell',
            'mf_earth'
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
    
?>
