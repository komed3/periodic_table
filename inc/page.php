<?php
    
    class Page {
        
        private $title;
        private $content = '';
        
        private $description = '';
        private $keywords = [];
        
        private $classes = [ 'pt' ];
        
        function __construct() {
            
            $this->set_title();
            
        }
        
        public function set_title(
            string $title = ''
        ) {
            
            global $lng;
            
            $this->title = ( strlen( $title ) == 0 ? '' : $title . ' &ndash; ' ) .
                $lng->msg( 'periodic_table' );
            
        }
        
        public function set_description(
            string $description
        ) {
            
            $this->description = implode( ' ', array_slice( explode( ' ', $description ), 0, 30 ) ) . ' …';
            
        }
        
        public function add_keywords(
            string ... $keywords
        ) {
            
            foreach( $keywords as $keyword ) {
                
                $this->keywords[] = $keyword;
                
            }
            
        }
        
        public function add_classes(
            string ... $classes
        ) {
            
            foreach( $classes as $class ) {
                
                $this->classes[] = $class;
                
            }
            
        }
        
        public function add_content(
            string $text
        ) {
            
            $this->content .= $text;
            
        }
        
        public function get_header() {
            
            global $lng;
            
            return '<header></header>';
            
        }
        
        public function get_content() {
            
            return '<main>' . $this->content . '</main>';
            
        }
        
        public function get_footer() {
            
            global $lng;
            
            return '<footer>' . $lng->msg( 'credits', date( 'Y' ) ) . '</footer>';
            
        }
        
        public function output() {
            
            global $lng;
            
            return '<!DOCTYPE html>' .
            '<html lang="' . $lng->lngcode . '">' .
                '<head>' .
                    '<title>' . $this->title . '</title>' .
                    '<meta charset="utf-8">' .
                    '<meta http-equiv="content-type" content="text/html;charset=utf-8" />' .
                    '<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes, minimum-scale=1.0, maximum-scale=3.0">' .
                    '<meta name="author" content="komed3 (Paul Koehler)" />' .
                    '<meta name="date" content="' . date( 'c' ) . '" />' .
                    '<meta name="robots" content="index, follow">' .
                    '<meta name="description" content="' . $this->description . '">' .
                    '<meta name="keywords" content="' . implode( ', ', $this->keywords ) . '">' .
                '</head>' .
                '<body class="' . implode( ' ', $this->classes ) . '">' .
                    $this->get_header() .
                    $this->get_content() .
                    $this->get_footer() .
                '</body>' .
            '</html>';
            
        }
        
    }
    
?>
