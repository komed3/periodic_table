<?php
    
    require_once __DIR__ . '/pt.php';
    
    switch( strtolower( empty( $url[0] ) ? '' : $url[0] ) ) {
        
        case 'e':
        case 'element':
            
            if( empty( $url[1] ) || !( $e = new Element( $url[1] ) )->is_element() ) {
                
                get404();
                
            } else {
                
                require_once __DIR__ . '/pages/element.php';
                
                $p = new Element_Page( $e );
                print $p->output();
                
            }
            
            break;
        
    }
    
?>
