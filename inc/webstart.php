<?php
    
    require_once __DIR__ . '/pt.php';
    
    $pagestr = mb_strtolower( empty( $url[0] ) ? '' : $url[0] );
    
    if( empty( $url[0] ) || strlen( $url[0] ) == 0 ) {
        
        require_once __DIR__ . '/pages/table.php';
        
        $page = new Table_Page( 'set' );
        print $page->output();
        
    } else if( $pagestr == 'e' || $pagestr == mb_strtolower( $lng->msg( 'element' ) ) ) {
        
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
        
    } else if( $pagestr == mb_strtolower( $lng->msg( 'glossary' ) ) ) {
        
        require_once __DIR__ . '/pages/glossary.php';
        
        $page = new Glossary_Page();
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
        
        $table = new Table();
        
        if( $table->is_allowed( $prop = $lng->get_key( str_replace( '_', ' ', $url[0] ) ) ) ) {
            
            require_once __DIR__ . '/pages/table.php';
            
            $page = new Table_Page( $prop );
            print $page->output();
            
        } else {
            
            get404();
            
        }
        
    }
    
?>
