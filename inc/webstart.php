<?php
    
    /* LOAD REQUIRED INCLUDES --------------------------------------- */
    
    require_once __DIR__ . '/pt.php';
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
        
        return '<form action="' . $_IP . $lng->msg( 'search' ) . '" method="get" autocomplete="on" class="search-bar">' .
            '<input type="text" name="q" value="' .
                ( empty( $_GET['q'] ) ? '' : $_GET['q'] ) . '" placeholder="' .
                $lng->msg( 'search-placeholder' ) . '" />' .
            '<button type="submit" class="icon">search</button>' .
        '</form>';
        
    }
    
    /* PAGE --------------------------------------------------------- */
    
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
