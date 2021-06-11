<?php
    
    # start
    
    $start = microtime( true );
    
    $result = [];
    
    # open database connection
    
    $db = new mysqli( 'localhost', 'root', '', 'periodictable' );
    
    # fetch data
    
    if( isset( $_GET['props'] ) &&
        !empty( $_GET['props'] ) &&
        strlen( trim( $_GET['props'] ) ) > 0 ) {
        
        $props = array_filter(
            explode( '|',
                urldecode( trim( $_GET['props'] ) )
            )
        );
        
        if( isset( $_GET['elements'] ) &&
            !empty( $_GET['elements'] ) &&
            strlen( trim( $_GET['elements'] ) ) > 0 ) {
            
            $elements = array_filter(
                explode( '|',
                    urldecode( trim( $_GET['elements'] ) )
                )
            );
            
            foreach( $elements as $element ) {
                
                $result[ $element ] = get_element( $element, $props );
                
            }
            
        } else $result['error'] = 'argument _elements_ is required';
        
    } else $result['error'] = 'argument _props_ is required';
    
    # close database connection
    
    $db->close();
    
    # output
    
    print json_encode( [
        'result' => $result,
        'server' => [
            'query' => $_SERVER[ 'QUERY_STRING' ],
            'response' => 200,
            'https' => !empty( $_SERVER[ 'HTTPS' ] ),
            'date' => date( 'c' ),
            'ms' => microtime( true ) - $start
        ]
    ] );
    
    # functions
    
    function get_element( $element, $props ) {
        
        global $db;
        
        $searchstr = str_replace( '*', '%', $element );
        
        $res = $db->query('
            SELECT  *
            FROM    element
            WHERE   ID LIKE "' . $searchstr . '"
            OR      e_symbol LIKE "' . $searchstr . '"
            OR      e_name LIKE "' . $searchstr . '"
        ');
        
        $rows = $res->num_rows;
        
        if( $rows > 0 ) {
            
            $elements = [];
            
            while( $e = $res->fetch_object() ) {
                
                $propres = get_props( $e, $props );
                
                $elements[ $e->ID ] = [
                    'atomic_number' => $e->ID,
                    'symbol' => $e->e_symbol,
                    'name' => $e->e_name,
                    'group' => $e->e_group,
                    'period' => $e->e_period,
                    'prop_res' => count( $propres ),
                    'props' => $propres
                ];
                
            }
            
            return [
                'results' => $rows,
                'elements' => $elements
            ];
            
        } else return null;
        
    }
    
    function get_props( $e, $props ) {
        
        global $db;
        
        $properties = [];
        
        foreach( $props as $prop ) {
            
            $res = $db->query('
                SELECT  *
                FROM    property
                WHERE   p_element = ' . $e->ID . '
                AND     p_key LIKE "' . str_replace( '*', '%', $prop ) . '"
            ');
            
            if( $res->num_rows > 0 ) {
                
                $properties[ $prop ] = [];
                
                while( $p = $res->fetch_object() ) {
                    
                    $properties[ $p->p_key ][] = [
                        'value' => isset( $_GET[ 'format' ] )
                            ? format_value( $p->p_value ) : $p->p_value,
                        'comment' => $p->p_comment
                    ];
                    
                }
                
            } else $properties[ $prop ] = null;
            
        }
        
        unset( $properties['*'] );
        ksort( $properties, SORT_NATURAL | SORT_FLAG_CASE );
        
        return $properties;
        
    }
    
    function format_value( $value ) {
        
        if( is_numeric( $value ) )
            return doubleval( $value );
        if( empty( $value ) || is_null( $value ) || strlen( $value ) == 0 )
            return null;
        if( is_bool( $value ) )
            return boolval( $value );
        else
            return strval( $value );
        
    }
    
?>
