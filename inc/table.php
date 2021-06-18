<?php
    
    class Table {
        
        private $allowed_props = [
            'set', 'group', 'period', 'block', 'age', 'crystall_structure',
            'bravais', 'magnetism', 'superconductivity', 'radioactivity',
            'metal', 'goldschmidt', 'acid_base', 'basicity',
            
            'heavy_metal', 'magnetic_susceptibility', 'density', 'potential',
            'pauling', 'allen', 'mulliken', 'sanderson', 'allred_rochow',
            'ghosh_gupta', 'pearson', 'mohs', 'vickers', 'brinell',
            
            'phase', 'discovery',
            
            'radioactive', 'natural', 'native', 'vital', 'clean', 'stable',
            'noble', 'semiconductor', 'light', 'heavy', 'rare', 'platinum',
            'refractory', 'mendeleev'
        ];
        
        private $fields = [];
        private $table = '';
        
        public $maxP = 7;
        public $maxG = 18;
        
        public $property = 'set';
        public $current = null;
        
        function __construct() {
            
            $this->fetch_elements();
            
        }
        
        private function fetch_elements() {
            
            global $db;
            
            $elements = $db->query('
                SELECT      ID, e_period, e_group
                FROM        ' . $db->prefix . 'element
                ORDER BY    ID ASC
            ');
            
            while( $element = $elements->fetch_object() ) {
                
                $this->fields[ $element->e_period ][ $element->e_group ][] = new Element( $element->ID );
                
            }
            
        }
        
        public function set_property(
            string $prop
        ) {
            
            if( in_array( $prop, $this->allowed_props ) )
                $this->property = $prop;
            
        }
        
        public function set_current(
            Element $e
        ) {
            
            if( $e->is_element() )
                $this->current = $e;
            
        }
        
        public function build() {
            
            global $lng;
            
            $this->table .= '<table class="table ' . $this->property . '">';
            
            for( $p = 0; $p <= $this->maxP; $p++ ) {
                
                $this->table .= '<tr>';
                
                for( $g = 0; $g <= $this->maxG; $g++ ) {
                    
                    if( $p == 0 || $g == 0 ) {
                        
                        $this->table .= '<td class="header">' .
                            $lng->defmsg( ( $p == 0 )
                                ? 'group-' . $g
                                : 'period-' . $p, '&nbsp;' ) .
                        '</td>';
                        
                    } else {
                        
                        $field = $this->get_field( $p, $g );
                        
                        if( empty( $field ) ) {
                            
                            $this->table .= '<td class="empty">&nbsp;</td>';
                            
                        } else if( count( $field ) > 1 ) {
                            
                            $e = $field[0];
                            
                            $this->table .= '<td class="empty placeholder" period="' . $p . '" group="' . $g . '">' .
                                $e->symbol .
                            '</td>';
                            
                        } else {
                            
                            $e = $field[0];
                            
                            $this->table .= '<td class="element ' .
                                    ( !empty( $this->current ) &&
                                      $this->current instanceof Element &&
                                      $this->current->is_element() &&
                                      $this->current->is_equal( $e )
                                          ? 'current'
                                          : '' ) . '" period="' . $p . '" group="' . $g . '" id="' .
                                    $e->ID . '" title="' . $e->name . '" >' .
                                Linker::p(
                                    $lng->msg( 'element' ),
                                    $e->get_slug(),
                                    $e->get_symbol()
                                ) .
                            '</td>';
                            
                        }
                        
                    }
                                       
                }
                
                $this->table .= '</tr>';
                
            }
            
            $this->table .= '</table>';
            
        }
        
        public function output() {
            
            if( empty( $this->table ) || strlen( $this->table ) == 0 )
                $this->build();
            
            return $this->table;
            
        }
        
        public function get_legend() {
            
            
            
        }
        
        public function get_field(
            int $period,
            int $group
        ) {
            
            if( array_key_exists( $period, $this->fields ) &&
                array_key_exists( $group, $this->fields[ $period ] ) )
                return $this->fields[ $period ][ $group ];
            
            return null;
            
        }
        
    }
    
?>
