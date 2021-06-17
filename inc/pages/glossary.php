<?php
    
    class Glossary_Page extends Page {
        
        function __construct() {
            
            global $lng;
            
            $glossary = [];
            
            foreach( array_filter(
                array_keys( $lng->get_msg() ),
                function( $val ) {
                    
                    return strpos( $val, '_glossary' ) !== false;
                    
                }
            ) as $entry ) {
                
                $key = str_replace( '_glossary', '', $entry );
                
                $glossary[ $key ] = '<dt sort-index="' . $lng->msg( $key ) . '" id="' . $key . '">' .
                    $lng->msg( $key ) .
                    ( $lng->is_defined( $key . '_wiki' )
                        ? '<span class="wiki">' .
                              $lng->msg( 'xref' ) .
                              ( new Formatter( $lng->msg( $key . '_wiki' ) ) )
                                  ->exlink( 'https://de.wikipedia.org/wiki/$1' ) .
                          '</span>'
                        : '' ) .
                '</dt>' .
                '<dd>' . $lng->msg( $entry ) . '</dd>';
                
            }
            
            sort( $glossary, SORT_NATURAL | SORT_FLAG_CASE );
            
            $this->set_title( $lng->msg( 'glossary' ) );
            
            $this->add_keywords( $lng->msg( 'glossary' ) );
            
            $this->add_classes( 'glossary' );
            
            $this->add_header( $lng->msg( 'glossary' ) );
            
            $this->add_content(
                '<article>' .
                    '<dl class="glossary">' .
                        implode( '', $glossary ) .
                    '</dl>' .
                '</article>'
            );
            
        }
        
    }
    
?>
