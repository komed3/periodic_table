<?php
    
    require_once __DIR__ . '/pt.php';
    
    $pagestr = mb_strtolower( empty( $url[0] ) ? '' : $url[0] );
    
    if( $pagestr == 'e' || $pagestr == mb_strtolower( $lng->msg( 'element-page' ) ) ) {
        
        if( empty( $url[1] ) || !( $e = new Element( $url[1] ) )->is_element() ) {
            
            get404();
            
        } else {
            
            require_once __DIR__ . '/pages/element.php';
            
            $page = new Element_Page( $e );
            print $page->output();
            
        }
        
    } else if( $pagestr == mb_strtolower( $lng->msg( 'menu' ) ) ) {
        
        require_once __DIR__ . '/pages/menu.php';
        
        $page = new Menu_Page();
        print $page->output();
        
    } else if( $pagestr == mb_strtolower( $lng->msg( 'imprint' ) ) ) {
        
        require_once __DIR__ . '/pages/imprint.php';
        
        $page = new Imprint_Page();
        print $page->output();
        
    } else if( $pagestr == mb_strtolower( $lng->msg( 'privacy' ) ) ) {
        
        require_once __DIR__ . '/pages/privacy.php';
        
        $page = new Privacy_Page();
        print $page->output();
        
    } else {
        
        get404();
        
    }
    
?>
