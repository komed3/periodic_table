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
                    '<h1>' .
                        '<prev>' .
                            ( ( $prev = $e->get_prev() )->is_element()
                                ? Linker::p( 'element', $prev->get_name(), $prev->get_symbol(), [
                                    'title' => $prev->get_name()
                                ] ) : '' ) .
                        '</prev>' .
                        '<element>' .
                            $e->get_symbol() .
                            $e->get_name() .
                        '</element>' .
                        '<next>' .
                            ( ( $next = $e->get_next() )->is_element()
                                ? Linker::p( 'element', $next->get_name(), $next->get_symbol(), [
                                    'title' => $next->get_name()
                                ] ) : '' ) .
                        '</next>' .
                    '</h1>' .
                    '<p class="description">' .
                        $e->get_image() .
                        ( new Formatter( $e->description ) )->str() .
                    '</p>' .
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
                    'symbol' => [],
                    'atomic_number' => [],
                    'name_de' => [],
                    'name_lat' => [],
                    'name_en' => [],
                    'age' => [
                        'format' => 'i18n',
                        'link' => true
                    ],
                    'discovery' => [
                        'format' => 'datetime',
                        'dtf' => 'Y',
                        'empty' => 'unknown',
                        'link' => true
                    ],
                    'discoverer' => [
                        'format' => 'exlink',
                        'identifier' => 'https://de.wikipedia.org/w/index.php?search=$1',
                        'empty' => 'unknown'
                    ]
                ],
                'classification' => [
                    'set' => [
                        'format' => 'i18n',
                        'link' => true
                    ],
                    'group' => [
                        'format' => 'i18n',
                        'prefix' => 'group-',
                        'link' => true
                    ],
                    'period' => [
                        'format' => 'i18n',
                        'prefix' => 'period-',
                        'link' => true
                    ],
                    'block' => [
                        'format' => 'i18n',
                        'prefix' => 'block-',
                        'link' => true
                    ],
                    'term_symbol' => []
                ],
                'registration' => [
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
                    ],
                    'InChI' => []
                ],
                'frequencies' => [
                    'mf_earth' => [
                        'format' => 'pct'
                    ],
                    'freq_solar' => [
                        'format' => 'exp'
                    ],
                    'freq_earth' => [
                        'format' => 'physical',
                        'unit' => 'ppmw'
                    ],
                    'freq_bios' => [
                        'format' => 'physical',
                        'unit' => 'ppmw'
                    ],
                    'freq_cover' => [
                        'format' => 'physical',
                        'unit' => 'ppmw'
                    ],
                    'freq_ocean' => [
                        'format' => 'physical',
                        'unit' => 'ppmw'
                    ],
                    'freq_body' => [
                        'format' => 'physical',
                        'unit' => 'mol'
                    ]
                ],
                'atomic' => [
                    'atomic_mass' => [
                        'format' => 'physical',
                        'unit' => 'u'
                    ],
                    'r_calc' => [
                        'format' => 'physical',
                        'unit' => 'pm'
                    ],
                    'r_emp' => [
                        'format' => 'physical',
                        'unit' => 'pm'
                    ],
                    'r_cov' => [
                        'format' => 'physical',
                        'unit' => 'pm'
                    ],
                    'r_cov1' => [
                        'format' => 'physical',
                        'unit' => 'pm'
                    ],
                    'r_cov2' => [
                        'format' => 'physical',
                        'unit' => 'pm'
                    ],
                    'r_cov3' => [
                        'format' => 'physical',
                        'unit' => 'pm'
                    ],
                    'r_vdw1' => [
                        'format' => 'physical',
                        'unit' => 'pm'
                    ],
                    'r_vdw2' => [
                        'format' => 'physical',
                        'unit' => 'pm'
                    ],
                    'configuration' => [],
                    'ionization' => [
                        'format' => 'physical',
                        'unit' => 'eV'
                    ],
                    'electron_affinity' => [
                        'format' => 'physical',
                        'unit' => 'eV'
                    ]
                ],
                'physical' => [
                    'phase' => [
                        'format' => 'i18n',
                        'link' => true
                    ],
                    'crystal_system' => [
                        'format' => 'i18n',
                        'link' => true
                    ],
                    'magnetism' => [
                        'format' => 'i18n',
                        'link' => true
                    ],
                    'magnetic_susceptibility' => [
                        'format' => 'exp',
                        'link' => true
                    ],
                    'density' => [
                        'format' => 'physical',
                        'unit' => 'g·m<−3>'
                    ],
                    'molar_volume' => [
                        'format' => 'physical',
                        'unit' => 'm<3>·mol<−1>'
                    ],
                    'melting' => [
                        'format' => 'temp'
                    ],
                    'boiling' => [
                        'format' => 'temp'
                    ],
                    'sublimation' => [
                        'format' => 'temp'
                    ],
                    'triple' => [
                        'format' => 'temp'
                    ],
                    'debye_temp' => [
                        'format' => 'temp'
                    ],
                    'vaporization_enthalpy' => [
                        'format' => 'physical',
                        'unit' => 'kJ·mol<−1>'
                    ],
                    'fusion_enthalpy' => [
                        'format' => 'physical',
                        'unit' => 'kJ·mol<−1>'
                    ],
                    'work_function' => [
                        'format' => 'physical',
                        'unit' => 'eV'
                    ],
                    'vapor_pressure' => [
                        'format' => 'physical',
                        'unit' => 'Pa'
                    ],
                    'sound_speed' => [
                        'format' => 'physical',
                        'unit' => 'm·s<−1>'
                    ],
                    'specific_heat' => [
                        'format' => 'physical',
                        'unit' => 'J·kg<−1>·K<−1>'
                    ],
                    'electrical_conductivity' => [
                        'format' => 'physical',
                        'unit' => 'A·V<−1>·m<−1>'
                    ],
                    'thermal_conductivity' => [
                        'format' => 'physical',
                        'unit' => 'W·m<−1>·K<−1>'
                    ],
                    'superconductivity' => [
                        'format' => 'i18n',
                        'empty' => 'no',
                        'link' => true
                    ],
                    'critical_temp' => [
                        'format' => 'temp'
                    ],
                    'radioactivity' => [
                        'format' => 'i18n',
                        'link' => true
                    ]
                ],
                'chemical' => [
                    'oxidation' => [
                        'format' => 'str'
                    ],
                    'metal' => [
                        'format' => 'i18n'
                    ],
                    'goldschmidt' => [
                        'format' => 'i18n',
                        'link' => true
                    ],
                    'potential' => [
                        'format' => 'physical',
                        'unit' => 'V'
                    ],
                    'acid_base' => [
                        'format' => 'i18n',
                        'empty' => 'unknown',
                        'link' => true
                    ],
                    'basicity' => [
                        'format' => 'i18n',
                        'empty' => 'unknown',
                        'link' => true
                    ],
                    'isotopes' => [
                        'format' => 'num',
                        'empty' => 0
                    ]
                ],
                'electronegativity' => [
                    'pauling' => [
                        'format' => 'exp',
                        'empty' => 'undefined',
                        'link' => true
                    ],
                    'allen' => [
                        'format' => 'exp',
                        'empty' => 'undefined',
                        'link' => true
                    ],
                    'mulliken' => [
                        'format' => 'exp',
                        'empty' => 'undefined',
                        'link' => true
                    ],
                    'sanderson' => [
                        'format' => 'exp',
                        'empty' => 'undefined',
                        'link' => true
                    ],
                    'allred_rochow' => [
                        'format' => 'exp',
                        'empty' => 'undefined',
                        'link' => true
                    ],
                    'ghosh_gupta' => [
                        'format' => 'physical',
                        'unit' => 'eV',
                        'empty' => 'undefined',
                        'link' => true
                    ],
                    'pearson' => [
                        'format' => 'physical',
                        'unit' => 'eV',
                        'empty' => 'undefined',
                        'link' => true
                    ]
                ],
                'hardness' => [
                    'mohs' => [
                        'format' => 'exp',
                        'empty' => 'undefined',
                        'link' => true
                    ],
                    'vickers' => [
                        'format' => 'exp',
                        'empty' => 'undefined',
                        'link' => true
                    ],
                    'brinell' => [
                        'format' => 'exp',
                        'empty' => 'undefined',
                        'link' => true
                    ]
                ],
                'GHS' => [
                    'GHS%' => [
                        'format' => 'img',
                        'classes' => [ 'pictogram' ]
                    ],
                    'CDG%' => [
                        'format' => 'img',
                        'classes' => [ 'pictogram' ]
                    ],
                    'H' => [],
                    'EUH' => [],
                    'P' => []
                ]
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
                            
                            case 'datetime':
                                $val = $prop->val->datetime(
                                    empty( $params['dtf'] ) ? 'Y-m-d' : $params['dtf']
                                );
                                break;
                            
                            case 'num':
                                $val = $prop->val->num(
                                    empty( $params['digits'] ) ? false : $params['digits']
                                );
                                break;
                            
                            case 'pct':
                                $val = $prop->val->pct(
                                    empty( $params['digits'] ) ? false : $params['digits']
                                );
                                break;
                            
                            case 'exp':
                                $val = $prop->val->exp(
                                    empty( $params['digits'] ) ? false : $params['digits'],
                                    empty( $params['p10'] ) ? true : $params['p10']
                                );
                                break;
                            
                            case 'physical':
                                $val = $prop->val->physical(
                                    empty( $params['digits'] ) ? false : $params['digits'],
                                    empty( $params['unit'] ) ? null : $params['unit']
                                );
                                break;
                            
                            case 'temp':
                                $val = $prop->val->temp(
                                    empty( $params['celsius'] ) ? true : $params['celsius'],
                                    empty( $params['digits'] ) ? false : $params['digits']
                                );
                                break;
                            
                            case 'exlink':
                                $val = $prop->val->exlink(
                                    empty( $params['identifier'] ) ? null : $params['identifier']
                                );
                                break;
                            
                            case 'i18n':
                                $val = $lng->msg(
                                    ( empty( $params['prefix'] ) ? '' : $params['prefix'] ) .
                                    $prop->val->raw()
                                );
                                break;
                            
                            case 'img':
                                $val = ( new Formatter( $prop->key->raw() . '.png' ) )->img(
                                    $lng->msg( $prop->key->raw() ),
                                    empty( $params['classes'] ) ? [] : $params['classes']
                                );
                                break;
                            
                        }
                        
                        $proplines[] = '<property class="pf-' . $format . '">' .
                            $val .
                            ( ( $ref = $e->get_ref( $key ) )->rows > 0 && ( !isset( $params['ref'] ) || $params['ref'] )
                                ? '<ref>' . $lng->defmsg( '@', '@' ) . $ref->p[0]->val->temp() . '</ref>' : '' ) .
                            ( strlen( $prop->com->raw() ) > 0
                                ? '<comment>' . $prop->com->str() . '</comment>' : '' ) .
                        '</property>';
                        
                    }
                    
                    $proplist[] = '<tr class="property p-' . $key . '">' .
                        '<th>' . ( !empty( $params['link'] ) && $params['link']
                            ? Linker::i( $lng->msg( $key ), $lng->msg( $key ) )
                            : $lng->msg( $key ) ) . '</th>' .
                        '<td>' . ( $propres->rows == 0
                            ? $lng->msg( empty( $params['empty'] )
                                ? '&ndash;'
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
