<?php
    
    class Element_Page extends Page {
        
        function __construct(
            Element $e
        ) {
            
            global $lng;
            
            $sections = [];
            
            foreach( [
                'general' => [],
                'atomic' => [],
                'chemical' => [],
                'physical' => [],
                'GHS' => []
            ] as $section => $props ) {
                
                $sections[] = '<section id="' . $section . '">' .
                    '<h2>' . $lng->msg( 'prop-' . $section ) . '</h2>' .
                '</section>';
                
            };
            
            $this->set_title( $lng->msg( 'element-page-title', $e->ID, $e->symbol, $e->get_name() ) );
            
            $this->set_description( $e->description );
            $this->add_keywords( $e->ID, $e->symbol, $e->get_name() );
            
            $this->add_classes( 'element' );
            
            $this->add_content(
                '<h1>' . $e->get_symbol() . $e->get_name() . '</h1>' .
                '<article>' .
                    '<p>' . ( new Formatter( $e->description ) )->str() . '</p>' .
                    implode( '', $sections ) .
                '</article>'
            );
            
        }
        
    }
    
?>
