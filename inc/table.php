<?php
    
    class Table {
        
        protected $allowed_props;
        
        protected $fields = [];
        protected $table = '';
        
        protected $classes = [ 'table' ];
        
        public $maxP = 7;
        public $maxG = 18;
        
        public $type = 'classification';
        public $property = 'set';
        public $current = null;
        
        function __construct() {
            
            global $_props;
            
            $this->allowed_props = $_props;
            
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
        
        protected function get_prop(
            Element $e
        ) {
            
            switch( $this->type ) {
                
                default:
                    return [];
                    break;
                
                case 'classification':
                    return ( $prop = $e->get_prop( $this->property ) )->rows > 0
                        ? [ $this->property => $prop->p[0]->val->raw() ]
                        : [];
                    break;
                
            }
            
        }
        
        protected function add_element(
            int $p,
            int $g,
            Element $e
        ) {
            
            global $lng;
            
            $classes = [ 'element' ];
            $attr = [];
            
            $phase = $e->get_prop( 'phase' )->p[0]->val->raw();
            
            foreach( array_merge( [
                'id' => $e->ID,
                'period' => $p,
                'group' => $g,
                'title' =>
                    $lng->msg(
                        'table-element-title',
                        $e->get_name(),
                        $lng->msg( $phase )
                    ),
                'phase' => $phase,
                'radioactive' => $e->is_radioactive(),
                'current' =>
                    !empty( $this->current ) &&
                    $this->current instanceof Element &&
                    $this->current->is_element() &&
                    $this->current->is_equal( $e )
            ], $this->get_prop( $e ) ) as $key => $val ) {
                
                $attr[] = $val == false ? null
                    : $key . ( is_bool( $val ) ? '' : '="' . $val . '"' );
                
            }
            
            $this->table .= '<td class="element" ' .
                    implode( ' ', array_filter( $attr ) ) . '>' .
                '<overlay></overlay>' .
                Linker::p(
                    $lng->msg( 'element' ),
                    $e->get_slug(),
                    $e->get_symbol()
                ) .
            '</td>';
            
        }
        
        public function is_allowed(
            string $prop
        ) {
            
            foreach( $this->allowed_props as $type => $group ) {
                
                if( in_array( $prop, $group ) )
                    return $type;
                
            }
            
            return false;
            
        }
        
        public function set_property(
            string $prop
        ) {
            
            if( ( $type = $this->is_allowed( $prop ) ) !== false ) {
                
                $this->type = $type;
                $this->property = $prop;
                
            }
            
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
                            strtoupper( $lng->defmsg( ( $p == 0 )
                                ? 'group-' . $g
                                : 'period-' . $p, '' ) ) .
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
                    '<td class="ex-group" colspan="' . ( $this->maxG - count( $group['fields'] ) ) . '">' .
                        $lng->msg( 'group-' . ( new Element( $element ) )->symbol ) .
                    '</td>';
                
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
