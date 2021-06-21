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
            
            $this->add_header(
                '<element>' .
                    $e->get_symbol() .
                    $e->get_name() .
                '</element>' .
                ( ( $prev = $e->get_prev() )->is_element()
                    ? '<prev>' .
                          Linker::p( 'element', $prev->get_slug(), $prev->get_symbol(), [
                              'title' => $prev->get_name()
                          ] ) .
                      '</prev>' : '' ) .
                ( ( $next = $e->get_next() )->is_element()
                    ? '<next>' .
                          Linker::p( 'element', $next->get_slug(), $next->get_symbol(), [
                              'title' => $next->get_name()
                          ] ) .
                      '</next>' : '' )
            );
            
            $long_table = new Long_Table();
            $long_table->set_current( $e );
            
            $this->add_content(
                '<article>' .
                    '<p class="description">' .
                        $e->get_image() .
                        ( new Formatter( $e->description ) )->str() .
                    '</p>' .
                    $this->get_sections( $e, $long_table ) .
                '</article>' .
                '<aside>' .
                    $long_table->output() .
                '</aside>'
            );
            
        }
        
        private function get_sections(
            Element $e,
            Table $t
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
                        'empty' => 'unknown'
                    ],
                    'discovery' => [
                        'empty' => 'unknown'
                    ],
                    'discoverer' => [
                        'format' => 'exlink',
                        'identifier' => 'https://de.wikipedia.org/w/index.php?search=$1',
                        'empty' => 'unknown'
                    ]
                ],
                'classification' => [
                    'set' => [
                        'format' => 'i18n'
                    ],
                    'group' => [
                        'format' => 'i18n',
                        'prefix' => 'group-name-'
                    ],
                    'CAS_group' => [],
                    'IUPAC_group' => [],
                    'period' => [
                        'format' => 'i18n',
                        'prefix' => 'period-'
                    ],
                    'block' => [
                        'format' => 'i18n',
                        'prefix' => 'block-'
                    ],
                    'term_symbol' => []
                ],
                'registration' => [
                    'CAS' => [
                        'format' => 'exlink',
                        'identifier' => 'https://commonchemistry.cas.org/detail?cas_rn=$1',
                        'empty' => false
                    ],
                    'EG' => [
                        'format' => 'exlink',
                        'empty' => false
                    ],
                    'ECHA' => [
                        'format' => 'exlink',
                        'identifier' => 'https://echa.europa.eu/substance-information/-/substanceinfo/$1',
                        'empty' => false
                    ],
                    'ATC' => [
                        'format' => 'exlink',
                        'identifier' => 'https://www.whocc.no/atc_ddd_index/?code=$1',
                        'empty' => false
                    ],
                    'InChI' => [
                        'empty' => false
                    ]
                ],
                'frequencies' => [
                    'mf_earth' => [
                        'format' => 'pct',
                        'empty' => false
                    ],
                    'freq_solar' => [
                        'format' => 'exp',
                        'empty' => false
                    ],
                    'freq_earth' => [
                        'format' => 'physical',
                        'unit' => 'ppmw',
                        'empty' => false
                    ],
                    'freq_bios' => [
                        'format' => 'physical',
                        'unit' => 'ppmw',
                        'empty' => false
                    ],
                    'freq_cover' => [
                        'format' => 'physical',
                        'unit' => 'ppmw',
                        'empty' => false
                    ],
                    'freq_ocean' => [
                        'format' => 'physical',
                        'unit' => 'ppmw',
                        'empty' => false
                    ],
                    'freq_body' => [
                        'format' => 'physical',
                        'unit' => 'mol',
                        'empty' => false
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
                    'electron_affinity' => [
                        'format' => 'physical',
                        'unit' => 'eV'
                    ],
                    'quantum_efficiency' => [
                        'format' => 'exp'
                    ],
                    'coster_kronig' => [
                        'format' => 'exp'
                    ]
                ],
                'ionization' => [
                    'ionization%' => [
                        'format' => 'physical',
                        'unit' => 'eV',
                        'empty' => false
                    ]
                ],
                'physical' => [
                    'phase' => [
                        'format' => 'i18n'
                    ],
                    'crystal_system' => [
                        'format' => 'i18n'
                    ],
                    'bravais' => [
                        'format' => 'i18n'
                    ],
                    'magnetism' => [
                        'format' => 'i18n'
                    ],
                    'magnetic_susceptibility' => [
                        'format' => 'exp'
                    ],
                    'curie_temp' => [
                        'format' => 'temp',
                        'empty' => false
                    ],
                    'density' => [
                        'format' => 'physical',
                        'unit' => 'g·m<−3>'
                    ],
                    'molar_volume' => [
                        'format' => 'physical',
                        'unit' => 'm<3>·mol<−1>'
                    ],
                    'young_modulus' => [
                        'format' => 'physical',
                        'unit' => 'GPa'
                    ],
                    'bulk_modulus' => [
                        'format' => 'physical',
                        'unit' => 'GPa'
                    ],
                    'compressibility' => [
                        'format' => 'physical',
                        'unit' => 'GPa'
                    ],
                    'poisson' => [
                        'format' => 'exp'
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
                    'thermal_conductivity' => [
                        'format' => 'physical',
                        'unit' => 'W·m<−1>·K<−1>'
                    ],
                    'thermal_diffusivity' => [
                        'format' => 'physical',
                        'unit' => 'mm<2>·s<-1>'
                    ],
                    'thermal_expansion' => [
                        'format' => 'physical',
                        'unit' => 'μm·m<-1>·K<-1>'
                    ],
                    'electrical_conductivity' => [
                        'format' => 'physical',
                        'unit' => 'A·V<−1>·m<−1>'
                    ],
                    'resistance' => [
                        'format' => 'physical',
                        'unit' => 'Ωm'
                    ],
                    'formation_enthalpy' => [
                        'format' => 'physical',
                        'unit' => 'kJ·mol<-1>'
                    ],
                    'gibbs_energy' => [
                        'format' => 'physical',
                        'unit' => 'kJ·mol<-1>'
                    ],
                    'standard_entropy' => [
                        'format' => 'physical',
                        'unit' => 'J·mol<-1>·K<-1>'
                    ],
                    'superconductivity' => [
                        'format' => 'i18n',
                        'empty' => 'no'
                    ],
                    'critical_temp' => [
                        'format' => 'temp'
                    ],
                    'radioactivity' => [
                        'format' => 'i18n'
                    ]
                ],
                'chemical' => [
                    'oxidation' => [
                        'format' => 'str'
                    ],
                    'metal' => [
                        'format' => 'i18n'
                    ],
                    'heavy_metal' => [
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
                        'format' => 'i18n',
                        'empty' => 'unknown'
                    ],
                    'basicity' => [
                        'format' => 'i18n',
                        'empty' => 'unknown'
                    ],
                    'isotopes' => [
                        'format' => 'num',
                        'empty' => 0
                    ]
                ],
                'electronegativity' => [
                    'pauling' => [
                        'format' => 'exp',
                        'empty' => 'undefined'
                    ],
                    'allen' => [
                        'format' => 'exp',
                        'empty' => 'undefined'
                    ],
                    'mulliken' => [
                        'format' => 'exp',
                        'empty' => 'undefined'
                    ],
                    'sanderson' => [
                        'format' => 'exp',
                        'empty' => 'undefined'
                    ],
                    'allred_rochow' => [
                        'format' => 'exp',
                        'empty' => 'undefined'
                    ],
                    'ghosh_gupta' => [
                        'format' => 'physical',
                        'unit' => 'eV',
                        'empty' => 'undefined'
                    ],
                    'pearson' => [
                        'format' => 'physical',
                        'unit' => 'eV',
                        'empty' => 'undefined'
                    ]
                ],
                'hardness' => [
                    'mohs' => [
                        'format' => 'exp',
                        'empty' => 'undefined'
                    ],
                    'vickers' => [
                        'format' => 'exp',
                        'empty' => 'undefined'
                    ],
                    'brinell' => [
                        'format' => 'exp',
                        'empty' => 'undefined'
                    ]
                ],
                'GHS' => [
                    'GHS%' => [
                        'format' => 'img',
                        'classes' => [ 'pictogram' ],
                        'empty' => false
                    ],
                    'ADR%' => [
                        'format' => 'img',
                        'classes' => [ 'pictogram' ],
                        'empty' => false
                    ],
                    'H' => [
                        'empty' => 'none'
                    ],
                    'EUH' => [
                        'empty' => 'none'
                    ],
                    'P' => [
                        'empty' => 'none'
                    ],
                    'toxicity' => [
                        'empty' => false
                    ]
                ]
            ] as $section => $props ) {
                
                $proplist = [];
                
                foreach( $props as $key => $params ) {
                    
                    $propres = $e->get_prop( $key );
                    
                    if( $propres->rows == 0 && isset( $params['empty'] ) && !$params['empty'] )
                        continue;
                    
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
                                $val = ( new Formatter( 'pictograms/' . $prop->key->raw() . '.svg' ) )->img(
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
                        '<th>' .
                            ( $t->is_allowed( $key )
                                ? Linker::i( $lng->msg( $key ), $lng->msg( $key ) )
                                : $lng->msg( $key )
                            ) . ( $lng->is_defined( $key . '_glossary' )
                                ? '&nbsp;' . Linker::i( $lng->msg( 'glossary' ), 'help', [
                                      'class' => 'icon glossary',
                                      'title' => $lng->msg( $key . '_glossary' )
                                  ], $key )
                                : ''
                            ) .
                        '</th>' .
                        '<td>' .
                            ( $propres->rows == 0
                                ? $lng->msg( empty( $params['empty'] )
                                    ? '&ndash;'
                                    : $params['empty'] )
                                : implode( $proplines )
                            ) .
                        '</td>' .
                    '</tr>';
                    
                }
                
                if( count( $proplist ) == 0 )
                    continue;
                
                $sections[] = '<tr id="' . $section . '" class="headline">' .
                    '<th colspan="2">' . $lng->msg( 'section-' . $section ) . '</th>' .
                '</tr>' . implode( '', $proplist );
                
            }
            
            return '<table class="props">' . implode( '', $sections ) . '</table>';
            
        }
        
    }
    
?>
