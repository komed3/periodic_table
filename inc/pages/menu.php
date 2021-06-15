<?php
    
    class Menu_Page extends Page {
        
        private $nav = [
            'table' => [
                'set', 'group', 'period', 'block', 'age', 'crystal_system',
                'magnetism', 'superconductivity', 'radioactivity',
                'metal', 'goldschmidt', 'acid_base', 'basicity'
            ],
            'trend' => [
                'heavy_metal', 'magnetic_susceptibility', 'density',
                'potential', 'pauling', 'allen', 'mulliken', 'sanderson',
                'allred_rochow', 'ghosh_gupta', 'pearson', 'mohs',
                'vickers', 'brinell'
            ],
            'interactive' => [
                'phase', 'discovery'
            ],
            'property' => [
                'radioactive', 'natural', 'native', 'vital', 'clean',
                'stable', 'noble', 'semiconductor', 'light', 'heavy',
                'rare', 'platinum', 'refractory', 'mendeleev', 
            ],
            'tool' => [
                'list', 'nuclide_table', 'molar_calculator'
            ]
        ];
        
        function __construct() {
            
            global $lng;
            
            $nav_content = '';
            
            foreach( $this->nav as $section => $links ) {
                
                $nav_content .= '<li>' .
                    '<h3>' . $lng->msg( $section ) . '</h3>' .
                    '<ul>';
                
                foreach( $links as $link ) {
                    
                    $nav_content .= '<li>' .
                        Linker::i(
                            $lng->msg( $link ),
                            ucfirst( $lng->msg( $link ) )
                        ) .
                    '</li>';
                    
                }
                
                $nav_content .= '</ul></li>';
                
            }
            
            $this->set_title( $lng->msg( 'menu' ) );
            
            $this->add_keywords( $lng->msg( 'menu' ) );
            
            $this->add_classes( 'menu' );
            
            $this->add_header( $lng->msg( 'menu' ) );
            
            $this->add_content(
                '<article>' .
                    '<ul class="navigation">' .
                        $nav_content .
                    '</ul>' .
                '</article>'
            );
            
        }
        
    }
    
?>
