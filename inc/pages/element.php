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
                    'name_de' => [],
                    'name_lat' => [],
                    'name_en' => [],
                    'symbol' => [],
                    'atomic_number' => [],
                    'set' => [
                        'format' => 'i18n'
                    ],
                    'age' => [
                        'format' => 'i18n'
                    ],
                    'discovery' => [
                        'format' => 'datetime',
                        'dtf' => 'Y',
                        'empty' => 'unknown'
                    ],
                    'discoverer' => [
                        'format' => 'exlink',
                        'identifier' => 'https://de.wikipedia.org/w/index.php?search=$1',
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
                        'format' => 'i18n'
                    ],
                    'crystal_system' => [
                        'format' => 'i18n'
                    ],
                    'magnetism' => [
                        'format' => 'i18n'
                    ],
                    'magnetic_susceptibility' => [
                        'format' => 'exp'
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
                        'format' => 'i18n'
                    ],
                    'critical_temp' => [
                        'format' => 'temp'
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
                        'format' => 'i18n'
                    ],
                    'potential' => [
                        'format' => 'physical',
                        'unit' => 'V'
                    ],
                    'acid_base' => [
                        'format' => 'i18n'
                    ],
                    'basicity' => [
                        'format' => 'i18n'
                    ],
                    'isotopes' => [
                        'format' => 'num'
                    ]
                ],
                'electronegativity' => [
                    'pauling' => [
                        'format' => 'exp'
                    ],
                    'allen' => [
                        'format' => 'exp'
                    ],
                    'mulliken' => [
                        'format' => 'exp'
                    ],
                    'sanderson' => [
                        'format' => 'exp'
                    ],
                    'allred_rochow' => [
                        'format' => 'exp'
                    ],
                    'ghosh_gupta' => [
                        'format' => 'physical',
                        'unit' => 'eV'
                    ],
                    'pearson' => [
                        'format' => 'physical',
                        'unit' => 'eV'
                    ]
                ],
                'hardness' => [
                    'mohs' => [
                        'format' => 'exp'
                    ],
                    'vickers' => [
                        'format' => 'exp'
                    ],
                    'brinell' => [
                        'format' => 'exp'
                    ]
                ],
                'GHS' => [
                    'GHS%' => [],
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
