<?php

/*
 * Get list of links
 */

require_once 'simple_html_dom.php';

class GrabberLinks {

    private $urlPattern = '.qt-img-text';
    private $urlContain = '';
    private $domain = '';
    private $links = array();
    private $linksAuthor = array();
    

    public function setDomain($domain) {
        $this->domain = $domain;
    }

    public function getDomain() {
        return $this->domain;
    }

    public function setUrlPattern($urlPattern) {
        // '.qt-img-text'
        $this->urlPattern = $urlPattern;
    }

    public function getUrlPattern() {
        return $this->urlPattern;
    }

    public function setUrlContain($urlContain) {
        $this->urlContain = $urlContain;
    }

    public function getUrlContain() {
        return $this->urlContain;
    }

    public function getLinks($url) {
        if(!isset($this->links[md5($url)])) {
            @$this->links[md5($url)] = 1;
        } else return false;
        

        $links = array();

        $html = file_get_html($url);
        
        #$html = $html->find('ul',1);
     

        if (is_object($html)) {
            foreach ($html->find($this->getUrlPattern()) as $link) {
              
               # if ($this->getUrlContain() != '') {

                    /*
                     * if url not contain pattern then continue
                     */

                    if ($this->getUrlContain()!='' && strpos($link, $this->getUrlContain()) === FALSE) {
                        continue;
                    }
                    $u = $this->getDomain() . $link->href;
                     if(!isset($this->linksAuthor[md5($u)])) {
                        $links[] = $u;
                     @$this->linksAuthor[md5($u)] = 1;
                     }
               # }
            }
        }
       
            return $links;
       
           
    }

}

// use
/*
$gl = new GrabberLinks();
$gl->setUrlPattern('.qt-img-text');
$gl->setUrlContain('quotes');
print_r($gl->getLinks("https://www.quotetab.com/authors/b"));
 *
 */

