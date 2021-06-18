<?php
    
    class Long_Table extends Table {
        
        public function build() {
            
            global $lng;
            
            $exGroups = [];
            
            $this->table .= '<table border="1" class="table ' . $this->property . '">';
            
            for( $p = 1; $p <= $this->maxP; $p++ ) {
                
                $this->table .= '<tr>';
                
                for( $g = 1; $g <= $this->maxG; $g++ ) {
                    
                    $field = $this->get_field( $p, $g );
                    
                    if( empty( $field ) ) {
                        
                        $this->table .= '<td class="empty">&nbsp;</td>';
                        
                    } else {
                        
                        foreach( $field as $e ) {
                            
                            $this->add_element( $p, $g, $e );
                            
                        }
                        
                        if( $g == 3 && count( $field ) < 2 ) {
                            
                            $this->table .= '<td class="empty" colspan="14">&nbsp;</td>';
                            
                        }
                        
                    }
                                       
                }
                
                $this->table .= '</tr>';
                
            }
            
        }
        
    }
    
    $lt = new Long_Table();
    print $lt->output();
    
    exit;
    
?>
