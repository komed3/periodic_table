<?php
    
    class Element {
        
        public $ID;
        
        public $symbol;
        public $name;
        
        public $group;
        public $period;
        
        public $description;
        public $image;
        
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
            $this->description = $e->e_desc;
            $this->image = $e->e_img;
            
        }
        
        public function is_element() {
            
            return !empty( $this->ID );
            
        }
        
        public function get_slug() {
            
            return urlencode( str_replace( ' ', '_', trim( $this->name ) ) );
            
        }
        
        public function get_symbol() {
            
            return '<symbol>' . ( new Formatter( '{' . $this->ID . '}' . $this->symbol ) )->str() . '</symbol>';
            
        }
        
        public function get_name() {
            
            return $this->name;
            
        }
        
        public function get_image() {
            
            global $_IP;
            
            return empty( $this->image ) ? '' : '<img src="' . $_IP . 'res/images/' . $this->image . '" />';
            
        }
        
        public function get_prop(
            string $prop,
            $default = null
        ) {
            
            return new Property( $this, $prop, $default );
            
        }
        
        public function get_ref(
            string $prop,
            $default = null
        ) {
            
            return new Property( $this, $prop . '_ref', $default );
            
        }
        
        public function get_next(
            int $n = 1
        ) {
            
            return new Element( $this->ID + $n );
            
        }
        
        public function get_prev(
            int $n = 1
        ) {
            
            return new Element( $this->ID - $n );
            
        }
        
    }
    
?>
