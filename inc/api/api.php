<?php
    
    class API {
        
        protected $CLI;
        
        protected $args;
        
        function __construct() {
            
            $this->CLI = ( php_sapi_name() === 'cli' );
            
            $this->load_args();
            
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
        
        protected function load_module() {
            
            require_once __DIR__ . '/modules/' . (
                !empty( $this->args['action'] ) &&
                file_exists( __DIR__ . '/modules/' . $this->args['action'] . '.php' )
                    ? $this->args['action']
                    : 'help'
            ) . '.php';
            
            $module = new API_module( $this );
            
        }
        
        public function run() {
            
            $this->load_module();
            
        } 
        
    }
    
?>
