<?php
    
    class Property {
        
        public $p = [];
        public $rows = 0;
        
        function __construct(
            Element $element,
            string $key,
            $default = null
        ) {
            
            global $db, $db_prfx;
            
            $res = $db->query('
                SELECT  *
                FROM    ' . $db_prfx . 'property
                WHERE   p_element = ' . $element->ID . '
                AND     p_key = "' . trim( $key ) . '"
            ');
            
            $this->rows = $res->num_rows;
            
            while( $row = $res->fetch_object() ) {
                
                $this->p[] = (object) [
                    'PID' => $row->PID,
                    'key' => new Formatter( $row->p_key ),
                    'val' => new Formatter( $row->p_value ),
                    'com' => new Formatter( $row->p_comment )
                ];
                
            }
            
        }
        
    }
    
?>
