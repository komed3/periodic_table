<?php
    
    class Table {
        
        protected $allowed_props;
        protected $trend_schemes = [
            'allen' => [ 'fire' ],
            'allred_rochow' => [ 'fire' ],
            'brinell' => [ 'green' ],
            'density' => [ 'ice' ],
            'electron_affinity' => [ 'fire' ],
            'ghosh_gupta' => [ 'fire' ],
            'magnetic_susceptibility' => [ 'ice', true ],
            'mohs' => [ 'green' ],
            'mulliken' => [ 'fire' ],
            'pauling' => [ 'fire' ],
            'pearson' => [ 'fire' ],
            'potential' => [ 'ice', true ],
            'sanderson' => [ 'fire' ],
            'vickers' => [ 'green' ]
        ];
        
        protected $fields = [];
        protected $table = '';
        
        protected $classes = [ 'table' ];
        
        public $maxP = 7;
        public $maxG = 18;
        
        public $type = 'classification';
        public $property = 'set';
        public $scheme = [];
        public $props = [];
        public $range = null;
        
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
                
                $this->fields[ $element->e_period ][ $element->e_group ][] =
                    new Element( $element->ID );
                
            }
            
        }
        
        protected function get_scheme() {
            
            if( $this->type == 'trend' &&
                array_key_exists( $this->property, $this->trend_schemes ) ) {
                
                $this->scheme = $this->trend_schemes[ $this->property ];
                
                $this->add_classes( $this->scheme[0] );
                
            }
            
        }
        
        protected function get_range() {
            
            global $db;
            
            $this->range = array_map( 'doubleval', $db->query('
                SELECT  MIN( CONVERT( p_value, decimal( 65, 38 ) ) ) AS min,
                        MAX( CONVERT( p_value, decimal( 65, 38 ) ) ) AS max
                FROM    property
                WHERE   p_key = "' . $this->property . '"
            ')->fetch_assoc() );
            
        }
        
        protected function calc_range(
            $value
        ) {
            
            if( $this->type == 'trend' && empty( $this->range ) )
                $this->get_range();
            
            return ( count( $this->scheme ) == 2 && $this->scheme[1] )
                ? ceil( abs( $value ) /
                    abs( $this->range[ $value < 0 ? 'min' : 'max' ] ) * 9 )
                : ceil( ( $value - $this->range['min'] ) /
                    abs( $this->range['max'] - $this->range['min'] ) * 9 );
            
        }
        
        protected function get_ival(
            $default = null
        ) {
            
            global $url;
            
            return !empty( $url[1] ) && is_numeric( $url[1] )
                ? $url[1] : $default;
            
        }
        
        protected function get_interactive(
            Element $e
        ) {
            
            switch( $this->property ) {
                
                default:
                    return [];
                
                case 'discovery':
                    return [ 'prop' => intval(
                        ( $prop = $e->get_prop( $this->property ) )->rows == 0 ||
                        intval( $prop->p[0]->val->raw() ) <= $this->get_ival( 0 )
                    ) ];
                
            }
            
        }
        
        protected function get_prop(
            Element $e
        ) {
            
            switch( $this->type ) {
                
                default:
                    return [];
                
                case 'classification':
                    return ( $prop = $e->get_prop( $this->property ) )->rows > 0
                        ? [ $this->property => $prop->p[0]->val->raw() ]
                        : [];
                
                case 'trend':
                    return ( $prop = $e->get_prop( $this->property ) )->rows > 0
                        ? [ 'trend' => $this->calc_range( doubleval( $prop->p[0]->val->raw() ) ) ]
                        : [];
                
                case 'interactive':
                    return $this->get_interactive( $e );
                
                case 'property':
                    return [
                        $this->property => ( $prop = $e->bool_prop( $this->property ) ),
                        'prop' => intval( $prop )
                    ];
                
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
            
            foreach( array_merge( [
                'id' => $e->ID,
                'period' => $p,
                'group' => $g,
                'title' => $e->get_name(),
                'phase' => $e->get_prop( 'phase' )->p[0]->val->raw(),
                'radioactive' => $e->is_radioactive(),
                'current' =>
                    !empty( $this->current ) &&
                    $this->current instanceof Element &&
                    $this->current->is_element() &&
                    $this->current->is_equal( $e )
            ], ( $prop = $this->get_prop( $e ) ) ) as $key => $val ) {
                
                $attr[] = $val == false ? null
                    : $key . ( is_bool( $val ) ? '' : '="' . $val . '"' );
                
            }
            
            $this->props = array_unique( array_merge(
                $this->props,
                array_values( $prop )
            ) );
            
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
        
        protected function open_table() {
            
            $this->get_scheme();
            
            $this->table .= '<table class="' . implode( ' ', array_merge( $this->classes, [
                $this->type,
                $this->property
            ] ) ) . '">';
            
        }
        
        protected function build_legend(
            array $entries = []
        ) {
            
            global $lng;
            
            $legend = [];
            
            foreach( $entries as $entry ) {
                
                $legend[] = '<entry val="' . $entry . '">' .
                    '<key></key>' .
                    '<label>' .
                        $lng->msg( $entry ) .
                    '</label>' .
                '</entry>';
                
            }
            
            return '<legend type="' . $this->type . '" property="' . $this->property . '">' .
                implode( '', $legend ) .
            '</legend>';
            
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
        
        public function get_legend() {
            
            switch( $this->type ) {
                
                default:
                    return '';
                
                case 'classification':
                    sort( $this->props, SORT_NATURAL | SORT_FLAG_CASE );
                    
                    return $this->build_legend(
                        array_merge(
                            $this->props,
                            [ 'unknown' ]
                        )
                    );
                
                case 'trend':
                    return '<trend property="' . $this->property . '" scheme="' . $this->scheme[0] . '">' .
                        '<bar></bar>' .
                        '<val start>' .
                            ( count( $this->scheme ) == 2 && $this->scheme[1]
                                ? '0'
                                : ( new Formatter( $this->range['min'] ) )->exp() ) .
                        '</val>' .
                        '<val end>' .
                            ( count( $this->scheme ) == 2 && $this->scheme[1]
                                ? ( new Formatter( $this->range['min'] ) )->exp() . '/'
                                : '' ) .
                            ( new Formatter( $this->range['max'] ) )->exp() .
                        '</val>' .
                    '</trend>';
                
                case 'property':
                    return $this->build_legend(
                        [ 'yes', 'no' ]
                    );
                
            }
            
        }
        
        public function get_menu() {
            
            global $_IP, $lng;
            
            $options = '';
            
            foreach( $this->allowed_props as $group => $props ) {
                
                $options .= '<optgroup label="' . $lng->msg( $group ) . '">';
                
                foreach( $props as $prop ) {
                    
                    $options .= '<option value="' . Linker::l( $lng->msg( $prop ) ) . '" ' .
                        ( $prop == $this->property ? 'selected' : '' ) . '>' .
                        $lng->msg( $prop ) .
                    '</option>';
                    
                }
                
                $options .= '</optgroup>';
                
            }
            
            return '<select class="menu" onchange=\'location.href="' . $_IP . '"+this.value;\'>' .
                $options .
            '</select>';
            
        }
        
        public function build() {
            
            global $lng;
            
            $exGroups = [];
            
            # open table
            
            $this->open_table();
            
            # walk through periods and groups
            
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
            
            $this->table .= '<tr class="empty-row">' .
                '<td class="empty" colspan="' . ( $this->maxG + 1 ) . '">&nbsp;</td>' .
            '</tr>';
            
            foreach( $exGroups as $element => $group ) {
                
                $this->table .= '<tr>' .
                    '<th>&nbsp;</th>' .
                    '<td class="label ex-group" colspan="' . ( $label = $this->maxG - count( $group['fields'] ) ) . '">' .
                        $lng->msg( 'group-' . ( new Element( $element ) )->symbol ) .
                    '</td>';
                
                foreach( $group['fields'] as $e ) {
                    
                    $this->add_element( $group['p'], $group['g'], $e );
                    
                }
                
                $this->table .= '</tr>';
                
            }
            
            # add legend
            
            $this->table .= '<tr class="empty-row">' .
                '<td class="empty" colspan="' . ( $this->maxG + 1 ) . '">&nbsp;</td>' .
            '</tr>' .
            '<tr>' .
                '<th>&nbsp;</th>' .
                '<td class="menu" colspan="' . $label . '">' .
                    $this->get_menu() .
                '</td>' .
                '<td class="legend" colspan="' . ( $this->maxG - $label ) . '">' .
                    $this->get_legend() .
                '</td>' .
            '</tr>';
            
            # close table
            
            $this->table .= '</table>';
            
        }
        
        public function output() {
            
            if( empty( $this->table ) || strlen( $this->table ) == 0 )
                $this->build();
            
            return $this->table;
            
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
