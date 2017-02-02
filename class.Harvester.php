<?php
/*
 * 1. Set destination for harvest (https://www.quotetab.com/authors/e/3) page and symbols
 *  First symbols, after digits
 * If content is the same with previosly then stop
 */


class Harvester {
    
     private $destinationPattern;
     private $maxDigit = 195;

     public function setMaxDigit($maxDigit) {
         $this->maxDigit = $maxDigit;
     }
     
     public function setDestionationPattern($destinationPattern) {
         $this->destinationPattern = $destinationPattern;
     }
     
     public function getDestionationPattern() {
         return $this->destinationPattern;
     }
     
     public function getUrls() {
         return $this->generateUrl();
     }

     
     private function generateUrl() {
         $urls = array();
         $abc = range("a", "z");
         foreach($abc as $sym) {
             for($i=1; $i<=$this->maxDigit; $i++) {
                 $url = str_replace("*", $sym, $this->getDestionationPattern());
                 $url = str_replace("#", $i, $url);
                 $this->urls[$sym][]=$url;
             }
         }
         return $this->urls;
     }
     
     
    
}

// Use # - digit, * - symbol

// $harvester = new Harvester();
// $harvester->setDestionationPattern("https://www.quotetab.com/authors/*/#");
// print_r($harvester->getUrls());
