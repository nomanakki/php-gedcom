<?php

namespace Gedcom\Parser\Note;

require_once __DIR__ . '/../../Record/Note/Ref.php';

/**
 *
 *
 */
class Ref extends \Gedcom\Parser\Component
{
    public static function &parse(\Gedcom\Parser &$parser)
    {
        $record = $parser->getCurrentLineRecord();
        $depth = (int)$record[0];
        
        $identifier = $parser->normalizeIdentifier($record[2]);
        
        $ref = new \Gedcom\Record\Note\Ref();
        $ref->refId = $identifier;
        
        $parser->forward();
        
        while($parser->getCurrentLine() < $parser->getFileLength())
        {
            $record = $parser->getCurrentLineRecord();
            $recordType = strtoupper(trim($record[1]));
            $currentDepth = (int)$record[0];
            
            if($currentDepth <= $depth)
            {
                $parser->back();
                break;
            }
            
            switch($recordType)
            {
                case 'SOUR':
                    $citation = \Gedcom\Parser\SourceCitation::parse($parser);
                    
                    if(is_a($citation, '\Gedcom\Record\SourceCitation\Ref'))
                        $ref->addSourceCitationRef($citation);
                    else
                        $ref->addSourceCitation($citation);
                break;
                
                default:
                    $parser->logUnhandledRecord(get_class() . ' @ ' . __LINE__);
            }
            
            $parser->forward();
        }
        
        return $ref;
    }
}
