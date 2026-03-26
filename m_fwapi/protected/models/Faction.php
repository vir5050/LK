<?php
/**
 * Faction
 *
 * PUBLIC:				PROTECTED			   PRIVATE
 * ---------------		---------------		 ---------------
 * __construct
 *
 * STATIC:
 * ------------------------------------------
 * model
 *
 */
class Faction extends CActiveRecord
{
    const FACTIONINFO = 0x11FC;

    /** @var string */
    protected $_table = 'mw_factions';

    /**
     * Class default constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return CActiveRecord class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function info($fid)
    {
        $protocol = My::app()->getProtocol();
        $structure = $protocol->loadStructure(CConfig::get('server.version'));
        $protocol->connect2gamedbd();
        $factionInfo = $protocol->write(self::FACTIONINFO, [
            'retcode'=>-1,
            'factionid'=>$fid
        ], [
            'retcode'=>'int',
            'factionid'=>'int'
        ])->read([
            'max'=>'int',
            'retcode'=>'int',
            'cachesize'=>'int',
            'value'=>$structure['FactionInfo']
        ]);
        return (isset($factionInfo['value']) ? $factionInfo['value'] : null);
    }
}