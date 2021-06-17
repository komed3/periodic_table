<?php
    
    class Imprint_Page extends Page {
        
        function __construct() {
            
            global $lng, $_GITHUB;
            
            $this->set_title( $lng->msg( 'imprint' ) );
            
            $this->add_keywords( $lng->msg( 'imprint' ) );
            
            $this->add_classes( 'imprint' );
            
            $this->add_header(
                '<div>' . $lng->msg( 'imprint' ) . '</div>'
            );
            
            $this->add_content(
                '<article>' .
                    '<ul class="list">' .
                        '<li>' .
                            '<b>' . $lng->msg( 'webmaster' ) . '</b>' .
                            '<span>' . Linker::e( 'https://labs.komed3.de', 'komed3 (Paul Köhler)' ) . '</span>' .
                        '</li>' .
                        '<li>' .
                            '<b>' . $lng->msg( 'mail' ) . '</b>' .
                            '<span>' . Linker::e( 'mailto:webmaster@pse-info.de', 'webmaster@pse-info.de' ) . '</span>' .
                        '</li>' .
                        '<li>' .
                            '<b>' . $lng->msg( 'github' ) . '</b>' .
                            '<span>' . Linker::e( $_GITHUB, 'komed3/periodic_table' ) . '</span>' .
                        '</li>' .
                    '</ul>' .
                    '<h2>' . $lng->msg( 'disclaimer' ) . '</h2>' .
                    $lng->msg( 'disclaimer-content' ) .
                    '<h2>' . $lng->msg( 'license' ) . '</h2>' .
                    '<p><b>Copyright &copy; 2021 komed3 (Paul Köhler)</b></p>' .
                    '<p>Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:</p>' .
                    '<p>The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.</p>' .
                    '<p>THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.</p>' .
                '</article>'
            );
            
        }
        
    }
    
?>
