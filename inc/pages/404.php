<?php
    
    class Error_Page extends Page {
        
        function __construct() {
            
            global $lng;
            
            $this->set_title( $lng->msg( '404' ) );
            
            $this->add_keywords( $lng->msg( 'error' ), '404' );
            
            $this->add_classes( 'error-404' );
            
            $this->add_header(
                '<div>' . $lng->msg( '404' ) . '</div>'
            );
            
            $this->add_content(
                '<article>' .
                    '<p>' . $lng->msg( '404-content' ) . '</p>' .
                    getSearchBar() .
                '</article>'
            );
            
        }
        
    }
    
?>
