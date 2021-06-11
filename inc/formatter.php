<?php
    
    class Formatter {
        
        private $v;
        
        function __construct(
            $value = null
        ) {
            
            $this->v = $value;
            
        }
        
        public function raw() {
            
            return $this->v;
            
        }
        
        public function si() {
            
            return $this->v;
            
        }
        
        public function i18n() {
            
            global $LANG;
            
            return $this->v;
            
        }
        
    }
    
?>
