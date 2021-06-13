<?php
    
    class Element_Page extends Page {
        
        function __construct(
            Element $e
        ) {
            
            global $lng;
            
            $this->set_title( $lng->msg( 'element-page-title', $e->ID, $e->symbol, $e->get_name() ) );
            
            $this->set_description( $e->description );
            $this->add_keywords( $e->ID, $e->symbol, $e->get_name() );
            
            $this->add_classes( 'element' );
            
            $this->add_content(
                '<article>' .
                    '<h1>' . $e->get_symbol() . $e->get_name() . '</h1>' .
                    '<p>' . ( new Formatter( $e->description ) )->str() . '</p>' .
                    $this->get_sections( $e ) .
                '</article>'
            );
            
        }
        
        private function get_sections(
            Element $e
        ) {
            
            global $lng;
            
            $sections = [];
            
            foreach( [
                'general' => [
                    'set' => [
                        'format' => 'i18n'
                    ],
                    'age' => [
                        'format' => 'i18n'
                    ],
                    'discovery' => [
                        'empty' => 'unknown'
                    ],
                    'discoverer' => [
                        'format' => 'exlink',
                        'empty' => 'unknown'
                    ]
                ],
                'classification' => [
                    'CAS' => [
                        'format' => 'exlink',
                        'identifier' => 'https://commonchemistry.cas.org/detail?cas_rn=$1'
                    ],
                    'EG' => [
                        'format' => 'exlink'
                    ],
                    'ECHA' => [
                        'format' => 'exlink',
                        'identifier' => 'https://echa.europa.eu/substance-information/-/substanceinfo/$1'
                    ],
                    'ATC' => [
                        'format' => 'exlink',
                        'identifier' => 'https://www.whocc.no/atc_ddd_index/?code=$1'
                    ]
                ],
                'frequencies' => [
                    'mf_earth' => [
                        'format' => 'si'
                    ],
                    'freq_solar' => [
                        'format' => 'si'
                    ],
                    'freq_earth' => [
                        'format' => 'si'
                    ],
                    'freq_bios' => [
                        'format' => 'si'
                    ],
                    'freq_cover' => [
                        'format' => 'si'
                    ],
                    'freq_ocean' => [
                        'format' => 'si'
                    ]
                ],
                'atomic' => [],
                'physical' => [],
                'chemical' => [],
                'GHS' => []
            ] as $section => $props ) {
                
                $proplist = [];
                
                foreach( $props as $key => $params ) {
                    
                    $propres = $e->get_prop( $key );
                    
                    $proplines = [];
                    
                    foreach( $propres->p as $prop ) {
                        
                        switch( $format = empty( $params['format'] ) ? 'str' : $params['format'] ) {
                            
                            default:
                            case 'str':
                                $val = $prop->val->str();
                                break;
                            
                            case 'raw':
                                $val = $prop->val->raw();
                                break;
                            
                            case 'num':
                                $val = $prop->val->num(
                                    empty( $params['digits'] ) ? false : $params['digits']
                                );
                                break;
                            
                            case 'exp':
                                $val = $prop->val->exp(
                                    empty( $params['digits'] ) ? false : $params['digits'],
                                    empty( $params['p10'] ) ? true : $params['p10']
                                );
                                break;
                            
                            case 'exlink':
                                $val = $prop->val->exlink(
                                    empty( $params['identifier'] ) ? null : $params['identifier']
                                );
                                break;
                            
                        }
                        
                        $proplines[] = '<property class="pf-' . $format . '">' .
                            $val . ( strlen( $prop->com->raw() ) == 0
                                ? '' : '<comment>' . $prop->com->str() . '</comment>' ) .
                        '</property>';
                        
                    }
                    
                    $proplist[] = '<tr class="property p-' . $key . '">' .
                        '<th>' . $lng->msg( $key ) . '</th>' .
                        '<td>' . ( $propres->rows == 0
                            ? $lng->msg( empty( $params['empty'] )
                                ? 'undefined'
                                : $params['empty'] )
                            : implode( $proplines ) ) . '</td>' .
                    '</tr>';
                    
                }
                
                $sections[] = '<tr id="' . $section . '" class="headline">' .
                    '<th colspan="2">' . $lng->msg( 'section-' . $section ) . '</th>' .
                '</tr>' . implode( '', $proplist );
                
            }
            
            return '<table class="props">' . implode( '', $sections ) . '</table>';
            
        }
        
    }
    
?>
