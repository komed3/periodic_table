<?php

    class Table_Page extends Page {
        
        public $property;
        
        function __construct(
            string $property = 'set'
        ) {
            
            global $lng, $args;
            
            $this->property = $property;
            
            $table = new Table();
            $table->set_property( $this->property );
            $table->add_classes( 'full-page' );
            
            if( !empty( $args['e'] ) )
                $table->set_current( new Element( $args['e'] ) );
            
            $this->show_header = false;
            
            $this->add_keywords( $lng->msg( $this->property ) );
            
            $this->add_classes( 'table' );
            
            $this->set_title( $lng->msg( $this->property ) );
            
            $this->add_content(
                '<div class="table-container">' .
                    $table->output() .
                '</div>'
            );
            
        }
        
    }
    
?>
