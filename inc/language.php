<?php
    
    class Language {
        
        public $lngcode;
        
        private $msg;
        
        function __construct(
            string $lngcode = ''
        ) {
            
            $this->set_language();
            
            $this->load_msg();
            
        }
        
        public function set_language(
            string $lngcode = ''
        ) {
            
            global $_LNG;
            
            $this->lngcode = strtolower(
                ( empty( $lngcode ) || strlen( $lngcode ) == 0 )
                    ? $_LNG
                    : $lngcode
            );
            
            if( !file_exists( __DIR__ . '/i18n/' . $this->lngcode . '.json' ) )
                $this->lngcode = 'en';
            
        }
        
        public function load_msg() {
            
            $this->msg = [];
            
            foreach(
                json_decode(
                    file_get_contents( __DIR__ . '/i18n/' . $this->lngcode . '.json' ),
                    true
                ) as $key => $translation
            ) {
                
                $this->msg[ $key ] = $translation;
                
            }
            
        }
        
        public function msg(
            string $key,
            string ... $replaces
        ) {
            
            return $this->defmsg( $key, $key, ... $replaces );
            
        }
        
        public function defmsg(
            string $key,
            $default = null,
            string ... $replaces
        ) {
            
            if( array_key_exists( $key, $this->msg ) ) {
                
                $translation = $this->msg[ $key ];
                $i = 0;
                
                foreach( $replaces as $r ) {
                    
                    $translation = str_replace( '$' . ++$i, $r, $translation );
                    
                }
                
                return $translation;
                
            } else return $default;
            
        }
        
        public function is_defined(
            string $key
        ) {
            
            return array_key_exists( $key, $this->msg );
            
        }
        
        public function get_msg() {
            
            return $this->msg;
            
        }
        
        public function get_key(
            string $value
        ) {
            
            return array_search( mb_strtolower( $value ), array_map(
                function( $val ) {
                    return mb_strtolower( str_replace( '&shy;', '', $val ) );
                },
                $this->msg
            ) );
            
        }
        
    }
    
    $lng = new Language();
    
?>
