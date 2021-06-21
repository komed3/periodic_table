<?php
    
    class Search_Page extends Page {
        
        public $limit = 20;
        public $page = 1;
        
        public $searchstr = '';
        
        public $results = [];
        
        protected function fetch_results() {
            
            global $db;
            
            $offset = ( $this->page - 1 ) * $this->limit;
            
            $res = $db->query('
                SELECT  ID
                FROM    ' . $db->prefix . 'element
                WHERE   ID LIKE "%' . $this->searchstr . '%"
                OR      e_symbol LIKE "%' . $this->searchstr . '%"
                OR      e_name LIKE "%' . $this->searchstr . '%"
                LIMIT   ' . $offset . ', ' . $this->limit
            );
            
            while( $row = $res->fetch_object() ) {
                
                $e = new Element( $row->ID );
                
                $this->results = '<div class="result">' .
                    '<h2>' .
                        $e->get_symbol() .
                        Linker::p(
                            'page', $e->get_slug(),
                            $e->get_name()
                        ) .
                    '</h2>' .
                    '<p>' .
                        $e->get_short() .
                    '</p>' .
                '</div>';
                
            }
            
        }
        
        function __construct() {
            
            global $args, $lng;
            
            $this->searchstr = empty( $args['q'] )
                ? '' : $args['q'];
            
            $this->page = empty( $args['page'] )
                ? 1 : $args['page'];
            
            $this->fetch_results();
            
            $this->set_title( $lng->msg( 'search' ) );
            
            $this->add_keywords( $lng->msg( 'search' ) );
            
            $this->add_classes( 'search' );
            
            $this->add_header(
                '<div>' . $lng->msg( 'search' ) . '</div>' .
                getSearchBar()
            );
            
            $this->add_content(
                '<article>' .
                    $this->results .
                '</article>' .
                '<aside>' .
                    ( new Long_Table() )->output() .
                '</aside>'
            );
            
        }
        
    }
    
?>
