<?php
    
    class Linker {
        
        public function i(
            string $url,
            string $text
        ) {
            
            global $_IP;
            
            return '<a href="' . $_IP . $url . '">' . $text . '</a>';
            
        }
        
    }
    
?>
