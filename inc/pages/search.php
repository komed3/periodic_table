<?php
    
    class Search_Page extends Page {
        
        public $limit = 20;
        public $offset = 0;
        public $page = 1;
        
        public $searchstr = '';
        
        public $results = [];
        public $rescnt = 0;
        
        function __construct() {
            
            global $lng;
            
            $this->run_search();
            
            $this->set_title( $lng->msg( 'search' ) );
            
            $this->add_keywords( $lng->msg( 'search' ) );
            
            $this->add_classes( 'search' );
            
            $this->add_header(
                '<div>' . $lng->msg( 'search' ) . '</div>' .
                getSearchBar()
            );
            
            $this->add_content(
                '<article>' .
                    '<div class="results-header">' .
                        '<div class="rescnt">' .
                            $lng->msg(
                                'search-results',
                                $this->searchstr,
                                $this->rescnt
                            ) .
                        '</div>' .
                        '<div class="respage">' .
                            $lng->msg(
                                'search-results-page',
                                $this->offset + 1,
                                min(
                                    $this->rescnt,
                                    $this->offset + $this->limit
                                )
                            ) .
                        '</div>' .
                    '</div>' .
                    '<div class="results">' .
                        implode( '', $this->results ) .
                    '</div>' .
                    '<div class="results-more">' .
                        $this->get_more() .
                    '</div>' .
                '</article>' .
                '<aside>' .
                    ( new Long_Table() )->output() .
                '</aside>'
            );
            
        }
        
        protected function run_search() {
            
            global $args;
            
            $this->searchstr = empty( $args['q'] )
                ? '' : $args['q'];
            
            $this->page = empty( $args['page'] )
                ? 1 : $args['page'];
            
            $this->offset = ( $this->page - 1 ) * $this->limit;
            
            $this->fetch_results();
            
        }
        
        protected function fetch_results() {
            
            global $db, $lng;
            
            $this->rescnt = $db->query('
                SELECT  ID
                FROM    ' . $db->prefix . 'element
                WHERE   ID LIKE "%' . $this->searchstr . '%"
                OR      e_symbol LIKE "%' . $this->searchstr . '%"
                OR      e_name LIKE "%' . $this->searchstr . '%"
            ')->num_rows;
            
            $res = $db->query('
                SELECT  ID
                FROM    ' . $db->prefix . 'element
                WHERE   ID LIKE "%' . $this->searchstr . '%"
                OR      e_symbol LIKE "%' . $this->searchstr . '%"
                OR      e_name LIKE "%' . $this->searchstr . '%"
                LIMIT   ' . $this->offset . ', ' . $this->limit
            );
            
            while( $row = $res->fetch_object() ) {
                
                $e = new Element( $row->ID );
                
                $this->results[] = '<div class="result">' .
                    '<h3>' .
                        $e->get_symbol() .
                        Linker::p(
                            'element',
                            $e->get_slug(),
                            $e->get_name()
                        ) .
                    '</h3>' .
                    '<p>' .
                        $e->get_short() .
                        Linker::p(
                            'element',
                            $e->get_slug(),
                            $lng->msg( 'read-more' )
                        ) .
                    '</p>' .
                '</div>';
                
            }
            
        }
        
        protected function get_more() {
            
            global $lng;
            
            return $this->rescnt > $this->offset + $this->limit
                ? Linker::q(
                      $lng->msg( 'search' ),
                      $lng->msg( 'search-results-more' ),
                      [
                          'q' => $this->searchstr,
                          'page' => $this->page + 1
                      ]
                  )
                : '<span class="results-end">' .
                      $lng->msg( 'search-results-end' ) .
                  '</span>';
            
        }
        
    }
    
?>
