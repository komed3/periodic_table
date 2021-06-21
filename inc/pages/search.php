<?php
    
    class Search_Page extends Page {
        
        public $limit = 20;
        public $page = 1;
        
        public $searchstr = '';
        
        protected function get_results() {
            
            return '';
            
        }
        
        function __construct() {
            
            global $lng;
            
            $this->set_title( $lng->msg( 'search' ) );
            
            $this->add_keywords( $lng->msg( 'search' ) );
            
            $this->add_classes( 'search' );
            
            $this->add_header(
                '<div>' . $lng->msg( 'search' ) . '</div>' .
                getSearchBar()
            );
            
            $this->add_content(
                '<article>' .
                    $this->get_results() .
                '</article>' .
                '<aside>' .
                    ( new Long_Table() )->output() .
                '</aside>'
            );
            
        }
        
    }
    
?>
