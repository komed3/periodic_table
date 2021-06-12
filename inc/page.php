<?php
    
    class Page {
        
        private $title;
        private $content = '';
        
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
        
        public function add_content(
            string $text
        ) {
            
            $this->content .= $text;
            
        }
        
        public function output() {
            
            return '<!DOCTYPE html>' .
            '<html lang="de">' .
                '<head>' .
                    '<title>' . $this->title . '</title>' .
                    '<meta charset="utf-8">' .
                    '<meta http-equiv="content-type" content="text/html;charset=utf-8" />' .
                    '<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">' .
                    '<meta name="author" content="komed3" />' .
                    '<meta name="date" content="' . date( 'c' ) . '" />' .
                    '<meta name="robots" content="index, follow">' .
                    '<meta name="description" content="">' .
                    '<meta name="keywords" lang="de" content="">' .
                    '<meta name="keywords" lang="en" content="">' .
                '</head>' .
                '<body>' .
                    '<div id="pt">' .
                        $this->content .
                    '</div>' .
                '</body>' .
            '</html>';
            
        }
        
    }
    
?>
