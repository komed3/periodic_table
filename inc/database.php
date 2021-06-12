<?php
    
    class Database extends mysqli {
        
        public $prefix;
        
        public function set_prfx(
            string $prfx = ''
        ) {
            
            $this->prefix = $prfx;
            
        }
        
    }
    
    $db = new Database( $db_host, $db_user, $db_pswd, $db_name );
    
    $db->set_prfx( $db_prfx );
    
?>
