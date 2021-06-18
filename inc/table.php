<?php
    
    class Table {
        
        private $maxP = 7;
        private $maxG = 18;
        
        private $fields = [];
        
        private $property = 'set';
        private $current = null;
        
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
            
            $this->property = $prop;
            
        }
        
        public function set_current(
            Element $e
        ) {
            
            $this->current = $e;
            
        }
        
    }
    
?>
