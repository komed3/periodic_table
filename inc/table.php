<?php
    
    class Table {
        
        protected $allowed_props = [
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
        
        protected $fields = [];
        protected $table = '';
        
        protected $classes = [ 'table' ];
        
        public $maxP = 7;
        public $maxG = 18;
        
        public $property = 'set';
        public $current = null;
        
        function __construct() {
            
            $this->fetch_elements();
            
        }
        
        protected function fetch_elements() {
            
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
        
        protected function add_element(
            int $p,
            int $g,
            Element $e
        ) {
            
            global $lng;
            
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
        
        public function add_classes(
            string ... $classes
        ) {
            
            foreach( $classes as $class ) {
                
                $this->classes[] = $class;
                
            }
            
        }
        
        public function build() {
            
            global $lng;
            
            $exGroups = [];
            
            $this->table .= '<table class="' . implode( ' ', $this->classes ) . ' ' . $this->property . '">';
            
            for( $p = 0; $p <= $this->maxP; $p++ ) {
                
                $this->table .= '<tr>';
                
                for( $g = 0; $g <= $this->maxG; $g++ ) {
                    
                    if( $p == 0 || $g == 0 ) {
                        
                        $this->table .= '<th class="header">' .
                            $lng->defmsg( ( $p == 0 )
                                ? 'group-' . $g
                                : 'period-' . $p, '&nbsp;' ) .
                        '</th>';
                        
                    } else {
                        
                        $field = $this->get_field( $p, $g );
                        
                        if( empty( $field ) ) {
                            
                            $this->table .= '<td class="empty">&nbsp;</td>';
                            
                        } else if( count( $field ) > 1 ) {
                            
                            $e = $field[0];
                            
                            $exGroups[ $e->ID ] = [
                                'fields' => $field,
                                'p' => $p,
                                'g' => $g
                            ];
                            
                            $this->table .= '<td class="empty placeholder" period="' . $p . '" group="' . $g . '">' .
                                $e->symbol .
                            '</td>';
                            
                        } else {
                            
                            $this->add_element( $p, $g, $field[0] );
                            
                        }
                        
                    }
                                       
                }
                
                $this->table .= '</tr>';
                
            }
            
            # add external groups
            
            $this->table .= '<tr class="empty-row"><td class="empty" colspan="' . $this->maxG . '"></td></tr>';
            
            foreach( $exGroups as $element => $group ) {
                
                $this->table .= '<tr>' .
                    '<th>&nbsp;</th>' .
                    '<th class="ex-group" colspan="' . ( $this->maxG - count( $group['fields'] ) ) . '">' .
                        ( new Element( $element ) )->get_name() .
                    '</th>';
                
                foreach( $group['fields'] as $e ) {
                    
                    $this->add_element( $group['p'], $group['g'], $e );
                    
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
