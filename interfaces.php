<?php 

interface Discription {

    const FIRSTNAME = 'JOHN';

    function weight();
    function height();
    function width();
}

interface OtherDiscription {
    const FROMOTHERDESC = "from other discription";
}

class Test implements Discription, OtherDiscription {
    const LASTNAME = "LastName";
    function weight() {
        
    }
    function height(){

    }
    function width(){

    }
}

$object = new Test();
echo Test::FROMOTHERDESC;
?>

