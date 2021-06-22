<?php
    
    class API {
        
        protected $CLI;
        
        protected $args;
        
        function __construct() {
            
            $this->CLI = ( php_sapi_name() === 'cli' );
            
            $this->load_params();
            
        }
        
        protected function load_args() {
            
            if( $this->CLI ) {
                
                
                
            } else {
                
                foreach( [ 'action', 'elements', 'props' ] as $arg ) {
                    
                    $this->args[ $arg ] = !empty( $_REQUEST[ $arg ] )
                        ? $_REQUEST[ $arg ]
                        : null;
                    
                }
                
            }
            
        }
        
        public function is_CLI() {
            
            return $this->CLI;
            
        }
        
    }
    
?>
