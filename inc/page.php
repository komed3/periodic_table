<?php
    
    class Page {
        
        private $title;
        private $content = '';
        
        private $header = '';
        
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
        
        public function add_header(
            string $text
        ) {
            
            $this->header .= $text;
            
        }
        
        public function add_content(
            string $text
        ) {
            
            $this->content .= $text;
            
        }
        
        public function get_header() {
            
            global $lng;
            
            return '<header>' .
                '<h1>' .
                    Linker::i( $lng->msg( 'menu' ), 'menu', [ 'class' => 'menu icon' ] ) .
                    '<div>' . $this->header . '</div>' .
                '</h1>' .
            '</header>';
            
        }
        
        public function get_content() {
            
            return '<main>' . $this->content . '</main>';
            
        }
        
        public function get_footer() {
            
            global $lng;
            
            return '<footer>' .
                '<p class="credits">' . $lng->msg( 'credits', date( 'Y' ) ) . '</p>' .
                '<ul class="nav">' .
                    '<li>' . Linker::i( $lng->msg( 'imprint' ), $lng->msg( 'imprint' ) ) . '</li>' .
                    '<li>' . Linker::i( $lng->msg( 'privacy' ), $lng->msg( 'privacy' ) ) . '</li>' .
                    '<li>' . Linker::i( 'api.php', $lng->msg( 'API' ) ) . '</li>' .
                    '<li>' . Linker::e( 'https://github.com/komed3/periodic_table', $lng->msg( 'github' ) ) . '</li>' .
                    '<li>' . Linker::i( 'sitemap.xml', $lng->msg( 'sitemap' ) ) . '</li>' .
                    '<li>' . Linker::e( 'https://paypal.me/komed3', $lng->msg( 'donate' ) ) . '</li>' .
                '</ul>' .
            '</footer>';
            
        }
        
        public function output() {
            
            global $lng, $_IP, $sTime;
            
            $status = [];
            
            foreach( [
                'server' => $_SERVER['SERVER_NAME'],
                'response' => http_response_code(),
                'query' => $_SERVER['REQUEST_URI'],
                'datetime' => date( 'c' ),
                'time' => round( microtime( true ) - $sTime, 3 ),
                'php_version' => phpversion(),
                'memory' => memory_get_usage()
            ] as $key => $val ) {
                
                $status[] = '  ' . str_pad( $key, 20, ' ', STR_PAD_RIGHT ) . $val;
                
            }
            
            $html = '<!DOCTYPE html>' .
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
                    '<link rel="shortcut icon" type="image/x-icon" href="' . $_IP . 'res/images/favicon.png" />' .
                    '<link rel="shortcut icon" href="' . $_IP . 'res/images/favicon.ico">' .
                    '<link rel="icon" type="image/png" href="' . $_IP . 'res/images/favicon.png" sizes="32x32">' .
                    '<link rel="icon" type="image/png" href="' . $_IP . 'res/images/favicon.png" sizes="96x96">' .
                    '<link rel="apple-touch-icon" sizes="180x180" href="' . $_IP . 'res/images/favicon.png">' .
                    '<meta name="msapplication-TileColor" content="#ffffff">' .
                    '<meta name="msapplication-TileImage" content="' . $_IP . 'res/images/favicon.png">' .
                    '<link rel="stylesheet" href="' . $_IP . 'res/css/pt.css" />' .
                '</head>' .
                '<body class="' . implode( ' ', $this->classes ) . '">' .
                    '<div class="container">' .
                        $this->get_header() .
                        $this->get_content() .
                        $this->get_footer() .
                    '</div>' .
                '</body>' .
                '<!--' . PHP_EOL . implode( PHP_EOL, $status ) . PHP_EOL . '-->' .
            '</html>';
            
            $dom = new DOMDocument();
            $dom->preserveWhiteSpace = false;
            $dom->loadHTML( $html, LIBXML_NOWARNING | LIBXML_NOERROR );
            $dom->formatOutput = true;

            return $dom->saveHTML();
            
        }
        
    }
    
?>
