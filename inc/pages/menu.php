<?php
    
    class Menu_Page extends Page {
        
        private $nav = [
            'table' => [
                'set', 'group', 'period', 'block', 'age', 'crystal_system',
                'bravais', 'magnetism', 'superconductivity', 'radioactivity',
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
                'rare', 'platinum', 'refractory', 'mendeleev'
            ],
            'tool' => [
                'list', 'nuclide_table', 'molar_calculator'
            ]
        ];
        
        function __construct() {
            
            global $lng;
            
            $nav_content = '';
            
            foreach( $this->nav as $section => $links ) {
                
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
                    ( new mTable() )->output() .
                '</aside>'
            );
            
        }
        
    }
    
?>
