<?php
    
    class Element {
        
        public $ID;
        public $symbol;
        public $name;
        public $group;
        public $period;
        
        function __construct(
            $element
        ) {
            
            global $db;
            
            $e = $db->query('
                SELECT  *
                FROM    ' . $db->prefix . 'element
                WHERE   ID = "' . $element . '"
                OR      e_symbol = "' . $element . '"
                OR      e_name = "' . $element . '"
            ');
            
            if( $e->num_rows != 1 )
                return false;
            
            $e = $e->fetch_object();
            
            $this->ID = $e->ID;
            $this->symbol = $e->e_symbol;
            $this->name = $e->e_name;
            $this->group = $e->e_group;
            $this->period = $e->e_period;
            
        }
        
        public function is_element() {
            
            return !empty( $this->ID );
            
        }
        
        public function get_prop(
            string $prop,
            $default = null
        ) {
            
            return new Property( $this, $prop, $default );
            
        }
        
    }
    
?>
