<?php
    
    class Element_Page extends Page {
        
        function __construct(
            Element $e
        ) {
            
            global $lng;
            
            $this->set_title( $lng->msg( 'element-page-title', $e->ID, $e->symbol, $e->name ) );
            
            $this->add_content(
                '<h1>' . ( new Formatter( '{' . $e->ID . '}' . $e->symbol . ': ' . $e->name ) )->str() . '</h1>'
            );
            
        }
        
    }
    
?>
