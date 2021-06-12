<?php
    
    class Language {
        
        public $lngcode;
        
        private $msg;
        
        function __construct(
            string $lngcode = ''
        ) {
            
            $this->setLanguage();
            
            $this->loadMsg();
            
        }
        
        private function setLanguage(
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
        
        private function loadMsg() {
            
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
            
            return $this->defmsg( $key, $key, $replaces );
            
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
        
    }
    
    $lng = new Language();
    
?>
