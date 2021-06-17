<?php
    
    class Imprint_Page extends Page {
        
        function __construct() {
            
            global $lng, $_GITHUB;
            
            $this->set_title( $lng->msg( 'imprint' ) );
            
            $this->add_keywords( $lng->msg( 'imprint' ) );
            
            $this->add_classes( 'imprint' );
            
            $this->add_header(
                '<div>' . $lng->msg( 'imprint' ) . '</div>'
            );
            
            $this->add_content(
                '<article>' .
                    '<ul class="list">' .
                        '<li>' .
                            '<b>' . $lng->msg( 'webmaster' ) . '</b>' .
                            '<span>' . Linker::e( 'https://labs.komed3.de', 'komed3 (Paul Köhler)' ) . '</span>' .
                        '</li>' .
                        '<li>' .
                            '<b>' . $lng->msg( 'mail' ) . '</b>' .
                            '<span>' . Linker::e( 'mailto:webmaster@pse-info.de', 'webmaster@pse-info.de' ) . '</span>' .
                        '</li>' .
                        '<li>' .
                            '<b>' . $lng->msg( 'github' ) . '</b>' .
                            '<span>' . Linker::e( $_GITHUB, 'komed3/periodic_table' ) . '</span>' .
                        '</li>' .
                    '</ul>' .
                    '<h2>' . $lng->msg( 'disclaimer' ) . '</h2>' .
                    $lng->msg( 'disclaimer-content' ) .
                '</article>'
            );
            
        }
        
    }
    
?>
