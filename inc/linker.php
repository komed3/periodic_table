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
            
            return '<a href="' .
                str_replace( ' ', '_', trim( $url ) ) . '" ' .
                implode( '', $plist ) . '>' .
                trim( $text ) .
            '</a>';
            
        }
        
        public function l(
            string $url
        ) {
            
            return str_replace(
                [ '%28', '%29' ],
                [ '(', ')' ],
                urlencode( str_replace(
                    [ ' ', '&shy;' ],
                    [ '_', '' ],
                    $url
                ) )
            );
            
        }
        
        public function i(
            string $url,
            string $text,
            $params = [],
            $anchor = null
        ) {
            
            global $_IP;
            
            return self::builder(
                $_IP . self::l( $url ) .
                    ( !empty( $anchor ) ? '#' . $anchor : '' ),
                $text,
                $params
            );
            
        }
        
        public function p(
            string $page,
            string $url,
            string $text,
            $params = [],
            $anchor = null
        ) {
            
            global $_IP, $lng;
            
            return self::builder(
                $_IP . self::l( $lng->msg( $page ) ) . '/' . self::l( $url ) .
                    ( !empty( $anchor ) ? '#' . $anchor : '' ),
                $text,
                $params
            );
            
        }
        
        public function q(
            string $url,
            string $text,
            $query = [],
            $params = [],
            $anchor = null
        ) {
            
            global $_IP;
            
            return self::builder(
                $_IP . self::l( $url ) . '?' . http_build_query( $query, '', '&' ) .
                    ( !empty( $anchor ) ? '#' . $anchor : '' ),
                $text,
                $params
            );
            
        }
        
        public function e(
            string $url,
            string $text,
            $params = []
        ) {
            
            return self::builder(
                $url,
                $text,
                array_merge( [
                    'target' => '_blank',
                    'class' => 'external'
                ], $params )
            );
            
        }
        
    }
    
?>
