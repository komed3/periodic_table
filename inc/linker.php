<?php
    
    class Linker {
        
        private function builder(
            string $url,
            string $text,
            $params = []
        ) {
            
            $plist = [];
            
            foreach( $params as $key => $val ) {
                
                $plist[] = $key . '="' . $val . '"';
                
            }
            
            return '<a href="' . str_replace( ' ', '_', trim( $url ) ) . '" ' . implode( '', $plist ) . '>' .
                trim( $text ) .
            '</a>';
            
        }
        
        public function i(
            string $url,
            string $text,
            $params = []
        ) {
            
            global $_IP;
            
            return Linker::builder(
                $_IP . urlencode( str_replace( [ ' ', '&shy;' ], [ '_', '' ], $url ) ), $text,
                array_merge( [], $params )
            );
            
        }
        
        public function p(
            string $page,
            string $url,
            string $text,
            $params = []
        ) {
            
            global $_IP, $lng;
            
            return Linker::builder(
                $_IP . urlencode( str_replace( [ ' ', '&shy;' ], [ '_', '' ], $lng->msg( $page . '-page' ) ) ) . '/' .
                urlencode( str_replace( [ ' ', '&shy;' ], [ '_', '' ], $url ) ),
                $text, $params
            );
            
        }
        
        public function e(
            string $url,
            string $text,
            $params = []
        ) {
            
            return Linker::builder(
                $url, $text,
                array_merge( [
                    'target' => '_blank',
                    'class' => 'external'
                ], $params )
            );
            
        }
        
    }
    
?>
