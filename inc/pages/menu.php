<?php
    
    class Menu_Page extends Page {
        
        private $nav = [
            'tool' => [
                'list', 'nuclide_table', 'molar_calculator'
            ]
        ];
        
        function __construct() {
            
            global $lng, $_props;
            
            $nav_content = '';
            
            foreach( array_merge( $_props, $this->nav ) as $section => $links ) {
                
                $nav_content .= '<h2>' . $lng->msg( $section ) . '</h2><ul class="nav">';
                
                foreach( $links as $link ) {
                    
                    $nav_content .= '<li>' .
                        Linker::i(
                            $lng->msg( $link ),
                            ucfirst( $lng->msg( $link ) )
                        ) .
                    '</li>';
                    
                }
                
                $nav_content .= '</ul>';
                
            }
            
            $this->set_title( $lng->msg( 'menu' ) );
            
            $this->add_keywords( $lng->msg( 'menu' ) );
            
            $this->add_classes( 'menu' );
            
            $this->add_header(
                '<div>' . $lng->msg( 'menu' ) . '</div>' .
                getSearchBar()
            );
            
            $this->add_content(
                '<article>' .
                    $nav_content .
                '</article>' .
                '<aside>' .
                    ( new Long_Table() )->output() .
                '</aside>'
            );
            
        }
        
    }
    
?>
