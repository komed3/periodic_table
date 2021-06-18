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
        
        public $maxP = 7;
        public $maxG = 18;
        
        public $property = 'set';
        public $current = null;
        
        function __construct() {
            
            $this->fetch_fields();
            
        }
        
        private function fetch_fields() {
            
            for( $p = 1; $p <= $this->maxP; $p++ ) {
                
                for( $g = 1; $g <= $this->maxG; $g++ ) {
                    
                    $this->fields[ $p ][ $g ] = $this->fetch_elements( $p, $g );
                    
                }
                
            }
            
        }
        
        private function fetch_elements(
            int $period,
            int $group
        ) {
            
            global $db;
            
            $elements = [];
            
            $res = $db->query('
                SELECT      ID
                FROM        ' . $db->prefix . 'element
                WHERE       e_period = "' . $period . '"
                AND         e_group = "' . $group . '"
                ORDER BY    ID ASC
            ');
            
            if( $res->num_rows > 0 ) {
                
                while( $row = $res->fetch_object() ) {
                    
                    $elements[] = new Element( $row->ID );
                    
                }
                
            }
            
            return $elements;
            
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
            
            
            
        }
        
        public function output() {
            
            
            
        }
        
        public function get_legend() {
            
            
            
        }
        
    }
    
?>
