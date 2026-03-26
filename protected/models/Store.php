<?php
/**
 * Store
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
class Store extends CActiveRecord
{
    /** @var string */
    protected $_table = 'store';

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

    public static function proctype($value = 0, $details = false)
    {
        $i = 0;
        $result = ($details===false) ? array() : '';
        while($value > 0){
            if($value & 0x01 == 0x01){
                if($details){
                    $result .= My::t('app', 'proctype.'.$i).'<br />';
                }else{
                    $result[] = $i;
                }
            }
            $value >>= 1;
            $i++;
        }

        return $result;
    }

    public static function classes($value = 0, $details = false)
    {
        $i = 0;
        $result = ($details===false) ? array() : '';
        while($value > 0){
            if($value & 0x01 == 0x01){
                if($details){
                    $result .= My::t('app', 'classes.'.$i).' ';
                }else{
                    $result[] = $i;
                }
            }
            $value >>= 1;
            $i++;
        }

        return $result;
    }
}
