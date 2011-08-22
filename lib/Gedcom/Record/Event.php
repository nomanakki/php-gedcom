<?php

namespace Gedcom\Record;

require_once __DIR__ . '/../Record.php';

class Event extends \Gedcom\Record
{
    public $type = null;
    public $date = null;
    public $place = null;
    public $caus = null;
    public $age = null;
    
    public $addr = null;
    
    public $phon = array();
    
    public $agnc = null;
    
    public $ref = array();
    
    /**
     *
     */
    public function addPhon(\Gedcom\Record\Phon &$phon)
    {
        $this->phon[] = $phon;
    }
    
}
