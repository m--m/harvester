<?php

require_once 'simple_html_dom.php';

class GrabberText {

    private $urlPattern = array();
    private $fillHorizontal = false;

    private function horizontal($arr) {
        $arrH = array();

        foreach ($arr as $cur) {

            foreach ($cur as $block) {
                if ($arr["h1"][0] != $block)
                    @$arrH[$arr["h1"][0]][] = $block;
            }
        }

        return $arrH;
    }

    public function setFilHorizontal($bool) {
        $this->fillHorizontal = $bool;
    }

    public function addUrlPattern($urlPattern) {

        $this->urlPattern[] = $urlPattern;
    }

    public function getUrlPatterns() {
        return $this->urlPattern;
    }

    public function getTexts($url) {

        $texts = array();

        $html = file_get_html($url);

        if (is_object($html)) {

            foreach ($this->getUrlPatterns() as $pattern) {
                foreach ($html->find($pattern) as $text) {
                    if(isset($text->src))
                         $texts[$pattern." src"][] = $text->src;
                    
                    $text = strip_tags($text);

                    $text = str_replace("|", "", $text);
                    $text = str_replace("\n", "", $text);
                    $text = str_replace("\r", "", $text);
                    $text = str_replace("'", "", $text);
                    $text = str_replace("\"", "", $text);
                    $text = str_replace("&nbsp;", "", $text);
                    if (strlen($text) > 5)
                        $texts[$pattern][] = $text;
                }
            }
        }

        if ($this->fillHorizontal) {
            return $this->horizontal($texts);
        }
        return $texts;
    }

}

/*
Use
$gl = new GrabberText();
$gl->addUrlPattern('.authors');
$gl->addUrlPattern('.quote');

print_r($gl->getTexts("https://www.quotetab.com/quotes/by-richard-bach"));
 * 
 */

