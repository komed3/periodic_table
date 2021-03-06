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
        
        public function str(
            $default = null
        ) {
            
            $str = preg_replace(
                '/\{(.+)\}/U',
                '<sub>$1</sub>',
                preg_replace(
                    '/\'{2}(.+)\'{2}/U',
                    '<i>$1</i>',
                    preg_replace(
                        '/\'{3}(.+)\'{3}/U',
                        '<b>$1</b>',
                        preg_replace(
                            '/\<(.+)\>/U',
                            '<sup>$1</sup>',
                            str_replace(
                                '~', '&nbsp;',
                                trim( $this->v )
                            )
                        )
                    )
                )
            );
            
            return strlen( trim( $str ) ) == 0 ? $default : $str;
            
        }
        
        public function rawnum() {
            
            return doubleval( $this->v );
            
        }
        
        public function num(
            $digits = false
        ) {
            
            return $this->exp( $digits, false );
            
        }
        
        public function exp(
            $digits = false,
            bool $p10 = true
        ) {
            
            global $lng;
            
            $p10digits = strlen( number_format( $this->rawnum(), 0, '', '' ) ) - 1;
            preg_match( '/e-([0-9]{1,})$/Ui', $this->rawnum(), $p00digits );
            $pSuffix = '';
            
            if( $p10 && $p10digits > 5 ) {
                
                $val = $this->v / pow( 10, $p10digits );
                
                $pSuffix = ( new Formatter(
                    $lng->defmsg( 'p10',
                        'e' . $p10digits,
                        $p10digits
                    )
                ) )->str();
                
            } else if( $p10 && isset( $p00digits[1] ) && is_numeric( $p00digits[1] ) ) {
                
                $val = $this->v * pow( 10, $p00digits[1] );
                
                $pSuffix = ( new Formatter(
                    $lng->defmsg( 'p00',
                        'e-' . $p00digits[1],
                        $p00digits[1]
                    )
                ) )->str();
                
            } else $val = $this->v;
            
            return preg_replace(
                '/(\,)([0-9]{1,})([0]{1,})$/U',
                '$1$2',
                number_format(
                    $val,
                    ( $digits ? $digits : strlen( substr( strrchr( $val, '.'), 1 ) ) ),
                    $lng->defmsg( 'dp', '.' ),
                    $lng->defmsg( 'tp', '' )
                )
            ) . $pSuffix;
            
        }
        
        public function pct(
            $digits = false
        ) {
            
            $number = $this->rawnum();
            
            if( $number < 10e-9 ) {
                
                $unit = 'ppb';
                $number /= 10e-9;
                
            } else if( $number < 10e-6 ) {
                
                $unit = 'ppm';
                $number /= 10e-6;
                
            } else if( $number < 10e-3 ) {
                
                $unit = '???';
                $number /= 10e-3;
                
            } else {
                
                $unit = '%';
                
            }
            
            return '<value class="pct">' .
                ( new Formatter( $number ) )->exp( $digits ) .
                '<unit>' . $unit . '</unit>' .
            '</value>';
            
        }
        
        public function physical(
            $digits = false,
            $unit = null
        ) {
            
            global $lng;
            
            return '<value class="physical">' .
                $this->exp( $digits ) . ( !empty( $unit )
                    ? '<unit>' .
                          ( new Formatter( $unit ) )->str() .
                      '</unit>' : '' ) .
            '</value>';
            
        }
        
        public function temp(
            bool $celsius = true,
            $digits = false
        ) {
            
            global $lng;
            
            return '<temp data-temp="' . $this->rawnum() . '">' .
                '<K>' .
                    $this->exp( $digits ) .
                    '<unit title="' . $lng->defmsg( 'temp-K', 'K' ) . '">' .
                        $lng->defmsg( 'unit-K', 'K' ) .
                    '</unit>' .
                '</K>' . ( $celsius ?
                    '<C>' .
                        ( new Formatter( $this->rawnum() - 273.15 ) )->exp() .
                        '<unit title="' . $lng->defmsg( 'temp-C', '??C' ) . '">' .
                            $lng->defmsg( 'unit-C', '??C' ) .
                        '</unit>' .
                    '</C>' :
                    '' ) .
            '</temp>';
            
        }
        
        public function datetime(
            string $format = 'Y-m-d'
        ) {
            
            $timestamp = strtotime( $this->v );
            
            return '<time data-timestamp="' . $timestamp . '">' .
                date( $format, $timestamp ) .
            '</time>';
            
        }
        
        public function i18n(
            string ... $replaces
        ) {
            
            global $lng;
            
            return $lng->msg( $this->v, ... $replaces );
            
        }
        
        public function boolstr() {
            
            global $lng;
            
            return $lng->msg( !!boolval( $this->raw() ) ? 'yes' : 'no' );
            
        }
        
        public function exlink(
            $identifier = null,
            $text = null
        ) {
            
            return empty( $identifier )
                ? $this->raw()
                : Linker::e(
                      str_replace( '$1', $this->raw(), $identifier ),
                      empty( $text ) ? $this->raw() : $text
                  );
            
        }
        
        public function img(
            $caption = null,
            $classes = []
        ) {
            
            global $_IP;
            
            return '<figure class="' . implode( ' ', $classes ) . '">' .
                '<img src="' . $_IP . 'res/images/' . $this->raw() . '" title="' . $caption . '" />' .
                ( !empty( $caption ) ? '<figcaption>' . $caption . '</figcaption>' : '' ) .
            '</figure>';
            
        }
        
    }
    
?>
