<?php
    
    class Privacy_Page extends Page {
        
        function __construct() {
            
            global $lng, $_GITHUB;
            
            $this->set_title( $lng->msg( 'privacy' ) );
            
            $this->add_keywords( $lng->msg( 'privacy' ) );
            
            $this->add_classes( 'privacy' );
            
            $this->add_header(
                '<div>' . $lng->msg( 'privacy' ) . '</div>'
            );
            
            $this->add_content(
                '<article>' .
                    $lng->msg( 'privacy-content', Linker::e( $_GITHUB, $_GITHUB ) ) .
                '</article>'
            );
            
        }
        
    }
    
?>
