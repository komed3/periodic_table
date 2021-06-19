<?php

    class Table_Page extends Page {
        
        public $property;
        
        function __construct(
            string $property = 'set'
        ) {
            
            global $lng;
            
            $this->property = $property;
            
            $table = new Table();
            $table->set_property( $this->property );
            $table->add_classes( 'full-page' );
            
            $this->show_header = false;
            $this->show_footer = false;
            
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
