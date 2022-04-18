<?php

namespace Drupal\reservation\Services;  

class XMLroute {
    
    public function processXML(){

        $url = 'http://www.chilkatsoft.com/xml-samples/bookstore.xml';
        $xmlUrl = file_get_contents($url);
        $xmlUrlNew = simplexml_load_string($xmlUrl);
        $encoder = json_encode($xmlUrlNew);
        $bookArrays = json_decode($encoder, true);
        $bookArray = $bookArrays["book"] ;

        return $bookArray ;

    }
}



?>