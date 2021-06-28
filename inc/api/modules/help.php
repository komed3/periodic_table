<?php
    
    class API_module {
        
        function __construct(
            API $api
        ) {
            
            if( $api->CLI )
                $this->cli_help();
            
            else
                $this->web_help();
            
        }
        
        private function cli_help() {
            
            
            
        }
        
        private function web_help() {
            
            
            
        }
        
    }
    
?>
