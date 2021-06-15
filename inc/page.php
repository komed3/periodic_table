<?php
    
    class Page {
        
        private $title;
        private $content = '';
        
        private $nav = [
            'main' => [
                'table' => [
                    'set', 'group', 'period', 'block', 'age', 'crystal_system',
                    'magnetism', 'superconductivity', 'radioactivity',
                    'metal', 'goldschmidt', 'acid_base', 'basicity'
                ],
                'trend' => [
                    'heavy_metal', 'magnetic_susceptibility', 'density',
                    'potential', 'pauling', 'allen', 'mulliken', 'sanderson',
                    'allred_rochow', 'ghosh_gupta', 'pearson', 'mohs',
                    'vickers', 'brinell'
                ],
                'interactive' => [
                    'phase', 'discovery'
                ],
                'property' => [
                    'radioactive', 'natural', 'native', 'vital', 'clean',
                    'stable', 'noble', 'semiconductor', 'light', 'heavy',
                    'rare', 'platinum', 'refractory', 'mendeleev', 
                ],
                'tool' => [
                    'list', 'nuclide_table', 'molar_calculator'
                ]
            ],
            'footer' => []
        ];
        
        private $header = '';
        private $footer = '';
        
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
        
        public function get_nav(
            string $name
        ) {
            
            global $lng;
            
            $nav_content = '';
            
            foreach( $this->nav[ $name ] as $section => $links ) {
                
                $nav_content .= '<li>' .
                    '<h3>' .
                        Linker::i(
                            $lng->msg( $section ),
                            ucfirst( $lng->msg( $section ) )
                        ) .
                    '</h3>' .
                    '<ul>';
                
                foreach( $links as $link ) {
                    
                    $nav_content .= '<li>' .
                        Linker::i(
                            $lng->msg( $link ),
                            ucfirst( $lng->msg( $link ) )
                        ) .
                    '</li>';
                    
                }
                
                $nav_content .= '</ul></li>';
                
            }
            
            return '<nav class="' . $name . '">' .
                '<div class="nav-button">' .
                    '<i id="nav_' . $name . '_open" class="icon nav-open">menu</i>' .
                    '<i id="nav_' . $name . '_close" class="icon nav-close">close</i>' .
                '</div>' .
                '<ul class="navigation">' . $nav_content . '</ul>' .
            '</nav>';
            
        }
        
        public function get_header() {
            
            global $lng;
            
            return '<header>' .
                '<h1>' .
                    $this->get_nav( 'main' ) .
                    $this->header .
                '</h1>' .
            '</header>';
            
        }
        
        public function get_content() {
            
            return '<main>' . $this->content . '</main>';
            
        }
        
        public function get_footer() {
            
            global $lng;
            
            return '<footer>' . $lng->msg( 'credits', date( 'Y' ) ) . '</footer>';
            
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
