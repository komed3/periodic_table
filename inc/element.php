<?php
    
    class Element {
        
        public $ID;
        public $symbol;
        public $name;
        public $group;
        public $period;
        
        function __construct(
            int $element
        ) {
            
            global $db, $db_prfx;
            
            $e = $db->query('
                SELECT  *
                FROM    ' . $db_prfx . 'element
                WHERE   ID = ' . $element . '
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
        
        public function get_prop(
            string $prop,
            $default = null
        ) {
            
            return new Property( $this, $prop, $default );
            
        }
        
    }
    
?>
