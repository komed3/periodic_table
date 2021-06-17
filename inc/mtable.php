<?php
    
    class mTable {
        
        private $current;
        
        private $table = '';
        
        public function set_current(
            Element $e
        ) {
            
            if( $e->is_element() )
                $this->current = $e;
            
        }
        
        public function build() {
            
            global $db;
            
            $this->table .= '<table class="table m-table set">';
            
            for( $period = 1; $period <= 7; $period++ ) {
                
                $this->table .= '<tr>';
                
                for( $group = 1; $group <= 18; $group++ ) {
                    
                    $res = $db->query('
                        SELECT      ID
                        FROM        ' . $db->prefix . 'element
                        WHERE       e_period = "' . $period . '"
                        AND         e_group = "' . $group . '"
                        ORDER BY    ID ASC
                    ');
                    
                    if( $res->num_rows == 0 ) {
                        
                        $this->table .= '<td class="empty">&nbsp;</td>';
                        
                    } else {
                        
                        while( $row = $res->fetch_object() ) {
                            
                            $e = new Element( $row->ID );
                            
                            if( ( $prop = $e->get_prop( 'set' ) )->rows > 0 ) {
                                
                                $set = $prop->p[0]->val->raw();
                                
                            } else $set = 'undefined';
                            
                            $this->table .= '<td class="element ' . $set . (
                                $this->current instanceof Element &&
                                $e->ID == $this->current->ID
                                    ? ' current'
                                    : ''
                            ) . '">' .
                                Linker::p(
                                    'element',
                                    $e->get_slug(),
                                    '<span>' . $e->symbol . '</span>',
                                    [
                                        'title' => $e->name
                                    ]
                                ) .
                            '</td>';
                            
                        }
                        
                    }
                    
                    if( $res->num_rows != 15 && $group == 3 ) {
                        
                        $this->table .= '<td class="empty" colspan="14">&nbsp;</td>';
                        
                    }
                    
                }
                
                $this->table .= '</tr>';
                
            }
            
            $this->table .= '</table>';
            
        }
        
        public function output() {
            
            if( empty( $this->table ) || strlen( $this->table ) == 0 )
                $this->build();
            
            return $this->table;
            
        }
        
    }
    
?>
